<?php
    include 'login.php';
    require_once 'api/client.php';
    require_once 'api/domainuser.php';
    require_once 'api/domainread.php';
    require_once 'api/domainoperations.php';
  
    $onlyteachers = isset($_REQUEST['onlyteacherscsv']);
    $selectedgroup = isset($_REQUEST['groupcsv'])?rtrim($_REQUEST['groupcsv'], '.'):'';

    function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w'); 
        // loop over the input array
        foreach ($array as $line) { 
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter); 
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    }

    $sheetusers = [];

    $filetitle = 'resetpasswords'.date("Y-m-d H:i:s");
    
    $readdomainusers = readDomainUsers(false);
    $domainusers = $readdomainusers['domainusers'];
    
    foreach($domainusers as $key=>$domainuser) {
        if (!$domainuser->suspended) {
            if (!$onlyteachers || $domainuser->teacher) {
                if (empty($selectedgroup)) {
                    $group_ok = TRUE;
                } else {
                    $group_ok = FALSE;
                    foreach ($domainuser->groups as $group) {
                        if ((strpos($group, $selectedgroup) !== FALSE && strpos($group, $selectedgroup) == 0)) {
                            $group_ok = TRUE;
                        }
                }
                }
                if ($group_ok) {
                    $usergroup = "";
                    if ($domainuser->teacher) {
                        $usergroup = "Professorat";
                    } else {
                        foreach ($domainuser->groups as $group) {
                            if (strpos($group, STUDENTS_GROUP_PREFIX) !== FALSE && strpos($group, STUDENTS_GROUP_PREFIX) == 0) {
                                $usergroup = substr($group, strlen(STUDENTS_GROUP_PREFIX));
                            }
                        }           
                    }
                    if ($usergroup) {
                        array_push($sheetusers, array($domainuser->domainemail, DEFAULT_PASSWORD, $usergroup, "YES"));
                    }
                }
            }
        }
    }
    
    function cmp($a, $b) {
        if ($a[0] == $b[0]) {
            return 0;
        }
        return ($a[0] < $b[0]) ? -1 : 1;
    }
    
    // Ordenam llista alumnes del grup
    usort($sheetusers, "cmp");

    array_to_csv_download($sheetusers, $filetitle, ",");
      
?>