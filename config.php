<?php
define('APPLICATION_NAME', 'GestIB 2 Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesemilidarder.com');           // For example: 'iesfbmoll.org'
define('DEFAULT_PASSWORD', '12345678');      // For example: '12345678'

define('TEACHERS_GROUP_PREFIX', 'ee.');     // For example: 'ee.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.'); // For example: 'alumnat.'
define('TUTORS_GROUP_NAME', 'tutors');       // For example: 'turors'

define('SCOPES', implode(' ', array(
  Google_Service_Directory::ADMIN_DIRECTORY_USER,
  Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
  Google_Service_Directory::ADMIN_DIRECTORY_ORGUNIT
  )
));

date_default_timezone_set('Europe/Madrid');

if (!defined('DOMAIN') || !DOMAIN) {
  die("Error: You must define DOMAIN constant in config.php file");
}

if (!defined('DEFAULT_PASSWORD') || !DEFAULT_PASSWORD) {
  die("Error: You must define DEFAULT_PASSWORD constant in config.php file");
}

if (!defined('TEACHERS_GROUP_PREFIX') || !DEFAULT_PASSWORD) {
  die("Error: You must define TEACHERS_GROUP_PREFIX constant in config.php file");
}

if (!defined('STUDENTS_GROUP_PREFIX') || !DEFAULT_PASSWORD) {
  die("Error: You must define STUDENTS_GROUP_PREFIX constant in config.php file");
}

if (!defined('TUTORS_GROUP_NAME') || !DEFAULT_PASSWORD) {
  die("Error: You must define TUTORS_GROUP_NAME constant in config.php file");
}