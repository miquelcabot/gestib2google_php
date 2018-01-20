<?php
require_once 'client.php';
require_once 'api/domainuser.php';
require_once 'api/xmlfile.php';
require_once 'api/domainread.php';

// Get the API client and construct the service object.
$domainuser = new DomainUser(1, "Pep", 
    "Guardiola Sanç", "Guardiola", "Sanç", "", FALSE, TRUE, TRUE, FALSE, ["eso1","eso2"]);

echo $domainuser."\n";
echo $domainuser->user()."\n";
print_r($domainuser->groupswithdomain());
print_r($domainuser->groupswithprefix());
print_r($domainuser->groupswithprefixadded());

$xml = simplexml_load_file("exportacioDadesCentre.xml");
readXmlFile($xml);

readDomainUsers();
?>