<?php
define('APPLICATION_NAME', 'GestIB 2 Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesfbmoll.com');      // For example: 'iesemilidarder.com'
define('DEFAULT_PASSWORD', '12345678');      // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dep.');   // For example: 'dep.'
define('TEACHERS_GROUP_PREFIX', 'ee.');      // For example: 'ee.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.'); // For example: 'alumnat.'
define('TUTORS_GROUP_NAME', 'tutors');       // For example: 'tutors'

define('DEPARTMENT_NUMBER_TO_NAME', [
  "553" => "angles",         // "Anglès (EOI)"
  "546" => "plastica",       // "Arts plàstiques"
  "563" => "naturals",       // "Biologia i geologia"
  "547" => "naturals",       // "Ciències naturals"
  "565" => "socials",        // "Ciències socials, geografia i història"
  "562" => "plastica",       // "Dibuix i educació plàstica i visual"
  "548" => "educaciofisica", // "Educació física i esportiva"
  "549" => "mixt",           // "Filosofia"
  "550" => "fisiquim",       // "Física i química"
  "6489" => "mixt",          // "Formació i orientació laboral"
  "551" => "mixt",           // "Francès (EOI)"
  "552" => "socials",        // "Geografia i història"
  "561" => "informatica",    // "Informàtica i comunicacions (F.P.)"
  "554" => "mixt",           // "Llatí"
  "555" => "castella",       // "Llengua castellana i literatura"
  "556" => "catala",         // "Llengua catalana i literatura"
  "564" => "angles",         // "Llengües estrangeres"
  "557" => "mates",          // "Matemàtiques"
  "558" => "mixt",           // "Música"
  "544" => "orientacio",     // "Orientació"
  "560" => "tecnologia"      // "Tecnologia"
]);

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

if (!defined('TEACHERS_GROUP_PREFIX') || !TEACHERS_GROUP_PREFIX) {
  die("Error: You must define TEACHERS_GROUP_PREFIX constant in config.php file");
}

if (!defined('TUTORS_GROUP_NAME') || !TUTORS_GROUP_NAME) {
  die("Error: You must define TUTORS_GROUP_NAME constant in config.php file");
}