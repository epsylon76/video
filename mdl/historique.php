<?php

class historique{

  function set_partage($admin_login,$partage_chemin,$email){ //à placer apres l'appel d'insert du partage
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('".$admin_login."', '".$partage_chemin."', NOW(), 'set_partage', '".$email."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
    return $cle;
  }

  function unset_partage($admin_login,$partage_chemin,$email){ //à placer avant l'appel du drop partage
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('".$admin_login."', '".$partage_chemin."', NOW(), 'unset_partage', '".$email."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
    return $cle;
  }


  function admin_login($id){}

    function liste_historique(){
      global $DB_con;
      $requete = "SELECT *
      FROM `historique`
      ORDER BY `historique`.`date` DESC
      LIMIT 500
      ";
      $query=$DB_con->prepare($requete);
      $query->execute();
      $resultat = $query->fetchAll();
      return $resultat;
    }


  }
