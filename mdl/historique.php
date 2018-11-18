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


}
