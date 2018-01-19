<?php
require_once 'api/domainuser.php';

// Get the API client and construct the service object.
$domainuser = new DomainUser("iesemilidarder.com", 1, "Pep", 
    "Guardiola Sanç", "Guardiola", "Sanç", "", FALSE, TRUE, TRUE, FALSE, ["eso1","eso2"]);

echo $domainuser."\n";
echo $domainuser->user()."\n";
print_r($domainuser->groupswithdomain());
print_r($domainuser->groupswithprefixadded());

?>