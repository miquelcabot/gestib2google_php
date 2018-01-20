<?php
function getDomainGroups($service) {
    echo("Loading domain groups...\r\n");
    $domaingroups = [];

    // Print the first 10 users in the domain.
    $results = $service->groups->listGroups(array('customer' => 'my_customer','maxResults' => 1000000));

    $cont = 0;
    foreach ($results->getGroups() as $group) {
        $cont++;
        // We read the members of this group
        echo("Loading members of '".str_replace("@".DOMAIN,"",$group->getEMail())."' group...\r\n");
          
        $membersgroup = [];
        
        $resultsGr = $service->members->listMembers($group->getId(), array('maxResults' => 1000000));
        foreach($resultsGr->getMembers() as $member) {
            array_push($membersgroup, $member->getEMail());
        }

        $domaingroups[str_replace("@".DOMAIN,"",$group->getEMail())] = array (
                "id" =>      $group->getId(),
                "name" =>    $group->getName(),
                "members" => $membersgroup
            );
    }
    echo($cont." groups loaded\r\n");
    return $domaingroups;
}

function getDomainUsers($service, $domaingroups) {
    echo("Loading domain users...\r\n");
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
             
            if (isset($user['externalIds']) && isset($user['externalIds'][0]['value'])) {
                $id = $user['externalIds'][0]['value'];
            } else {
                $userWithoutCode++;
                $id = "WITHOUTCODE".$userWithoutCode;
                $withoutcode = TRUE;
            }
          
            $member = [];                // Afegim tots els grups del que és membre
            foreach ($domaingroups as $key => $groupname) {
                foreach ($groupname['members'] as $email) {
                    if ($user['primaryEmail']==$email) {
                        array_push($member, $key);
                    }
                }
            }
            $istutor = in_array("tutors", $member); // Comprovam si és tutor

            $domainusers[$id] = new DomainUser(
                $id,
                $user['name']['givenName'], 
                $user['name']['familyName'],
                NULL,                  // surname 1
                NULL,                  // surname 2
                $user['primaryEmail'], // domainemail
                $user['suspended'],    // suspended
                strpos(strtolower($user['orgUnitPath']), "professor") !== FALSE,  // teacher 
                $istutor,              // tutor
                $withoutcode,          // withoutcode
                $member                // groups
              );
        }
    } while ($nextPageToken);
    // FI Carregam els usuaris 500 a 500, que és el valor màxim de maxResults, paginant la resta
 
    echo($cont." users loaded\r\n");
    return $domainusers;
}

function readDomainUsers() {
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Directory($client);
  
    $domaingroups = getDomainGroups($service);
    $domainusers = getDomainUsers($service, $domaingroups);
  
    return $domainusers;
}
?>