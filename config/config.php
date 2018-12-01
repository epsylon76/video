<?php
include_once('dbconn.php');


//fonctions des Paramètres
function set_params($input){
  global $DB_con;

  $page_titre = $DB_con->quote($input['page_titre']);
  $accueil_texte = $DB_con->quote($input['accueil_texte']);
  $email_expediteur = $DB_con->quote($input['email_expediteur']);
  $email_sujet = $DB_con->quote($input['email_sujet']);
  $email_corps = $DB_con->quote($input['email_corps']);
  $email_texte_bouton = $DB_con->quote($input['email_texte_bouton']);
  $email_corps_2 = $DB_con->quote($input['email_corps_2']);
  $email_footer = $DB_con->quote($input['email_footer']);
  $couleur_fond = $DB_con->quote($input['couleur_fond']);
  $dossier_data = $DB_con->quote($input['dossier_data']);
  $url_domaine = $DB_con->quote($input['url_domaine']);
  $analytics = $DB_con->quote($input['analytics']);
  $partage_dossier = $input['partage_dossier'];

  $set_params = "INSERT INTO `parametres` (`page_titre`,`accueil_texte`,`email_expediteur`,`email_sujet`,`email_corps`,`email_texte_bouton`,`email_corps_2`,`email_footer`,`couleur_fond`,`dossier_data`,`url_domaine`,`analytics`,`partage_dossier`)
  VALUES ( ".$page_titre.", ".$accueil_texte.", ".$email_expediteur.", ".$email_sujet.", ".$email_corps.", ".$email_texte_bouton.",".$email_corps_2.",".$email_footer.",".$couleur_fond.",".$dossier_data.",".$url_domaine.",".$analytics.",".$partage_dossier.")";
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
