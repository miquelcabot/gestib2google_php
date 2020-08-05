<?php
    include '../login.php';
    require_once '../api/client.php';
    require_once '../api/domainuser.php';
    require_once '../api/domainread.php';
    require_once '../api/domainoperations.php';
  
    // Echo while every long loop iteration
    while (@ob_end_flush());      
    ob_implicit_flush(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Miquel A. Cabot">
  <title><?php echo APPLICATION_NAME;?></title>
</head>

<body>
<?php
    $apply = FALSE;

    $client = getClient();
    $service = new Google_Service_Directory($client);

    $readdomainusers = readDomainUsers();
    $domainusers = $readdomainusers['domainusers'];
    
    $contador = 0;
    $total = 0;
    foreach($domainusers as $key=>$domainuser) {
        $total++;
        if (!$domainuser->teacher && ($domainuser->organizationalUnit=='/Alumnat')) {
            echo "USUARI DOMINI: ";
            echo $domainuser->id." - ";
            echo $domainuser->surname.", ".$domainuser->name." - ";
            echo $domainuser->domainemail."<br>";
            $newemail = surnames2($domainuser->name, $domainuser->surname, $domainusers);
            if ($newemail!=$domainuser->domainemail) {
                echo "NOU EMAIL: ".$newemail."<br>";
                $domainuser->domainemail = $newemail;
                $contador++;
                if ($apply) {
                    $userObj = new Google_Service_Directory_User(
                        array(
                            'primaryEmail' => $domainuser->domainemail
                        )
                    );
                    $service->users->update($domainuser->email(), $userObj);
                }
            }
        }
    }
    echo "CANVIATS: ".$contador."<br>";
    echo "TOTAL: ".$total;
      
    
    function normalizedName2($name) {
        $tokens = explode(" ",removeAccents(mb_strtolower($name,'UTF-8')));
        $names = [];
        // Paraules amb noms i llinatges composts
        $especialTokens = array('da', 'de', 'di', 'do', 'del', 'la', 'las', 'le', 'los', 
          'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa','al','el');
      
        foreach ($tokens as $token) {
          if (!in_array($token, $especialTokens) || (sizeof($tokens)==1 && strlen($token)==1)) { // If token not in $especialTokens
            array_push($names, $token);
          }
        }
        
        if (count($names)>=1) { // Si el nom existeix (amb nom o llinatge)
          return implode($names);
        } else {                // Si el nom no existeix (sense nom o llinatge)
          return "_";
        }
    }

    function surnames2 ($name, $surname, $domainusers) {
        // Primer, provam m.cabotnadal
        $emailok = TRUE;
        $newemail = normalizedname(mb_substr($name,0,1)) .
            "." . 
            normalizedname2($surname) . 
            "@".DOMAIN;
        foreach ($domainusers as $d_user) {
            // Si hi ha un usuari del domini amb el mateix email
            if ($d_user->email()===$newemail) {
            $emailok = FALSE;
            }
        }
        // Finalment, m.cabotnadal2, m.cabotnadal3...
        if (!$emailok) {
            $emailnumber = 1;
            while (!$emailok) {
                $emailok = TRUE;
                $emailnumber++;
                $newemail = normalizedname(mb_substr($name,0,1)) .
                    "." . 
                    normalizedname2($surname) .
                    $emailnumber .
                    "@".DOMAIN;
                foreach ($domainusers as $d_user) {
                    // Si hi ha un usuari del domini amb el mateix email
                    if ($d_user->email()===$newemail) {
                    $emailok = FALSE;
                    }
                }
            }
        }
        return $newemail;
    }
?>
</body>

</html>