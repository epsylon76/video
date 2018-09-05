<?php

class admin{

  function check_login($login,$pass){
    global $DB_con;
    $pass=sha1($pass);
    $requete="SELECT * from `admin` where `login` = '".$login."' AND `pass` = '".$pass."'";

    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    if($res == 1){return true;}else{return false;}
  }

  function check_login_crypt($login,$pass){
    global $DB_con;
    $requete="SELECT * from `admin` where `login` = '".$login."' AND `pass` = '".$pass."'";

    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    if($res == 1){return true;}else{return false;}
  }

}
