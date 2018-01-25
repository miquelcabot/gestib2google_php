<?php
require_once 'api/domainuser.php';
require_once 'api/xmlfile.php';
require_once 'api/domainread.php';
require_once 'api/domainoperations.php';

// Get the API client and construct the service object.
/*$domainuser = new DomainUser(1, "Pep", 
    "Guardiola Sanç", "Guardiola", "Sanç", "", FALSE, TRUE, TRUE, FALSE, ["eso1","eso2"]);

echo $domainuser."\n";
echo $domainuser->user()."\n";
print_r($domainuser->groupswithdomain());
print_r($domainuser->groupswithprefix());
print_r($domainuser->groupswithprefixadded());*/


$xml = simplexml_load_file("exportacioDadesCentre.xml");
$xmlusers = readXmlFile($xml);

$domainusers = readDomainUsers();

$cont = applyDomainChanges($xmlusers, $domainusers, FALSE);

echo($cont['deleted']." users will be suspended\r\n");
echo($cont['created']." users will be created\r\n");
echo($cont['activated']." users will be activated\r\n");
echo($cont['groupsmodified']." users will change their group membership\r\n");


?>