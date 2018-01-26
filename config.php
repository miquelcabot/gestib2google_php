<?php
define('APPLICATION_NAME', 'GestIB 2 Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesemilidarder.com');
define('DEFAULT_PASSWORD', '12345678');

// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/admin-directory_v1-gestib2google.json
define('SCOPES', implode(' ', array(
  Google_Service_Directory::ADMIN_DIRECTORY_USER,
  Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
  Google_Service_Directory::ADMIN_DIRECTORY_ORGUNIT
  )
));
