<?php

class historique() {
  function add_histo_admin($email,$chemin){
    global $DB_con;
    $requete="INSERT INTO `historique` (`chemin`,`email`,`cle`) VALUES ('".$chemin."', '".$email."', '".$cle."')";
    $query=$DB_con->prepare($requete);
    $query->execute();
    return $requete;
  }
}
