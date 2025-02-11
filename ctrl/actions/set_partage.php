<?php



if (!isset($_POST['email']) && !isset($_POST['chemin'])) {
  //rejeter
} else {
  $email = $_POST['email'];
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
  $type_partage = $_POST['type_partage'];
  $email_type = $_POST['email_type'];
  $immediat = $_POST['immediat'];

  //verifier d'abord l'heure du dernier partage sinon celui quon fera immediatement faussera le calcul
  $hours = $partage->last_partage($_POST['email']); //heures depuis le dernier partage

  $retour = $partage->set_partage($chemin, $email, $type_partage, $_SESSION['login'], $email_type, $immediat);

  $cle = $retour['cle'];
  //ajout à l'historique ($id_admin,$id_partage,$action)
  $historique->set_partage($_SESSION['login'], $chemin, $email);

  //si le dernier partage a été fait il y a moins de 6h


  if ($hours >= 6) {
    //mise en liste d'attente
    $file_attente->add($retour['id'], $immediat);
  }


}
if ($chemin_retour == '/') {
  $chemin_retour = '';
}
header('Location:/admin/dossiers/' . $chemin_retour);
