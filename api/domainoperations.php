<?php
require_once 'client.php';
require_once 'domainuser.php';

function deleteDomainUsers($xmlusers, $domainusers, $apply, $service) {
    $cont = 0;
    echo("Deleting domain users...<br>\r\n");
    foreach ($domainusers as $domainuser) {     // For every domain user
        if (!$domainuser->suspended && !$domainuser->withoutcode) {
            if (!array_key_exists($domainuser->id, $xmlusers)) {
                echo("SUSPEND --> ".$domainuser."<br>\r\n");
                $cont++;
                if ($apply) {
                    // Suspend domain user
                    $userObj = new Google_Service_Directory_User(
                        array(
                            'suspended' => TRUE
                        )
                    );
                    $service->users->update($domainuser->email(), $userObj);
                    // Remove from all groups
                    foreach ($domainuser->groupswithdomain() as $groupwithdomain) {
                        // https://developers.google.com/admin-sdk/directory/v1/reference/members/delete
                        $service->members->delete($groupwithdomain, $domainuser->email());
                    }
                }
            }
        }
    }
    return $cont;
}

function addDomainUsers($xmlusers, $domainusers, $apply, $service) {
    $contc = 0;
    $conta = 0;
    $contg = 0;
    $conto = 0;
  
    echo("Adding domain users...<br>\r\n");
    foreach ($xmlusers as $xmluser) {     // For every XML user
        if (!array_key_exists($xmluser->id, $domainusers)) {  // It doesn't exists in domain
            // Email pot ser repetit, comprovar-ho!!
            if (!$xmluser->teacher) {  
                foreach ($domainusers as $d_user) {
                    // Si hi ha un usuari del domini amb les 3 primeres lletres iguals
                    if (substr($d_user->email(),0,3)===substr($xmluser->email(),0,3)) {
                        $n_email_dom = intval(substr($d_user->email(),3,5));
                        $n_email_xml = intval(substr($xmluser->email(),3,5));
                        if ($n_email_dom>=$n_email_xml) {
                            $n_email = $n_email_dom+1;
                            $xmluser->domainemail = substr($xmluser->email(),0,3).str_pad($n_email, 2, '0', STR_PAD_LEFT)."@".DOMAIN;
                        }
                    }
                }
            }
            // Afegim l'usuari que cream al diccionari de usuaris del domini
            $domainusers[$xmluser->id] = new DomainUser(
                $xmluser->id,
                $xmluser->name, 
                $xmluser->surname1, 
                $xmluser->surname2,
                $xmluser->surname,
                $xmluser->email(),     // domainemail
                $xmluser->suspended,   // suspended
                $xmluser->teacher,     // teacher
                $xmluser->withoutcode, // withoutcode
                $xmluser->groups,      // groups
                NULL,                  // expedient
                NULL                   // organizationalUnit
                );
            echo("CREATE --> ".$xmluser."<br>\r\n");
            $contc++;
            if ($apply) {
                try {
                    // Create domain user
                    // https://developers.google.com/admin-sdk/reseller/v1/codelab/end-to-end
                    $userObj = new Google_Service_Directory_User(array(
                            'primaryEmail' => $xmluser->email(), 
                            'name' => array("givenName" => $xmluser->name, "familyName" => $xmluser->surname), 
                            'orgUnitPath' => ($xmluser->teacher?'/Professorat':'/Alumnat'),
                            'externalIds' => array(array("type" => 'organization', "value" => $xmluser->id)),
                            'suspended' => FALSE,
                            'changePasswordAtNextLogin' => TRUE,
                            'password' => DEFAULT_PASSWORD //Default password
                        ));
                    $service->users->insert($userObj);
                    // Insert all TEACHERS_GROUP_PREFIX,  STUDENTS_GROUP_PREFIX and TUTORS_GROUP_PREFIX groups
                    foreach ($xmluser->groupswithprefixadded() as $gr) {
                        // https://developers.google.com/admin-sdk/directory/v1/reference/members/insert
                        $memberObj = new Google_Service_Directory_Member(array(
                            'email' => $xmluser->email()));
                        $service->members->insert($gr."@".DOMAIN, $memberObj);
                    }
                } catch(Exception $e) {
                    $error = json_decode($e->getMessage());
                    echo('ERROR: ' .$error->error->message."<br>\r\n");
                }
            }
        } else {
            $domainuser = $domainusers[$xmluser->id];
            if ($domainuser->suspended) {
                echo("ACTIVATE --> ".$xmluser."<br>\r\n");
                $conta++;
                if ($apply) {
                    // Activate domain user
                    $userObj = new Google_Service_Directory_User(array(
                            'suspended' => FALSE
                        ));
                    $service->users->update($domainuser->email(), $userObj);
                }
            }
            // Tant si estava actiu com no, existeix, i per tant, actualitzar 
            // els grups TEACHERS_GROUP_PREFIX, STUDENTS_GROUP_PREFIX i  TUTORS_GROUP_PREFIX
            $creategroups = array_diff($xmluser->groupswithprefixadded(), $domainuser->groupswithprefix());
            $deletegroups = array_diff($domainuser->groupswithprefix(), $xmluser->groupswithprefixadded());
            if (!$domainuser->suspended && (count($creategroups)>0 || count($deletegroups)>0)) {
                if (count($creategroups)>0) {
                    echo("CREATE GROUPS --> ".$domainuser->surname.", ".$domainuser->name.
                        " (".$domainuser->email().") [".implode(", ",$creategroups)."]<br>\r\n");
                }
                if (count($deletegroups)) {
                    echo("DELETE GROUPS --> ".$domainuser->surname.", ".$domainuser->name.
                        " (".$domainuser->email().") [".implode(", ",$deletegroups)."]<br>\r\n");
                }
                $contg++;
                if ($apply) {
                    // Actualitzam els grups de l'usuari
                    $memberObj = new Google_Service_Directory_Member(array(
                        'email' => $domainuser->email()));
                    foreach ($creategroups as $gr) {
                        // https://developers.google.com/admin-sdk/directory/v1/reference/members/insert
                        $service->members->insert($gr."@".DOMAIN, $memberObj);
                    }
                    foreach ($deletegroups as $gr) {
                        // https://developers.google.com/admin-sdk/directory/v1/reference/members/delete
                        $service->members->delete($gr."@".DOMAIN, $domainuser->email());
                    }
                }
            }
            // Actualitzar unitat organtizativa
            if ($domainuser->organizationalUnit != ($xmluser->teacher?'/Professorat':'/Alumnat')) {
                echo("CHANGE ORGANIZATIONAL UNIT --> ".$domainuser->surname.", ".$domainuser->name.
                    " (".$domainuser->email().") [".($xmluser->teacher?'/Professorat':'/Alumnat')."]<br>\r\n");
                $conto++;
                if ($apply) {
                    $userObj = new Google_Service_Directory_User(
                        array(
                            'orgUnitPath' => ($xmluser->teacher?'/Professorat':'/Alumnat')
                        )
                    );
                    $service->users->update($domainuser->email(), $userObj);
                }
            }
        }
    }

    return array("created" => $contc,
                 "activated" => $conta,
                 "groupsmodified" => $contg,
                 "orgunitmodified" => $conto);
}

function applyDomainChanges($xmlusers, $domainusers, $apply) {
    $client = getClient();
    $service = new Google_Service_Directory($client);
  
    $contd = deleteDomainUsers($xmlusers, $domainusers, $apply, $service);
    $cont = addDomainUsers($xmlusers, $domainusers, $apply, $service);
    return array("deleted" => $contd,
                 "created" => $cont['created'],
                 "activated" => $cont['activated'],
                 "groupsmodified" => $cont['groupsmodified'],
                 "orgunitmodified" => $cont['orgunitmodified']);
}
?>