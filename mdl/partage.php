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

  function check_partage($cle,$id){
    //vérifie que le partage demandé a bien la bonne clé (empeche de mettre un id au hasard)
    global $DB_con;
    $requete="SELECT * from `partage` where `id` = '".$id."' AND `cle` = '".$cle."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $res=$query->rowCount();
    if($res >= 1){return true;}else{return false;}
  }

  function liste_partages($cle){
    global $DB_con;
    $requete="SELECT `id`,`chemin` from `partage` where `cle` = '".$cle."'";
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

  function set_partage($chemin,$email,$type_partage){
    global $DB_con;
    $cle = $email.'42';
    $cle = sha1($cle);
    $requete="INSERT INTO `partage` (`chemin`,`email`,`cle`,`date`,`type_partage`) VALUES ('".$chemin."', '".$email."', '".$cle."', NOW(), '".$type_partage."')";
    $query=$DB_con->prepare($requete);
    $query->execute();

    return $cle;
  }

  function unset_partage($id,$cle){
    global $DB_con;
    $requete="DELETE FROM `partage`  WHERE `id` = '".$id."' AND `cle` = '".$cle."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
  }

  function get_partage($id){
    global $DB_con;
    $requete="SELECT * from `partage` where `id` = '".$id."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $result = $query->fetch();
    return $result;
  }

  function get_type_partage($id){
    global $DB_con;
    $requete="SELECT `chemin` from `partage` where `id` = '".$id."'";
    $query=$DB_con->prepare($requete);
    $query->execute();
    $result = $query->fetch();
    $fichier = pathinfo($result['chemin']);

    if(isset($fichier['extension']) && $fichier['extension'] == "mp4" || isset($fichier['extension']) && $fichier['extension'] == "MP4")
    {
      return "video";
    }else{
      return "photos";
    }
  }
}
