<?php
    include 'login.php';
    require_once 'api/domainuser.php';
    require_once 'api/xmlfile.php';
    require_once 'api/domainread.php';
    require_once 'api/domainoperations.php';
  
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
  <title>GestIB to Google</title>
</head>

<body>
<?php
    $apply = isset($_REQUEST['apply']);
    if ($_FILES['xmlfile']['error'] == UPLOAD_ERR_OK               //checks for errors
          && is_uploaded_file($_FILES['xmlfile']['tmp_name'])) { //checks that file is uploaded
      $xml = simplexml_load_file($_FILES['xmlfile']['tmp_name']);
      $xmlusers = readXmlFile($xml);

      $domainusers = readDomainUsers();
      
      $cont = applyDomainChanges($xmlusers, $domainusers, $apply);

      if ($apply) {
          echo($cont['deleted']." users have been suspended<br>\r\n");
          echo($cont['created']." users have been created<br>\r\n");
          echo($cont['activated']." users have been activated<br>\r\n");
          echo($cont['groupsmodified']." users have been changed their group membership<br>\r\n");
      } else {
          echo($cont['deleted']." users will be suspended<br>\r\n");
          echo($cont['created']." users will be created<br>\r\n");
          echo($cont['activated']." users will be activated<br>\r\n");
          echo($cont['groupsmodified']." users will change their group membership<br>\r\n"); 
      }
    } else {
      echo("Error uploading file...<br>");
      print_r($_FILES);
    }
?>
</body>

</html>