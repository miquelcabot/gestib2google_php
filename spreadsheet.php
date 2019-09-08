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
      
      $readdomainusers = readDomainUsers();
      $domainusers = $readdomainusers['domainusers'];
      
      foreach($domainusers as $key=>$domainuser) {
          foreach ($domainuser->groups as $group) {
            if (!$domainuser->suspended && (strpos($group, STUDENTS_GROUP_PREFIX) !== FALSE && strpos($group,  STUDENTS_GROUP_PREFIX) == 0)) {
              if (strpos($group, "@iesfbmoll.org") !== FALSE) {  // Només usuaris del domini actual (Canvi domini de @iesfbmoll.org a DOMAIN)
                if (!array_key_exists($group, $sheetusers)) {
                  $sheetusers[$group] = [];
                }
                array_push($sheetusers[$group], [
                  $domainuser->surname.", ".$domainuser->name,
                  $domainuser->domainemail
                ]);
              }
            }
          }
          if (!$domainuser->suspended && $domainuser->teacher) {
            if (!array_key_exists("Professorat", $sheetusers)) {
              $sheetusers["Professorat"] = [];
            }
            array_push($sheetusers["Professorat"], [
              $domainuser->surname.", ".$domainuser->name,
              $domainuser->domainemail
            ]);
          }    
      }
      
      function cmp($a, $b) {
        if ($a[0] == $b[0]) {
          return 0;
        }
        return ($a[0] < $b[0]) ? -1 : 1;
      }
      
      ksort($sheetusers);
      foreach ($sheetusers as $group => $users) {
        echo "Guardant grup '$group' al fitxer<br>";
        // Ordenam llista alumnes del grup
        usort($users, "cmp");
        // Afegim títols a les columnes
        array_unshift( $users, ['Nom', 'Email']);
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
      
      echo "Fitxer guardat com a ... '$filetitle'";
      
?>
</body>

</html>