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
  $tokens = explode(" ",removeAccents(mb_strtolower($name,'UTF-8')));
  $names = [];
  // Words with compound names and surnames
  $especialTokens = array('da', 'de', 'di', 'do', 'del', 'la', 'las', 'le', 'los', 
    'mac', 'mc', 'van', 'von', 'y', 'i', 'san', 'santa','al','el');

  foreach ($tokens as $token) {
    if (!in_array($token, $especialTokens) || (sizeof($tokens)==1 && strlen($token)==1)) { // If token not in $especialTokens
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
  public $withoutcode;
  public $groups;
  public $expedient;
  public $organizationalUnit;
  public $lastLoginTime;
  
  public function __construct($id, $name, $surname, $surname1, $surname2, $domainemail, 
                       $suspended, $teacher, $withoutcode, $groups, $expedient, $organizationalUnit,
                       $lastLoginTime) { 
    $this->id =          $id;
    $this->name =        $name;
    $this->surname =     $surname;
    $this->surname1 =    $surname1;
    $this->surname2 =    $surname2;
    $this->domainemail = $domainemail;
    $this->suspended =   $suspended;
    $this->teacher =     $teacher;
    $this->withoutcode = $withoutcode;
    $this->groups =      $groups;
    $this->expedient =   $expedient;
    $this->organizationalUnit = $organizationalUnit;
    $this->lastLoginTime = $lastLoginTime;
  }
  
  public function email() {
    if (!empty($this->domainemail)) {
      return $this->domainemail;
    } elseif ($this->teacher || LONG_STUDENTS_EMAIL) {  // Long email
      $email = "";
      $email = normalizedname(mb_substr($this->name,0,1)) .
        normalizedname($this->surname1);
      return $email."@".DOMAIN;
    } else {                                            // Short email
      $email = "";
      $email = normalizedname(mb_substr($this->name,0,1)) .
        normalizedname(mb_substr($this->surname1,0,1)) .
        normalizedname(mb_substr($this->surname2,0,1));
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
      if ((strpos($group, STUDENTS_GROUP_PREFIX) !== FALSE && strpos($group, STUDENTS_GROUP_PREFIX) == 0) || 
          (strpos($group, TEACHERS_GROUP_PREFIX) !== FALSE && strpos($group, TEACHERS_GROUP_PREFIX) == 0) || 
          (strpos($group, DEPARTMENT_GROUP_PREFIX) !== FALSE && strpos($group, DEPARTMENT_GROUP_PREFIX) == 0) || 
          (strpos($group, TUTORS_GROUP_PREFIX) !== FALSE && strpos($group, TUTORS_GROUP_PREFIX) == 0)) {
        array_push($gr, $group);
      }
    }
    return $gr;
  }
  
  public function groupswithprefixadded() {
    return $this->groups;
  }

  public function __toString() {
    return ($this->teacher?"TEACHER: ":"STUDENT: ").$this->surname.", ".$this->name.
      " (".$this->email().") [".implode(", ",$this->groups)."]";
  }
}

?>
