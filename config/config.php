<?php
include_once('dbconn.php');

$domain_url='http://epsytech.fr/lakke/';
$data='/var/www/html/lakke/data'; //doit pointer vers le dossier data contenant les liens symboliques
$email="johan.pupin@gmail.com";


//fonctions des Paramètres
function set_params($input){
  global $DB_con;

  $page_titre = $DB_con->quote($input['page_titre']);
  $accueil_texte = $DB_con->quote($input['accueil_texte']);
  $email_expediteur = $DB_con->quote($input['email_expediteur']);
  $email_sujet = $DB_con->quote($input['email_sujet']);
  $email_corps = $DB_con->quote($input['email_corps']);
  $email_texte_bouton = $DB_con->quote($input['email_texte_bouton']);

  $set_params = "INSERT INTO `parametres` (`page_titre`,`accueil_texte`,`email_expediteur`,`email_sujet`,`email_corps`,`email_texte_bouton`)
  VALUES ( ".$page_titre.", ".$accueil_texte.", ".$email_expediteur.", ".$email_sujet.", ".$email_corps.", ".$email_texte_bouton.")";
  $query=$DB_con->prepare($set_params);
  $query->execute();
}

function get_params(){
  global $DB_con;
  $lecture_params = "SELECT * FROM `parametres`
  ORDER BY `id_params` DESC
  LIMIT 1";

  $query=$DB_con->prepare($lecture_params);
  $query->execute();
  $params = $query->fetch();
  return $params;
}
