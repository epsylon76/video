<?php

class partage {

  function check_cle_email($cle, $email){
    //vérifie lors de l'accès si l'email a la bonne clé
    global $DB_con;
    $requete="SELECT * from `partage` where `email` = '".$email."' AND `cle` = '".$cle."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    if($res >= 1){return true;}else{return false;}
  }

  function check_partage($chemin,$email){
    //vérifie que le partage demandé est bien partagé avec cet $email
    global $DB_con;
    $requete="SELECT * from `partage` where `chemin` = '".$chemin."' AND `email` = '".$email."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    if($res >= 1){return true;}else{return false;}
  }

  function liste_partages($email){
    global $DB_con;
    $requete="SELECT * from `partage` where `email` = '".$email."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $results = $query->fetchAll();
    return $results;
  }

  function nb_partages($chemin){
    global $DB_con;
    $requete="SELECT * from `partage` where `chemin` = '".$chemin."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    return $res;
  }

  function set_partage($chemin,$email){
    global $DB_con;
    $cle = $email.'42';
    $cle = sha1($cle);
    $requete="INSERT INTO `partage` (`chemin`,`email`,`cle`) VALUES ('".$chemin."', '".$email."', '".$cle."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
  }

  function get_partage($chemin,$email,$cle){

  }
}
