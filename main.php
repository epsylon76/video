<?php
session_start();

include_once('./config/config.php');
include_once('./config/fonctions.php');
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

//instancier les objets
$admin = new admin();
$dossier = new dossier();
$partage = new partage();
$historique = new historique();


/* à refaire
if(isset($_GET['action']) && $_GET['action']=="deco"){
  include('./ctrl/deconnecter.php');
}
*/


//ROUTAGE
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

//3 cas : admin, cle, rien(login), actions !

if($uri[0] == 'admin'){
  include 'routeur_admin.php';
}
elseif($uri[0] == 'cle'){
  include 'vue/head.php';
  include 'routeur_client.php';
}
elseif($uri[0] == ''){
  include 'vue/head.php';
  include 'vue/accueil.php';
}elseif($uri[0] == 'actions'){
  include 'routeur_actions.php';
}

?>

