<?php
session_start();


include_once('ctrl/update.php');
include_once('config/config.php');
include_once('config/fonctions.php');
//require('./vendor/phpmailer/phpmailer/src/Exception.php');
//require('./vendor/phpmailer/phpmailer/src/PHPMailer.php');
//require('./vendor/phpmailer/phpmailer/src/SMTP.php');


//parametres titre, email....
$params = get_params();
$data = $params['dossier_data'];

include_once('./mdl/admin.php');
include_once('./mdl/dossier.php');
include_once('./mdl/partage.php');
include_once('./mdl/historique.php');
include_once('./mdl/stats.php');
include_once('./mdl/tag.php');

//instancier les objets
$admin = new admin();
$dossier = new dossier();
$partage = new partage();
$historique = new historique();
$stats = new stats();
$tag = new tag();

//Anciens liens : redirection
if (isset($_GET['cle']) && !empty($_GET['cle'])) {
  header('location:/cle/' . $_GET['cle']);
}


//ROUTAGE
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

//3 cas : admin, cle, rien(login), actions !

if ($uri[0] == 'admin') {
  include 'routeur_admin.php';
} elseif ($uri[0] == 'cle') {
  include 'vue/head.php';
  include 'routeur_client.php';
} elseif ($uri[0] == '') {
  include 'vue/head.php';
  include 'vue/accueil.php';
}elseif ($uri[0] == 'actions') {
  include 'routeur_actions.php';
}
