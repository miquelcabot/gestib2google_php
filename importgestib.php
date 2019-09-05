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
  <title><?php echo APPLICATION_NAME;?></title>
</head>

<body>
<?php
    $apply = isset($_REQUEST['apply']);
    $onlyteachers = isset($_REQUEST['onlyteachers']);

    $selectedgroup = isset($_REQUEST['group'])?rtrim($_REQUEST['group'], '.'):'';

    if ($_FILES['xmlfile']['error'] == UPLOAD_ERR_OK               //Comprovar errors
          && is_uploaded_file($_FILES['xmlfile']['tmp_name'])) { //Comprovar que el fitxer s'ha carregat
      $xml = simplexml_load_file($_FILES['xmlfile']['tmp_name']);
      $xmlusers = readXmlFile($xml);

      $readdomainusers = readDomainUsers();
      $domainusers = $readdomainusers['domainusers'];
      $domaingroupsmembers = $readdomainusers['domaingroupsmembers'];

      $cont = applyDomainChanges($xmlusers, $domainusers, $domaingroupsmembers, $apply, $selectedgroup, $onlyteachers);

      if ($apply) {
          echo($cont['deleted']." usuaris han estat suspesos<br>\r\n");
          echo($cont['created']." usuaris han estat creats<br>\r\n");
          echo($cont['activated']." usuaris han estat activats<br>\r\n");
          echo($cont['membersmodified']." usuaris han canviat de grup/s<br>\r\n");
          echo($cont['orgunitmodified']." usuaris han canviat de 'organizational unit'<br>\r\n");
          echo($cont['groupsmodified']." grups han estat creats<br>\r\n");
      } else {
          echo($cont['deleted']." usuaris seran suspesos<br>\r\n");
          echo($cont['created']." usuaris seran creats<br>\r\n");
          echo($cont['activated']." usuaris seran activats<br>\r\n");
          echo($cont['membersmodified']." usuaris canviaran de grup/s<br>\r\n"); 
          echo($cont['orgunitmodified']." usuaris canviaran de 'organizational unit'<br>\r\n"); 
          echo($cont['groupsmodified']." grups seran creats<br>\r\n"); 
      }
    } else {
      echo("Error carregant el fitxer...<br>");
    }
?>
</body>

</html>