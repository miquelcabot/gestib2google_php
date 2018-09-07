<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesfbmoll.org');                // For example: 'iesfbmoll.org'
define('DEFAULT_PASSWORD', 'Curs201819');         // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dept.');       // For example: 'dept.'
define('TEACHERS_GROUP_PREFIX', 'professorat.');  // For example: 'professorat.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.');      // For example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutor.');          // For example: 'tutor.'

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
  "627" => "dibuix",                      // Dibuix i educació plàstica i visual
  "628" => "biologiaigeologia",           // Biologia i geologia
  "629" => "llenguesestrangeres",         // Llengües estrangeres
  "630" => "geografiaihistoria",          // Ciències socials, geografia i història
  "5789" => "filosofiaiclassiques",       // Filosofia
]);

define('FP_GROUP_NAME_CONVERSION', [
  "com21" => "",      // GM Activitats comercials
  "com34" => "",      // GS Comerç internacional
  "ifc21" => "smx",   // GM Sistemes microinformàtics i xarxes
  "ifc31" => "asix",  // GS Administració de sistemes microinformàtics en xarxa  
  "ifc32" => "dam",   // GS Desenvolupament d'aplicacions multiplataforma
  "ifc33" => "daw",   // GS Desenvolupament d'aplicacions webs
  "imp11" => "",      // FPB Perruqueria i estètica
  "imp21" => "",      // GM Estètica i bellesa
  "imp22" => "",      // GM Perruqueria i cosmètica capil·lar
  "imp31" => "",      // GS Estètica integral i benestar
  "imp33" => "",      // GS Assessoria d'imatge personal i corporativa
  "san22" => "",      // GM Farmàcia i parafarmàcia
  "san23" => "",      // GM Cures auxiliars d'infermeria
  "san31" => "",      // GS Anatomia patològica i citodiagnòstic
  "san32" => "",      // GS Dietètica
  "san36" => "",      // GS Laboratori clínic i biomèdic
  "sea21" => ""       // GM Emergències i protecció civil
]);

define('SCOPES', implode(' ', array(
  Google_Service_Directory::ADMIN_DIRECTORY_USER,
  Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
  Google_Service_Directory::ADMIN_DIRECTORY_ORGUNIT
  )
));

date_default_timezone_set('Europe/Madrid');
