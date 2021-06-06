<?php

class historique{

  function set_partage($admin_login,$partage_chemin,$email){ //à placer apres l'appel d'insert du partage
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES (:admin_login, :chemin, NOW(), 'set_partage', :email)";
    $query=$DB_con->prepare($requete);
    $query->bindParam(':admin_login', $admin_login);
    $query->bindParam(':chemin', $partage_chemin);
    $query->bindParam(':email', $email);
    $query->execute();
  }

  function unset_partage($admin_login,$partage_chemin,$email){ //à placer avant l'appel du drop partage
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES (:admin_login, :chemin, NOW(), 'unset_partage', :email)";
    $query=$DB_con->prepare($requete);
    $query->bindParam(':admin_login', $admin_login);
    $query->bindParam(':chemin', $partage_chemin);
    $query->bindParam(':email', $email);
    $query->execute();
  }

  function clear_introuvables($admin_login){
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES (:admin_login, '', NOW(), 'clear_introuvables', '')";
    $query=$DB_con->prepare($requete);
    $query->bindParam(':admin_login', $admin_login);
    $query->execute();
  }


  function admin_login($login){
    global $DB_con;
    $requete="INSERT INTO `historique` (`admin_login`,`partage_chemin`,`date`,`action`,`email`) VALUES (:admin_login, 'login admin', NOW(), 'login_admin', '')";
    $query=$DB_con->prepare($requete);
    $query->bindParam(':admin_login', $login);
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
