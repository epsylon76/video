<?php
include_once('dbconn.php');


//fonctions des Paramètres
function set_params($input){
  global $DB_con;
  $set_params = $DB_con->prepare("UPDATE `parametres` SET
                                            `page_titre` = :page_titre,
                                            `accueil_texte` = :accueil_texte,
                                            `email_expediteur` = :email_expediteur,
                                            `email_sujet` = :email_sujet,
                                            `email_sujet_alt` = :email_sujet_alt,
                                            `email_corps` = :email_corps,
                                            `email_corps_alt` = :email_corps_alt,
                                            `email_texte_bouton` = :email_texte_bouton,
                                            `email_corps_2` = :email_corps_2,
                                            `email_corps_2_alt` = :email_corps_2_alt,
                                            `email_footer` = :email_footer,
                                            `couleur_fond` = :couleur_fond,
                                            `dossier_data` = :dossier_data,
                                            `url_domaine` = :url_domaine,
                                            `analytics` = :analytics,
                                            `partage_dossier` = :partage_dossier,
                                            `texte_espace` = :texte_espace,
                                            `partage_fb` = :partage_fb,
                                            `partage_twitter` = :partage_twitter,
                                            `titre_invitation` = :titre_invitation,
                                            `url_invitation` = :url_invitation
                                            WHERE 1");
  $set_params->bindParam('page_titre', $input['page_titre']);
  $set_params->bindParam('accueil_texte', $input['accueil_texte']);
  $set_params->bindParam('email_expediteur', $input['email_expediteur']);
  $set_params->bindParam('email_sujet', $input['email_sujet']);
  $set_params->bindParam('email_sujet_alt', $input['email_sujet_alt']);
  $set_params->bindParam('email_corps', $input['email_corps']);
  $set_params->bindParam('email_corps_alt', $input['email_corps_alt']);
  $set_params->bindParam('email_texte_bouton', $input['email_texte_bouton']);
  $set_params->bindParam('email_corps_2', $input['email_corps_2']);
  $set_params->bindParam('email_corps_2_alt', $input['email_corps_2_alt']);
  $set_params->bindParam('email_footer', $input['email_footer']);
  $set_params->bindParam('couleur_fond', $input['couleur_fond']);
  $set_params->bindParam('dossier_data', $input['dossier_data']);
  $set_params->bindParam('url_domaine', $input['url_domaine']);
  $set_params->bindParam('analytics', $input['analytics']);
  $set_params->bindParam('partage_dossier', $input['partage_dossier']);
  $set_params->bindParam('texte_espace', $input['texte_espace']);
  $set_params->bindParam('partage_fb', $input['partage_fb']);
  $set_params->bindParam('partage_twitter', $input['partage_twitter']);
  $set_params->bindParam('titre_invitation', $input['titre_invitation']);
  $set_params->bindParam('url_invitation', $input['url_invitation']);

  $set_params->execute();
}

function get_params(){
  global $DB_con;
  $lecture_params = "SELECT * FROM `parametres` WHERE 1 ORDER BY `id_params` DESC LIMIT 1";
  $query=$DB_con->prepare($lecture_params);
  $query->execute();
  $params = $query->fetch();
  return $params;
}

function max_file_upload() {
    //select maximum upload size
    $max_upload = ini_get('upload_max_filesize');
    //select post limit
    $max_post = ini_get('post_max_size');
    //select memory limit
    $memory_limit = ini_get('memory_limit');
    // return the smallest of them, this defines the real limit
    return min($max_upload, $max_post, $memory_limit);
}
