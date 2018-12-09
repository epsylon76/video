<?php

class historique{

  function set_partage($admin_login,$partage_chemin,$email){ //à placer apres l'appel d'insert du partage
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('".$admin_login."', '".$partage_chemin."', NOW(), 'set_partage', '".$email."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
  }

  function unset_partage($admin_login,$partage_chemin,$email){ //à placer avant l'appel du drop partage
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('".$admin_login."', '".$partage_chemin."', NOW(), 'unset_partage', '".$email."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
  }


  function admin_login($login){
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES ('".$login."', 'login admin', NOW(), 'login_admin', '')";
    $query=$DB_con->prepare($requete);
    $query->execute();
  }

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
