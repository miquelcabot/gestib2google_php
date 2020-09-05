<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesmadinamayurqa.net');      // For example: 'iesemilidarder.com'
define('DEFAULT_PASSWORD', 'x12345678');      // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dept.');   // For example: 'dep.'
define('TEACHERS_GROUP_PREFIX', 'ee.');      // For example: 'ee.'
define('STUDENTS_GROUP_PREFIX', 'ga.'); // For example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutor.');     // For example: 'tutor.'

define('TEACHERS_ORGANIZATIONAL_UNIT', '/professorat');      // For example: '/Professorat'
define('STUDENTS_ORGANIZATIONAL_UNIT', '/alumnat');          // For example: '/Alumnat'

define('LONG_STUDENTS_EMAIL', TRUE);         // TRUE: jsmith@domain FALSE: jsf00@domain

define('DEPARTMENT_NUMBER_TO_NAME', [
  "1043" => "cienciesnaturals", //Biologia i geologia
  "1045" => "cienciessocials", // Ciències socials, geografia i història
  "1042" => "dibuix", // Dibuix i educació plàstica i visual
  "1026" => "educaciofisica", // Educació física i esportiva
  "1027" => "filosofia", // Filosofia
  "1028" => "fisicaquimica", // Física i química
  "1034" => "castella", // Llengua castellana i literatura
  "1035" => "catala", // Llengua catalana i literatura
  "1044" => "angles", // Llengües estrangeres
  "1041" => "llenguesclassiques", // Llengües i cultura clàssiques
  "1036" => "matematiques", // Matemàtiques
  "1037" => "musica", // Música
  "1022" => "orientacio", // Orientació
  "1039" => "tecnologia", // Tecnologia
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
