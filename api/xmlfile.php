<?php
require_once 'domainuser.php';

function getgroupemails($name, $isstudent, $istutor) {
    $name = mb_strtolower($name,'UTF-8');
    $email = [];
    $curs = filter_var($name, FILTER_SANITIZE_NUMBER_INT); // We get the course from the numbers in the string
    $grup = mb_substr($name, -1); // We get the group name from the last char of the string
  
    if ($isstudent) {
        $pre_group = STUDENTS_GROUP_PREFIX;
    } else if ($istutor) {
        $pre_group = TUTORS_GROUP_PREFIX;
    } else {
        $pre_group = TEACHERS_GROUP_PREFIX;
    }

    if (strpos($name, "batx") !== FALSE) {
        array_push($email, $pre_group."bat".$curs.$grup);
    } else if (strpos($name, "eso") !== FALSE) {
        array_push($email, $pre_group."eso".$curs.$grup);
    } else {
        // Formació Professional
        $fp_name = explode(" ",$name)[0];
        if (array_key_exists($fp_name, FP_GROUP_NAME_CONVERSION)) {
            if (array_key_exists($grup, FP_GROUP_NAME_CONVERSION[$fp_name]["groups"])) {
                $fp_converted_name = FP_GROUP_NAME_CONVERSION[$fp_name]["name"];
                if ($isstudent) {
                    $group_names =FP_GROUP_NAME_CONVERSION[$fp_name]["groups"][$grup]["student"];
                } else {
                    $group_names =FP_GROUP_NAME_CONVERSION[$fp_name]["groups"][$grup]["teacher"];
                }
                foreach ($group_names as $group_name) {
                    array_push($email, $pre_group.$fp_converted_name.$group_name);
                }
            } else {
                echo("WARNING: Group ".$fp_name."-".$grup." not configured as FP_GROUP_NAME_CONVERSION in config.php<br>");
            }
        } else {
            echo("WARNING: Group ".$fp_name." not configured as FP_GROUP_NAME_CONVERSION in config.php<br>");
        }
    }
    
    /*if (strpos($name, "ifc21") !== FALSE) {
        if ($grup=="a") {
            array_push($email, $pre_group."smx1");
        } else if ($grup=="b") {
            array_push($email, $pre_group."smx2");
        } else if (($grup=="c") && $isstudent) {
            // Si és estudiant, feim que grup C de SMX sigui de 1r i 2n
            array_push($email, $pre_group."smx1");
            array_push($email, $pre_group."smx2");
        }
    } else if (strpos($name, "ifc31") !== FALSE) {
        if ($grup=="a") {
            array_push($email, $pre_group."asix1");
        } else if ($grup=="b") {
            array_push($email, $pre_group."asix2");
        } else if (($grup=="c") && $isstudent) {
            // Si és estudiant, feim que grup C de ASIX sigui de 1r i 2n
            array_push($email, $pre_group."asix1");
            array_push($email, $pre_group."asix2");
        }
    }*/
    return $email;
}

function readXmlGroups($xmlfile) {
    echo("Loading XML groups...<br>\r\n");
    $xmlgroups = [];
    $xmltutors = [];
    
    foreach ($xmlfile->CURSOS->CURS as $curs) {
        foreach ($curs->GRUP as $grup) {
            $xmlgroups[strval($grup['codi'])] = $curs['descripcio']." ".$grup['nom'];
            if (!array_key_exists(strval($grup['tutor']), $xmltutors)) {
                $xmltutors[strval($grup['tutor'])] = [];
            }
            array_push($xmltutors[strval($grup['tutor'])], $curs['descripcio']." ".$grup['nom']);
            $xmltutors[strval($grup['tutor'])] = array_unique($xmltutors[strval($grup['tutor'])]);
            if (!empty($grup['tutor2'])) {
                if (!array_key_exists(strval($grup['tutor2']), $xmltutors)) {
                    $xmltutors[strval($grup['tutor2'])] = [];
                }
                array_push($xmltutors[strval($grup['tutor2'])], $curs['descripcio']." ".$grup['nom']);
                $xmltutors[strval($grup['tutor2'])] = array_unique($xmltutors[strval($grup['tutor2'])]);
            }        
        }
    }
  return array($xmlgroups, $xmltutors);
}

