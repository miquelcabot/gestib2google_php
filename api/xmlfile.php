<?php
require_once 'config.php';

function readXmlFile($xmlfile, $domain) {
    var groupstutors = readXmlGroups(xmlfile);
    var xmltimetable = readXmlTimeTable(xmlfile, groupstutors.xmlgroups);
    var xmlusers = readXmlUsers(xmlfile, groupstutors.xmlgroups, 
        groupstutors.xmltutors, xmltimetable, domain);

    return xmlusers;
}
?>