<?php
require_once 'client.php';
require_once 'domainuser.php';

function getDomainGroups() {
    $domaingroups = [];
  
    $client = getClient();
    $service = new Google_Service_Directory($client);

    $nextPageToken = NULL;
    $cont = 0;
    do {
        $results = $service->groups->listGroups(array('customer' => 'my_customer',
                                                      'maxResults' => 200,
                                                      'pageToken' => $nextPageToken));
        $nextPageToken = $results->nextPageToken;
        foreach ($results->getGroups() as $group) {
            $cont++;
              
            $domaingroups[str_replace("@".DOMAIN,"",$group->getEMail())] = array (
                    "email" =>   str_replace("@".DOMAIN,"",$group->getEMail()),
                    "id" =>      $group->getId(),
                    "name" =>    $group->getName()
                );
        }
    } while ($nextPageToken);
    // FI Carregam els grups 200 a 200, que és el valor màxim de maxResults, paginant la resta

    sort($domaingroups);
    return $domaingroups;
}

function getDomainGroupsMembers($service, $outputtext=true) {
    if ($outputtext) {
        echo("Loading domain groups...<br>\r\n");
    }
    $domaingroupsmembers = [];

    $nextPageToken = NULL;
    $cont = 0;
    do {
        $results = $service->groups->listGroups(array('customer' => 'my_customer',
                                                      'maxResults' => 200,
                                                      'pageToken' => $nextPageToken));
        $nextPageToken = $results->nextPageToken;                                         

        foreach ($results->getGroups() as $group) {
            $cont++;
            // We read the members of this group
            if ($outputtext) {
                echo("Loading members of '".str_replace("@".DOMAIN,"",$group->getEMail())."' group...<br>\r\n");
            }
            
            $membersgroup = [];
            
            $resultsGr = $service->members->listMembers($group->getId(), array('maxResults' => 1000000));
            foreach($resultsGr->getMembers() as $member) {
                array_push($membersgroup, $member->getEMail());
            }

            $domaingroupsmembers[str_replace("@".DOMAIN,"",$group->getEMail())] = array (
                    "email" =>   str_replace("@".DOMAIN,"",$group->getEMail()),
                    "id" =>      $group->getId(),
                    "name" =>    $group->getName(),
                    "members" => $membersgroup
                );
        }
    } while ($nextPageToken);
    // FI Carregam els grups 200 a 200, que és el valor màxim de maxResults, paginant la resta
    
    if ($outputtext) {
        echo($cont." groups loaded<br>\r\n");
    }
  
    ksort($domaingroupsmembers);
  
    return $domaingroupsmembers;
}

function getDomainUsers($service, $domaingroupsmembers, $outputtext=true) {
    if ($outputtext) {
        echo("Loading domain users...<br>\r\n");
    }
    $domainusers = [];
  
    // INICI Carregam els usuaris 500 a 500, que és el valor màxim de maxResults, paginant la resta
    $nextPageToken = NULL;
    $cont = 0;
    $userWithoutCode = 0;
    do {
        $results = $service->users->listUsers(array('customer' => 'my_customer', 
                                                     'maxResults' => 500, 
                                                     'orderBy' => 'email',
                                                     'pageToken' => $nextPageToken));
        $nextPageToken = $results->nextPageToken;
        foreach ($results->getUsers() as $user) {
            $cont++;

            $id = NULL;
            $withoutcode = FALSE;
             
            if (isset($user['externalIds']) && isset($user['externalIds'][0]['value']) && !empty($user['externalIds'][0]['value'])) {
                $id = $user['externalIds'][0]['value'];
            } else {
                $userWithoutCode++;
                $id = "WITHOUTCODE".$userWithoutCode;
                $withoutcode = TRUE;
            }
          
            $member = [];                // Afegim tots els grups del que és membre
            foreach ($domaingroupsmembers as $key => $groupname) {
                foreach ($groupname['members'] as $email) {
                    if ($user['primaryEmail']==$email) {
                        array_push($member, $key);
                    }
                }
            }

            // Cercam si hi ha IDs duplicats. No n'hi pot haver
            if (array_key_exists($id, $domainusers)) {
                die("ERROR: Duplicated ID in domain: ".$id." (".$user['primaryEmail']." and ".$domainusers[$id]->email().")<br>");
            }

            $domainusers[$id] = new DomainUser(
                $id,
                $user['name']['givenName'], 
                $user['name']['familyName'],
                NULL,                  // surname 1
                NULL,                  // surname 2
                $user['primaryEmail'], // domainemail
                $user['suspended'],    // suspended
                strpos(mb_strtolower($user['orgUnitPath'],'UTF-8'), "professor") !== FALSE,  // teacher 
                $withoutcode,          // withoutcode
                $member,               // groups
                NULL,                  // expedient
                $user['orgUnitPath'],  // organizationalUnit
                $user['lastLoginTime'] // lastLoginTime
              );
        }
    } while ($nextPageToken);
    // FI Carregam els usuaris 500 a 500, que és el valor màxim de maxResults, paginant la resta
 
    if ($outputtext) {
        echo($cont." users loaded<br>\r\n");
    }
    return $domainusers;
}

function readDomainUsers($outputtext=true) {
    $client = getClient();
    $service = new Google_Service_Directory($client);
  
    $domaingroupsmembers = getDomainGroupsMembers($service, $outputtext);
    $domainusers = getDomainUsers($service, $domaingroupsmembers, $outputtext);
  
    return array(
        "domainusers" => $domainusers,
        "domaingroupsmembers" => $domaingroupsmembers);
}
?>