function readXmlTimeTable($xmlfile, $xmlgroups) {
    echo("Loading XML timetable...<br>\r\n");
    $xmltimetable = [];
    
    foreach ($xmlfile->HORARIP->SESSIO as $sessio) {
        $emailsTeachers = [];
        
        if (isset($xmlgroups[strval($sessio['grup'])])) {
            $xmlgroup = $xmlgroups[strval($sessio['grup'])];
            $emailsTeachers = getgroupemails($xmlgroup, FALSE, FALSE);
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
    echo("Loading XML users...<br>\r\n");
    $xmlusers = [];
    
    // Afegim els alumnes
    foreach ($xmlfile->ALUMNES->ALUMNE as $student) {
        $emailsstudent = [];
        if (isset($xmlgroups[strval($student['grup'])])) {
            $xmlgroup = $xmlgroups[strval($student['grup'])];
            $emailsstudent = getgroupemails($xmlgroup, TRUE, FALSE);
        }
         
        $xmlusers[strval($student['codi'])] = new DomainUser(
            strval($student['codi']),
            mb_convert_case(trim(mb_strtolower($student['nom'],'UTF-8')), MB_CASE_TITLE, "UTF-8"), 
            mb_convert_case(trim(mb_strtolower($student['ap1']." ".$student['ap2'],'UTF-8')), MB_CASE_TITLE, "UTF-8"),
            mb_convert_case(trim(mb_strtolower($student['ap1'],'UTF-8')), MB_CASE_TITLE, "UTF-8"), 
            mb_convert_case(trim(mb_strtolower($student['ap2'],'UTF-8')), MB_CASE_TITLE, "UTF-8"), 
            NULL,            // domainemail
            FALSE,           // suspended
            FALSE,           // teacher 
            FALSE,           // withoutcode
            $emailsstudent,  // groups
            strval($student['expedient']), // expedient
            NULL,            // organizationalUnit
            NULL             // lastLoginTime
        );
    }
    
    // Afegim els professors
    foreach ($xmlfile->PROFESSORS->PROFESSOR as $teacher) {
        $emailsteacher = [];
        if (isset($xmltimetable[strval($teacher['codi'])])) {
            $emailsteacher = $xmltimetable[strval($teacher['codi'])];
        }
        if (isset($teacher['departament']) && array_key_exists(strval($teacher['departament']), DEPARTMENT_NUMBER_TO_NAME)) {
            array_push($emailsteacher, DEPARTMENT_GROUP_PREFIX.DEPARTMENT_NUMBER_TO_NAME[strval($teacher['departament'])]);
        }
        // Si és tutor, estarà a l'array associatiu $xmltutors
        if (array_key_exists(strval($teacher['codi']), $xmltutors)) {
            foreach ($xmltutors[strval($teacher['codi'])] as $tutorgroup) {
                foreach (getgroupemails($tutorgroup, FALSE, TRUE) as $tutorgroupname) {
                    array_push($emailsteacher, $tutorgroupname);
                }
            }
        }
        
        $xmlusers[strval($teacher['codi'])] = new DomainUser(
            strval($teacher['codi']),
            ucwords(trim(mb_strtolower($teacher['nom'],'UTF-8'))), 
            ucwords(trim(mb_strtolower($teacher['ap1']." ".$teacher['ap2'],'UTF-8'))),
            ucwords(trim(mb_strtolower($teacher['ap1'],'UTF-8'))), 
            ucwords(trim(mb_strtolower($teacher['ap2'],'UTF-8'))), 
            NULL,            // domainemail
            FALSE,           // suspended
            TRUE,            // teacher 
            FALSE,           // withoutcode
            $emailsteacher,  // groups
            NULL,            // expedient
            NULL,            // organizationalUnit
            NULL             // lastLoginTime
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