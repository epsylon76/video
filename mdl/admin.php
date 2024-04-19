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

  function ch_psw($login, $pass){
    global $DB_con;
    $requete=$DB_con->prepare("UPDATE `admin` SET `pass`= :pass WHERE `login` = :login");
    $requete->bindParam(':login', $login);
    $pass = sha1($pass);
    $requete->bindParam(':pass', $pass);
    $requete->execute();
  }

  function check_login_crypt($login,$pass){
    global $DB_con;
    $requete="SELECT * from `admin` where `login` = '".$login."' AND `pass` = '".$pass."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    if($res == 1){return true;}else{return false;}
  }

  function get_id_admin($login){
    global $DB_con;
    $requete="SELECT `id` from `admin` where `login` = '".$login."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $result = $query->fetch();
    return $result[0];
  }

  function liste_users(){
    global $DB_con;
    $requete=$DB_con->prepare("SELECT `id`, `login`, `last_login` FROM `admin` ORDER BY `last_login` DESC");
    $requete->execute();
    $resultats = $requete->fetchAll();
    return $resultats;
  }

  function update_last_login($id){
    global $DB_con;
    $requete=$DB_con->prepare("UPDATE `admin` SET `last_login`= now() WHERE `id` = :id");
    $requete->bindParam('id', $id);
    $requete->execute();
  }

  function add_user($login, $pass){
    global $DB_con;
    $requete=$DB_con->prepare("INSERT INTO `admin` (`login`, `pass`) VALUES(:login, :pass)");
    $pass = sha1($pass);
    $requete->bindParam(':login', $login);
    $requete->bindParam(':pass', $pass);
    $requete->execute();
  }


}
