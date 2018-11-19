<?php

class historique{

  function admin_partage($id_admin,$id_partage,$action){
    global $DB_con;
    $requete="INSERT INTO `historique` (`id_admin`,`id_partage`,`date`,`action`) VALUES ('".$id_admin."', '".$id_partage."', NOW(), '".$action."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
    return $cle;
  }


  function admin_login($id){}

    function liste_historique(){
      global $DB_con;
      $requete = "SELECT `historique`.`id_admin`, `historique`.`id_partage`, `historique`.`date`, `historique`.`action`, `partage`.`chemin`, `partage`.`email`, `partage`.`type_partage`
      FROM `historique`
      LEFT JOIN `partage` ON `historique`.`id_partage` = `partage`.`id`
      ORDER BY `historique`.`date` DESC
      LIMIT 500
      ";
      $query=$DB_con->prepare($requete);
      $query->execute();
      $resultat = $query->fetchAll();
      return $resultat;
    }


  }
