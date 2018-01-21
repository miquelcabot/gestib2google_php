<?php

function removeAccents($str) {
  $table = array(
      'á'=>'a', 'à'=>'a', 'é'=>'e', 'è'=>'e', 'í'=>'i', 'ì'=>'i',
      'ó'=>'o', 'ò'=>'o', 'ú'=>'u', 'ù'=>'u', 'ñ'=>'n',
      'Á'=>'A', 'À'=>'A', 'É'=>'E', 'È'=>'E', 'Í'=>'I', 'Ì'=>'I',
      'Ó'=>'O', 'Ò'=>'O', 'Ú'=>'U', 'Ù'=>'U', 'Ñ'=>'N'
  );
  return strtr($str, $table);
}

function normalizedName($name) {
  $tokens = explode(" ",removeAccents(strtolower($name)));
  $names = [];
  // Words with compound names and surnames
  $especialTokens = array('da', 'de', 'di', 'do', 'del', 'la', 'las', 'le', 'los', 
    'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa','al','el');

  foreach ($tokens as $token) {
    if (!in_array($token, $especialTokens)) { // If token not in $especialTokens
      array_push($names, $token);
    }
  }
  
  if (count($names)>=1) { // If name exists (with name or surname)
    return $names[0];
  } else {                // If name not exists (without name or surname)
    return "_";
  }
}

class DomainUser {
  public $id;
  public $name;
  public $surname;
  public $surname1;
  public $surname2;
  public $domainemail;
  public $suspended;
  public $teacher;
  public $tutor;
  public $withoutcode;
  public $groups;
  
  public function __construct($id, $name, $surname, $surname1, $surname2, $domainemail, 
                       $suspended, $teacher, $tutor, $withoutcode, $groups) { 
    $this->id =          $id;
    $this->name =        $name;
    $this->surname =     $surname;
    $this->surname1 =    $surname1;
    $this->surname2 =    $surname2;
    $this->domainemail = $domainemail;
    $this->suspended =   $suspended;
    $this->teacher =     $teacher;
    $this->tutor =       $tutor;
    $this->withoutcode = $withoutcode;
    $this->groups =      $groups;
  }
  
  public function email() {
    if (!empty($this->domainemail)) {
      return $this->domainemail;
    } elseif ($this->teacher) {
      $email = "";
      $email = normalizedname(substr($this->name,0,1)) .
        normalizedname($this->surname1);
      return $email."@".DOMAIN;
    } else {
      $email = "";
      $email = normalizedname(substr($this->name,0,1)) .
        normalizedname(substr($this->surname1,0,1)) .
        normalizedname(substr($this->surname2,0,1));
      return $email.str_pad(0, 2, '0', STR_PAD_LEFT)."@".DOMAIN;
    }
  }
  
  public function user() {
    return str_replace("@".DOMAIN,"",$this->email());
  }
  
  public function groupswithdomain() {
    $gr = [];
    foreach ($this->groups as $group) {
      array_push($gr, $group."@".DOMAIN);
    }
    return $gr;
  }
  
  public function groupswithprefix() {
    $gr = [];
    foreach ($this->groups as $group) {
      if ((strpos($group, 'alumnat.') !== FALSE && strpos($group, 'alumnat.') == 0) || 
          (strpos($group, 'ee.') !== FALSE && strpos($group, 'ee.') == 0) || 
          ($group === 'tutors')) {
        array_push($gr, $group);
      }
    }
    return $gr;
  }
  
  public function groupswithprefixsimple() {
    $gr = [];
    foreach ($this->groups as $group) {
      if ((strpos($group, 'alumnat.') !== FALSE && strpos($group, 'alumnat.') == 0) || 
          (strpos($group, 'ee.') !== FALSE && strpos($group, 'ee.') == 0)) {
        array_push($gr, str_replace("alumnat.", "", str_replace("ee.", "", $group)));
      }
    }
    return gr;
  }
  
  public function groupswithprefixadded() {
    $gr = [];
    foreach ($this->groups as $group) {
      if ($this->teacher) {
        array_push($gr, "ee.".$group);
      } else {
        array_push($gr, "alumnat.".$group);
      }
    }
    if ($this->teacher && $this->tutor) {
      array_push($gr, "tutors");
    }
    return $gr;
  }

  public function __toString() {
    return ($this->teacher?"TEACHER: ":"STUDENT: ").$this->surname.", ".$this->name.
      " (".$this->email().") [".implode(", ",$this->groups)."]";
  }
}

?>
