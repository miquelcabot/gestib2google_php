<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesemilidarder.com');      // For example: 'iesemilidarder.com'
define('DEFAULT_PASSWORD', '12345678');      // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dep.');   // For example: 'dep.'
define('TEACHERS_GROUP_PREFIX', 'ee.');      // For example: 'ee.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.'); // For example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutor.');     // For example: 'tutor.'

define('DEPARTMENT_NUMBER_TO_NAME', [
  "544" => "orientacio",     // "Orientació"
  "546" => "plastica",       // "Arts plàstiques"
  "547" => "naturals",       // "Ciències naturals"
  "548" => "educaciofisica", // "Educació física i esportiva"
  "549" => "mixt",           // "Filosofia"
  "550" => "fisiquim",       // "Física i química"
  "551" => "mixt",           // "Francès (EOI)"
  "552" => "socials",        // "Geografia i història"
  "553" => "angles",         // "Anglès (EOI)"
  "554" => "mixt",           // "Llatí"
  "555" => "castella",       // "Llengua castellana i literatura"
  "556" => "catala",         // "Llengua catalana i literatura"
  "557" => "mates",          // "Matemàtiques"
  "558" => "mixt",           // "Música"
  "560" => "tecnologia",     // "Tecnologia"
  "561" => "informatica",    // "Informàtica i comunicacions (F.P.)"
  "562" => "plastica",       // "Dibuix i educació plàstica i visual"
  "563" => "naturals",       // "Biologia i geologia"
  "564" => "angles",         // "Llengües estrangeres"
  "565" => "socials",        // "Ciències socials, geografia i història"
  "6489" => "mixt"           // "Formació i orientació laboral"
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

if (!defined('DEPARTMENT_GROUP_PREFIX') || !DEPARTMENT_GROUP_PREFIX) {
  die("Error: You must define DEPARTMENT_GROUP_PREFIX constant in config.php file");
}

if (!defined('TEACHERS_GROUP_PREFIX') || !TEACHERS_GROUP_PREFIX) {
  die("Error: You must define TEACHERS_GROUP_PREFIX constant in config.php file");
}

if (!defined('STUDENTS_GROUP_PREFIX') || !STUDENTS_GROUP_PREFIX) {
  die("Error: You must define STUDENTS_GROUP_PREFIX constant in config.php file");
}

if (!defined('TUTORS_GROUP_PREFIX') || !TUTORS_GROUP_PREFIX) {
  die("Error: You must define TUTORS_GROUP_PREFIX constant in config.php file");
}