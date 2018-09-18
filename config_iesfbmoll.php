<?php
define('APPLICATION_NAME', 'GestIB to Google');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');

define('DOMAIN', 'iesfbmoll.org');                // For example: 'iesfbmoll.org'
define('DEFAULT_PASSWORD', 'Curs201819');         // For example: '12345678'

define('DEPARTMENT_GROUP_PREFIX', 'dept.');       // For example: 'dept.'
define('TEACHERS_GROUP_PREFIX', 'professorat.');  // For example: 'professorat.'
define('STUDENTS_GROUP_PREFIX', 'alumnat.');      // For example: 'alumnat.'
define('TUTORS_GROUP_PREFIX', 'tutor.');          // For example: 'tutor.'

define('TEACHERS_ORGANIZATIONAL_UNIT', '/Professorat');      // For example: '/Professorat'
define('STUDENTS_ORGANIZATIONAL_UNIT', '/Alumnat');          // For example: '/Alumnat'

define('LONG_STUDENTS_EMAIL', TRUE);         // TRUE: jsmith@domain FALSE: jsf00@domain

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
  "com21" => [        // GM Activitats comercials
    "name" => "com21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "com34" => [        // GS Comerç internacional
    "name" => "com34",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc21" => [        // GM Sistemes microinformàtics i xarxes
    "name" => "ifc21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r A
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 1r B
      "c" => ["teacher" => ["c"], "student" => ["c"]],  // 2n
      "d" => ["teacher" => [""], "student" => [""]],
      "e" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc31" => [        // GS Administració de sistemes microinformàtics en xarxa
    "name" => "ifc31",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "d" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc32" => [        // GS Desenvolupament d'aplicacions multiplataforma
    "name" => "ifc32",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "ifc33" => [        // GS Desenvolupament d'aplicacions webs
    "name" => "ifc33",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]],
      "w" => ["teacher" => ["w"], "student" => ["w"]],  // 1r dual
      "x" => ["teacher" => ["x"], "student" => ["x"]]   // 2n dual
    ]
  ],
  "imp11" => [        // FPB Perruqueria i estètica
    "name" => "imp11",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp21" => [        // GM Estètica i bellesa
    "name" => "imp21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r Matí
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 1r Horabaixa
      "c" => ["teacher" => ["c"], "student" => ["c"]],  // 2n Matí
      "d" => ["teacher" => ["d"], "student" => ["d"]],  // 2n Horabaixa
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp22" => [        // GM Perruqueria i cosmètica capil·lar
    "name" => "imp22",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp31" => [        // GS Estètica integral i benestar
    "name" => "imp31",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "imp33" => [        // GS Assessoria d'imatge personal i corporativa
    "name" => "imp33",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san22" => [        // GM Farmàcia i parafarmàcia
    "name" => "san22",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "d" => ["teacher" => [""], "student" => [""]],
      "e" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san23" => [        // GM Cures auxiliars d'infermeria
    "name" => "san23",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r A (Matí)
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 1r B (Horabaixa)
      "c" => ["teacher" => [""], "student" => [""]],
      "d" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san31" => [        // GS Anatomia patològica i citodiagnòstic
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
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "san36" => [        // GS Laboratori clínic i biomèdic
    "name" => "san36",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
      "f" => ["teacher" => [""], "student" => [""]]
    ]
  ],
  "sea21" => [        // GM Emergències i protecció civil
    "name" => "sea21",
    "groups" => [
      "a" => ["teacher" => ["a"], "student" => ["a"]],  // 1r
      "b" => ["teacher" => ["b"], "student" => ["b"]],  // 2n
      "c" => ["teacher" => [""], "student" => [""]],
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
