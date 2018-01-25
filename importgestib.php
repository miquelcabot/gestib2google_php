<!DOCTYPE html>
<html lang="en">
<?php
    require_once 'client.php';
    require_once 'api/domainuser.php';
    require_once 'api/xmlfile.php';
    require_once 'api/domainread.php';
    require_once 'api/domainoperations.php';
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Miquel A. Cabot">
  <title>GestIB to Google - IES Emili Darder</title>
  <!-- Bootstrap core CSS-->
  <link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="libraries/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <div class="content-wrapper">
<?php
    if ($_FILES['xmlfile']['error'] == UPLOAD_ERR_OK               //checks for errors
          && is_uploaded_file($_FILES['xmlfile']['tmp_name'])) { //checks that file is uploaded
      $xml = simplexml_load_file($_FILES['xmlfile']['tmp_name']);
      $xmlusers = readXmlFile($xml);

      $client = getClient();
      $service = new Google_Service_Directory($client);

      $domainusers = readDomainUsers($service);
      $cont = applyDomainChanges($xmlusers, $domainusers, FALSE, $service);

      echo($cont['deleted']." users will be suspended\r\n");
      echo($cont['created']." users will be created\r\n");
      echo($cont['activated']." users will be activated\r\n");
      echo($cont['groupsmodified']." users will change their group membership\r\n");
    } else {
      echo("Error uploading file...<br>");
      print_r($_FILES);
    }
?>
  </div>
</body>

</html>