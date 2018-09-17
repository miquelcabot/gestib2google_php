<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesemilidarder.com');      // For example: 'iesemilidarder.com'
define('DEFAULT_PASSWORD', '12345678');      // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dep.');   // For example: 'dep.'
define('TEACHERS_GROUP_PREFIX', 'ee.');      // For example: 'ee.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.'); // For example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutor.');     // For example: 'tutor.'

define('TEACHERS_ORGANIZATIONAL_UNIT', '/Professorat');      // For example: '/Professorat'
define('STUDENTS_ORGANIZATIONAL_UNIT', '/Alumnat');          // For example: '/Alumnat'

define('LONG_STUDENTS_EMAIL', FALSE);         // TRUE: jsmith@domain FALSE: jsf00@domain

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

define('FP_GROUP_NAME_CONVERSION', [
  "ifc21" => [        // GM Sistemes microinformàtics i xarxes
    "name" => "smx",
    "groups" => [
      "a" => ["teacher" => ["1"], "student" => ["1"]],
      "b" => ["teacher" => ["2"], "student" => ["2"]],
      "c" => ["teacher" => [], "student" => ["1","2"]],
      "f" => ["teacher" => [], "student" => []]
    ]
  ],   
  "ifc31" => [        // GS Administració de sistemes microinformàtics en xarxa  
    "name" => "asix",
    "groups" => [
      "a" => ["teacher" => ["1"], "student" => ["1"]],
      "b" => ["teacher" => ["2"], "student" => ["2"]],
      "c" => ["teacher" => [], "student" => ["1","2"]],
      "f" => ["teacher" => [], "student" => []]
    ]
  ]
]);

define('SCOPES', implode(' ', array(
  Google_Service_Directory::ADMIN_DIRECTORY_USER,
  Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
  Google_Service_Directory::ADMIN_DIRECTORY_ORGUNIT,
  Google_Service_Sheets::SPREADSHEETS
  )
));

date_default_timezone_set('Europe/Madrid');

// Check minimum version: PHP7
if (intval(mb_substr(phpversion(), 0, 1))<7) {
  die("ERROR: Required PHP 7 minimum version");
}
