<?php
    include 'login.php';
    require_once 'api/client.php';
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
      $sheetusers = [];

      $googlesheet = isset($_REQUEST['googlesheet']);
      $onlywithoutcode = isset($_REQUEST['onlywithoutcode']);
      $onlynotsession = isset($_REQUEST['onlynotsession']);
      $onlywithoutorgunit = isset($_REQUEST['onlywithoutorgunit']);
      $onlyteachers = isset($_REQUEST['onlyteachers']);
      $onlyactive = isset($_REQUEST['onlyactive']);
      $selectedgroup = isset($_REQUEST['group'])?rtrim($_REQUEST['group'], '.'):'';

      if ($googlesheet) {
        $filetitle = 'Usuaris domini '.DOMAIN.' '.date("Y-m-d H:i:s");

        $client = getClient();
        $service = new Google_Service_Sheets($client);

        // Create a new spreadsheet
        $newSheet = new Google_Service_Sheets_Spreadsheet();        
        $response = $service->spreadsheets->create($newSheet);
        $spreadsheetId = $response->spreadsheetId;

        // Change the spreadsheet's title.
        $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => [
              'updateSpreadsheetProperties' => [
                'properties' => [
                  'title' => $filetitle
                ] , 
                'fields' => 'title'
              ]
            ]
          ]);
        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
      }
      $readdomainusers = readDomainUsers();
      $domainusers = $readdomainusers['domainusers'];
      echo "<table><tr>";
      echo "<th>Id</th>";
      echo "<th>Name</th>";
      echo "<th>Email</th>";
      echo "<th>Teacher</th>";
      echo "<th>Groups</th>";
      echo "<th>Organizational Unit</th>";
      echo "</tr>";
      $totalusers = 0;
      foreach($domainusers as $key=>$domainuser) {
          if (!$onlywithoutcode || ($domainuser->withoutcode || strlen($domainuser->id)<15)) {
            if (!$onlynotsession || (mb_substr($domainuser->lastLoginTime,0,4)=="1970")) {
              if (!$onlywithoutorgunit || ($domainuser->organizationalUnit=="/")) {
                if (!$onlyteachers || $domainuser->teacher) {
                  if (!$onlyactive || !$domainuser->suspended) {
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
                        if ((strpos($group, STUDENTS_GROUP_PREFIX) !== FALSE && strpos($group, STUDENTS_GROUP_PREFIX) == 0)) {
                          if (!array_key_exists($group, $sheetusers)) {
                            $sheetusers[$group] = [];
                          }
                          array_push($sheetusers[$group], [
                            $domainuser->surname.", ".$domainuser->name,
                            $domainuser->domainemail
                          ]);
                        }
                      }
                      if ($domainuser->teacher) {
                        if (!array_key_exists("Professorat", $sheetusers)) {
                          $sheetusers["Professorat"] = [];
                        }
                        array_push($sheetusers["Professorat"], [
                          $domainuser->surname.", ".$domainuser->name,
                          $domainuser->domainemail
                        ]);
                      }
                      echo "</td>";
                      echo "<td>".$domainuser->organizationalUnit."</td>";
                      echo "</tr>";
                      $totalusers++;
                    }
                  }
                }
              }
            }
          }
      }
      echo "</table>";
      echo "<strong>TOTAL USERS: ".$totalusers."</strong>";
      if ($googlesheet) {
        function cmp($a, $b) {
          if ($a[0] == $b[0]) {
            return 0;
          }
          return ($a[0] < $b[0]) ? -1 : 1;
        }

        echo "<br><br>";
        ksort($sheetusers);
        foreach ($sheetusers as $group => $users) {
          echo "Writing group '$group' to file<br>";
          // Ordenam llista alumnes del grup
          usort($users, "cmp");
          // Afegim títols a les columnes
          array_unshift( $users, ['Usuari', 'Email']);
          // Add a new sheet
          $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => [
              'addSheet' => [
                'properties' => [
                  'title' => $group 
                ]
              ]
            ]
          ]);
          $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

          // Add values to sheet
          $body = new Google_Service_Sheets_ValueRange([
            'values' => $users
          ]);
          $result = $service->spreadsheets_values->update($spreadsheetId, $group.'!A1', $body, ['valueInputOption' => 'USER_ENTERED']);
        }
        // Delete the first sheet
        $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
          'requests' => [
            'deleteSheet' => [
              'sheetId' => 0 
            ]
          ]
        ]);
        $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
        
        echo "File saved as ... '$filetitle'";
      }
      
?>
</body>

</html>