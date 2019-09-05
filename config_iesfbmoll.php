<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesfbmoll.org');                // Per example: 'iesfbmoll.org'
define('DEFAULT_PASSWORD', 'Curs201819');         // Per example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dept.');       // Per example: 'dept.'
define('TEACHERS_GROUP_PREFIX', 'professorat.');  // Per example: 'professorat.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.');      // Per example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutor.');          // Per example: 'tutor.'

define('TEACHERS_ORGANIZATIONAL_UNIT', '/Professorat');      // Per example: '/Professorat'
define('STUDENTS_ORGANIZATIONAL_UNIT', '/Alumnat');          // Per example: '/Alumnat'

define('LONG_STUDENTS_EMAIL', TRUE);         // TRUE: jsmith@domain FALSE: jsf00@domain

define('DEPARTMENT_NUMBER_TO_NAME', [
  "597" => "orientacio",                  // Orientació
  "602" => "educaciofisica",              // Educació Física i Esportiva
  "604" => "fisicaiquimica",              // Física i Química
  "605" => "formacioiorientaciolaboral",  // Formació i Orientació Laboral
  "611" => "llenguacastellana",           // Llengua Castellana i Literatura
  "612" => "llenguacatalana",             // Llengua Catalana i Literatura
  "613" => "matematiques",                // Matemàtiques
  "614" => "musica",                      // Música
  "616" => "tecnologia",                  // Tecnologia
  "618" => "administracio",               // Administració (F.P.)
  "619" => "comercimarqueting",           // Comerç i Màrqueting (F.P.)
  "621" => "imatgepersonal",              // Imatge Personal (F.P.)
  "622" => "informaticaicomunicacions",   // Informàtica i Comunicacions (F.P.)
  "624" => "sanitat",                     // Sanitat (F.P.)
  "626" => "filosofiaiclassiques",        // Llengües i Cultura Clàssiques
  "627" => "dibuix",                      // Dibuix i educació plàstica i visual
  "628" => "biologiaigeologia",           // Biologia i Geologia
  "629" => "llenguesestrangeres",         // Llengües Estrangeres
  "630" => "geografiaihistoria",          // Ciències Socials, Geografia i Història
  "5789" => "filosofiaiclassiques",       // Filosofia
]);

define('FP_GROUP_NAME_CONVERSION', [
  "com21" => [        // GM Activitats Comercials
    "name" => "com21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "com34" => [        // GS Comerç Internacional
    "name" => "com34",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc21" => [        // GM Sistemes Microinformàtics i Xarxes
    "name" => "ifc21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r A
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 1r B
      "c" => ["teacher" => ["c"], "student" => ["c"]],  // 2n
      "d" => ["teacher" => ["dist"], "student" => [""]],   // Distància
      "e" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => ["fct"]]  // FCT
    ]
  ],
  "ifc31" => [        // GS Administració de Sistemes Microinformàtics en Xarxa
    "name" => "ifc31",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "d" => ["teacher" => ["dist"], "student" => [""]],   // Distància
      "e" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc32" => [        // GS Desenvolupament d'Aplicacions Multiplataforma
    "name" => "ifc32",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc33" => [        // GS Desenvolupament d'Aplicacions Web
    "name" => "ifc33",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]],
      "w" => ["teacher" => ["w"], "student" => ["w"]],  // 1r DUAL
      "x" => ["teacher" => ["x"], "student" => ["x"]]   // 2n DUAL
    ]
  ],
  "imp11" => [        // FPB Perruqueria i Estètica
    "name" => "imp11",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp21" => [        // GM Estètica i Bellesa
    "name" => "imp21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r Matí
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 1r Tarda
      "c" => ["teacher" => ["c"], "student" => ["c"]],  // 2n Matí
      "d" => ["teacher" => ["d"], "student" => ["d"]],  // 2n Tarda
      "e" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => ["fct"]]  // FCT
    ]
  ],
  "imp22" => [        // GM Perruqueria i Cosmètica Capil·lar
    "name" => "imp22",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp31" => [        // GS Estètica Integral i Benestar
    "name" => "imp31",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp33" => [        // GS Assessoria d'Imatge Personal i Corporativa
    "name" => "imp33",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san22" => [        // GM Farmàcia i Parafarmàcia
    "name" => "san22",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "d" => ["teacher" => ["dist"], "student" => [""]],   // Distància
      "e" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san23" => [        // GM Cures Auxiliars d'Infermeria
    "name" => "san23",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r A (Matí)
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 1r B (Tarda)
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "d" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san31" => [        // GS Anatomia Patològica i Citodiagnòstic
    "name" => "san31",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san32" => [        // GS Dietètica
    "name" => "san32",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san36" => [        // GS Laboratori Clínic i Biomèdic
    "name" => "san36",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "sea21" => [        // GM Emergències i Protecció Civil
    "name" => "sea21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => ["fct"]], // FCT
      "f" => ["teacher" => [""], "student" => [""]]
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
if (intval(substr(phpversion(), 0, 1))<7) {
  die("ERROR: Required PHP 7 minimum version");
}
