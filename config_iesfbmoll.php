<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesfbmoll.org');                // For example: 'iesfbmoll.org'
define('DEFAULT_PASSWORD', 'Curs201819');         // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dept.');       // For example: 'dept.'
define('TEACHERS_GROUP_PREFIX', 'professorat.');  // For example: 'professorat.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.');      // For example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutors');          // For example: 'tutors'

define('DEPARTMENT_NUMBER_TO_NAME', [
  "597" => "orientacio",                  // Orientació
  "602" => "educaciofisica",              // Educació física i esportiva
  "604" => "fisicaiquimica",              // Física i química
  "605" => "formacioiorientaciolaboral",  // Formació i orientació laboral
  "611" => "llenguacastellana",           // Llengua castellana i literatura
  "612" => "llenguacatalana",             // Llengua catalana i literatura
  "613" => "matematiques",                // Matemàtiques
  "614" => "musica",                      // Música
  "616" => "tecnologia",                  // Tecnologia
  "618" => "administracio",               // Administració (F.P.)
  "619" => "comercimarqueting",           // Comerç i màrqueting (F.P.)
  "621" => "imatgepersonal",              // Imatge personal (F.P.)
  "622" => "informaticaicomunicacions",   // Informàtica i comunicacions (F.P.)
  "624" => "sanitat",                     // Sanitat (F.P.)
  "626" => "filosofiaiclassiques",        // Llengües i cultura clàssiques
  "627" => "plastica",                    // Dibuix i educació plàstica i visual (O DIBUIX??)
  "628" => "biologiaigeologia",           // Biologia i geologia
  "629" => "llenguesestrangeres",         // Llengües estrangeres
  "630" => "geografiaihistoria",          // Ciències socials, geografia i història
  "5789" => "filosofiaiclassiques",       // Filosofia
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