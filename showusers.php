<?php
    include 'login.php';
    require_once 'api/domainuser.php';
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
      $onlywithoutcode = isset($_REQUEST['onlywithoutcode']);
      $onlynotsession = isset($_REQUEST['onlynotsession']);
      $onlywithoutorgunit = isset($_REQUEST['onlywithoutorgunit']);
      $selectedgroup = rtrim($_REQUEST['group'], '.');

      $domainusers = readDomainUsers();
      echo "<table><tr>";
      echo "<th>Id</th>";
      echo "<th>Name</th>";
      echo "<th>Email</th>";
      echo "<th>Teacher</th>";
      echo "<th>Groups</th>";
      echo "</tr>";
      $totalusers = 0;
      foreach($domainusers as $key=>$domainuser) {
          if (!$onlywithoutcode || ($domainuser->withoutcode || strlen($domainuser->id)<15)) {
            if (!$onlynotsession || (substr($domainuser->lastLoginTime,0,4)=="1970")) {
              if (!$onlywithoutorgunit || ($domainuser->organizationalUnit=="/")) {
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
                  echo "<tr>";
                  echo "<td>".$domainuser->id."</td>";
                  echo "<td>".$domainuser->surname.", ".$domainuser->name."</td>";
                  echo "<td>".$domainuser->domainemail."</td>";
                  echo "<td>".($domainuser->teacher?"TEACHER":"")."</td>";
                  echo "<td>";
                  foreach ($domainuser->groups as $group) {
                    echo $group.", ";
                  }
                  echo "</td>";
                  echo "</tr>";
                  $totalusers++;
                }
              }
            }
          }
      }
      echo "</table>";
      echo "<strong>TOTAL USERS: ".$totalusers."</strong>";
      
?>
</body>

</html>