<?php
function deleteDomainUsers($xmlusers, $domainusers, $apply, $service) {
    $cont = 0;
  
    echo("Deleting domain users...\r\n");
    foreach ($domainusers as $domainuser) {     // For every domain user
        if (!$domainuser->suspended && !$domainuser->withoutcode) {
            if (!array_key_exists($domainuser->id, $xmlusers)) {
                echo("SUSPEND --> ".$domainuser."\r\n");
                $cont++;
            /*
                if (apply) {
                    // Suspend domain user
                    service.users.update({
                        auth: auth,
                        userKey: $user.email(), 
                        resource: {
                            suspended: true
                        }
                    });
                    // Remove from all groups
                    groupswithdomain = $user.groupswithdomain();
                    for (i in groupswithdomain) {
                        service.members.delete({
                            auth: auth,
                            groupKey: groupswithdomain[i], 
                            memberKey: $user.email()
                        });
                    }
                }*/
            }
        }
    }
    return $cont;
}

function addDomainUsers($xmlusers, $domainusers, $apply, $service) {
    $contc = 0;
    $conta = 0;
    $contg = 0;
  
    echo("Adding domain users...\r\n");
    foreach ($xmlusers as $xmluser) {     // For every XML user
        if (!array_key_exists($xmluser->id, $domainusers)) {  // It doesn't exists in domain
            // Email pot ser repetit, comprovar-ho!!
            if (!$xmluser->teacher) {            
/*
                for (d_user in domainusers) {
                    // Si hi ha un usuari del domini amb les 3 primeres lletres iguals
                    if (domainusers[d_user].email().startsWith(xmluser.email().substring(0,3))) {
                        var n_email_dom = parseInt(domainusers[d_user].email().substring(3,5));
                        var n_email_xml = parseInt(xmluser.email().substring(3,5));
                        if (n_email_dom>=n_email_xml) {
                            var n_email = n_email_dom+1;
                            xmluser.domainemail = xmluser.email().substring(0,3)+domainuser.pad(n_email,2)+"@"+domain;
                        }
                    }
                }
*/       
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
                $xmluser->tutor,       // tutor
                $xmluser->withoutcode, // withoutcode
                $xmluser->groups       // groups
                );
            echo("CREATE --> ".$xmluser."\r\n");
            $contc++;
              /*
            if (apply) {
                // Create domain user
                // https://developers.google.com/admin-sdk/reseller/v1/codelab/end-to-end
                service.users.insert({
                    auth: auth,
                    resource: { 
                        primaryEmail: xmluser.email(), 
                        name: { givenName: xmluser.name, familyName: xmluser.surname }, 
                        orgUnitPath: (xmluser.teacher?'/Professorat':'/Alumnat'),
                        externalIds: [{ type: 'organization', value: xmluser.id }], 
                        suspended: false,
                        changePasswordAtNextLogin: true,
                        password: "12345678"
                    }   //Default password
                }, function(err, response) {
                    if (err) {
                        console.log('The API returned an error: ' + err);
                        return;
                    }
                });
                // Insert all "ee.",  "alumnat." and "tutors" groups
                for (gr in xmluser.groupswithprefixadded()) {
                    // https://developers.google.com/admin-sdk/directory/v1/reference/members/insert
                    service.members.insert({
                        auth: auth,
                        groupKey: xmluser.groupswithprefixadded()[gr]+"@"+domain, 
                        resource: {
                            email: xmluser.email()
                        }
                    }, function(err, response) {
                        if (err) {
                            console.log('The API returned an error: ' + err);
                            return;
                        }
                    });
                }
            }
              */
        } else {
            $domainuser = $domainusers[$xmluser->id];
            if ($domainuser->suspended) {
                echo("ACTIVATE --> ".$xmluser."\r\n");
                $conta++;
              /*
                if (apply) {
                    // Suspend domain user
                    service.users.update({
                        auth: auth,
                        userKey: domain_user.email(), 
                        resource: {
                            suspended: true
                        }
                    }, function(err, response) {
                        if (err) {
                            console.log('The API returned an error: ' + err);
                            return;
                        }
                    });
                }
              */
            }
            // Tant si estava actiu com no, existeix, i per tant, actualitzar 
            // els grups "ee.", "alumnat." i  "tutors"
            // TODO: Insert and delete "tutors" group
            $creategroups = array_diff($xmluser->groupswithprefixadded(), $domainuser->groupswithprefix());
            $deletegroups = array_diff($domainuser->groupswithprefix(), $xmluser->groupswithprefixadded());
            if (!$domainuser->suspended && (count($creategroups)>0 || count($deletegroups)>0)) {
                if (count($creategroups)>0) {
                    echo("CREATE GROUPS --> ".$domainuser->surname.", ".$domainuser->name.
                        " (".$domainuser->email().") [".implode(", ",$creategroups)."]\r\n");
                }
                if (count($deletegroups)) {
                    echo("DELETE GROUPS --> ".$domainuser->surname.", ".$domainuser->name.
                        " (".$domainuser->email().") [".implode(", ",$deletegroups)."]\r\n");
                }
                $contg++;
                if ($apply) {
                  
                }
            }
        }
    }
  /*



            if (((creategroups.length>0) || (deletegroups.length>0))
                        && (!domain_user.suspended)) {
                if (creategroups.length>0) {
                    console.log("CREATE GROUPS --> "+domain_user.surname+", "+domain_user.name+
                        " ("+domain_user.email()+") ["+creategroups+"]");
                }
                if (deletegroups.length>0) {
                    console.log("DELETE GROUPS --> "+domain_user.surname+", "+domain_user.name+
                        " ("+domain_user.email()+") ["+deletegroups+"]");
                }
                contg++;
                if (apply) {
                    // Actualitzam els grups de l'usuari
                    for (gr in creategroups) {
                        // https://developers.google.com/admin-sdk/directory/v1/reference/members/insert
                        service.members.insert({
                            auth: auth,
                            groupKey: creategroups[gr]+"@"+domain, 
                            body: {
                                email: domain_user.email()
                            }
                        }, function(err, response) {
                            if (err) {
                                console.log('The API returned an error: ' + err);
                                return;
                            }
                        });
                    }
                    for (gr in deletegroups) {
                        // https://developers.google.com/admin-sdk/directory/v1/reference/members/delete
                        service.members.delete({
                            auth: auth,
                            groupKey: deletegroups[gr]+"@"+domain, 
                            resource: {
                                email: domain_user.email()
                            }
                        }, function(err, response) {
                            if (err) {
                                console.log('The API returned an error: ' + err);
                                return;
                            }
                        });
                    }
                }
            }
     */
    return array("created" => $contc,
                 "activated" => $conta,
                 "groupsmodified" => $contg);
}

function applyDomainChanges($xmlusers, $domainusers, $apply, $service) {
    $contd = deleteDomainUsers($xmlusers, $domainusers, $apply, $service);
    $cont = addDomainUsers($xmlusers, $domainusers, $apply, $service);
    return array("deleted" => $contd,
                 "created" => $cont['created'],
                 "activated" => $cont['activated'],
                 "groupsmodified" => $cont['groupsmodified']);
}
?>