<?php
require_once 'domainuser.php';

function getgroupemails($name, $isstudent) {
    $name = strtolower($name);
    $email = [];
    $curs = filter_var($name, FILTER_SANITIZE_NUMBER_INT); // We get the course from the numbers in the string
    $grup = substr($name, -1); // We get the group name from the last char of the string
  
    if (strpos($name, "batx") !== FALSE) {
        array_push($email, "bat".$curs.$grup);
    } else if (strpos($name, "eso") !== FALSE) {
        array_push($email, "eso".$curs.$grup);
    } else if (strpos($name, "ifc21") !== FALSE) {
        if ($grup=="a") {
            array_push($email, "smx1");
        } else if ($grup=="b") {
            array_push($email, "smx2");
        } else if (($grup=="c") && $isstudent) {
            // Si és estudiant, feim que grup C de SMX sigui de 1r i 2n
            array_push($email, "smx1");
            array_push($email, "smx2");
        }
    } else if (strpos($name, "ifc31") !== FALSE) {
        if ($grup=="a") {
            array_push($email, "asix1");
        } else if ($grup=="b") {
            array_push($email, "asix2");
        } else if (($grup=="c") && $isstudent) {
            // Si és estudiant, feim que grup C de ASIX sigui de 1r i 2n
            array_push($email, "asix1");
            array_push($email, "asix2");
        }
    }
    return $email;
}

function readXmlGroups($xmlfile) {
    echo("Loading XML groups...\r\n");
    $xmlgroups = [];
    $xmltutors = [];
    
    foreach ($xmlfile->CURSOS->CURS as $curs) {
        foreach ($curs->GRUP as $grup) {
            $xmlgroups[strval($grup['codi'])] = $curs['descripcio']." ".$grup['nom'];
            array_push($xmltutors, $grup['tutor']);
            if (!empty($grup['tutor2'])) {
                array_push($xmltutors, $grup['tutor2']);
            }        
        }
    }
  return array($xmlgroups, array_unique($xmltutors));
}


function readXmlTimeTable($xmlfile, $xmlgroups) {
    echo("Loading XML timetable...\r\n");
    $xmltimetable = [];
    
    foreach ($xmlfile->HORARIP->SESSIO as $sessio) {
        $emailsTeachers = [];
        
        if (isset($xmlgroups[strval($sessio['grup'])])) {
            $xmlgroup = $xmlgroups[strval($sessio['grup'])];
            $emailsTeachers = getgroupemails($xmlgroup, FALSE);
            //array_push($emailsTeachers, getgroupemails($xmlgroup, FALSE));
        }
      
        if (isset($xmltimetable[strval($sessio['professor'])])) {
            $timetable = $xmltimetable[strval($sessio['professor'])];
            $timetable = array_unique(array_merge($timetable, $emailsTeachers));
            $xmltimetable[strval($sessio['professor'])] = $timetable;
        } else {
            $xmltimetable[strval($sessio['professor'])] = $emailsTeachers;
        }
        
    }
    
    return $xmltimetable;
}

function readXmlUsers($xmlfile, $xmlgroups, $xmltutors, $xmltimetable) {
    echo("Loading XML users...\r\n");
    $xmlusers = [];
    
    // Afegim els alumnes
    foreach ($xmlfile->ALUMNES->ALUMNE as $student) {
        $emailsstudent = [];
        if (isset($xmlgroups[strval($student['grup'])])) {
            $xmlgroup = $xmlgroups[strval($student['grup'])];
            $emailsstudent = getgroupemails($xmlgroup, TRUE);
        }
         
        $xmlusers[strval($student['codi'])] = new DomainUser(
            strval($student['codi']),
            ucwords(strtolower($student['nom'])), 
            ucwords(strtolower($student['ap1']." ".$student['ap2'])),
            ucwords(strtolower($student['ap1'])), 
            ucwords(strtolower($student['ap2'])), 
            NULL,            // domainemail
            FALSE,           // suspended
            FALSE,           // teacher 
            FALSE,           // tutor
            FALSE,           // withoutcode
            $emailsstudent   // groups
        );
    }
    
    // Afegim els professors
    foreach ($xmlfile->PROFESSORS->PROFESSOR as $teacher) {
        $emailsteacher = [];
        if (isset($xmltimetable[strval($teacher['codi'])])) {
            $emailsteacher = $xmltimetable[strval($teacher['codi'])];
        }
        
        $xmlusers[strval($teacher['codi'])] = new DomainUser(
            strval($teacher['codi']),
            ucwords(strtolower($teacher['nom'])), 
            ucwords(strtolower($teacher['ap1']." ".$teacher['ap2'])),
            ucwords(strtolower($teacher['ap1'])), 
            ucwords(strtolower($teacher['ap2'])), 
            NULL,            // domainemail
            FALSE,           // suspended
            TRUE,            // teacher 
            in_array(strval($teacher['codi']), $xmltutors), //tutor
            FALSE,           // withoutcode
            $emailsteacher   // groups
        );
    }
    return $xmlusers;
}

function readXmlFile($xmlfile) {
    $readgroups = readXmlGroups($xmlfile);
    $xmlgroups = $readgroups[0];
    $xmltutors = $readgroups[1];

    $xmltimetable = readXmlTimeTable($xmlfile, $xmlgroups);
    $xmlusers = readXmlUsers($xmlfile, $xmlgroups, $xmltutors, $xmltimetable);
  
    return $xmlusers; 
}
?>