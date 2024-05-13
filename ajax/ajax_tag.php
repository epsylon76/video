<?php
include_once('../mdl/tag.php');
include('../config/dbconn.php');
include('../config/fonctions.php');

$tag = new tag();

$nom_dossier = $_POST['nom_dossier'];
$type = $_POST['type'];
$contenu =  $_POST['contenu'];


$tab_contenu = explode(' ', $contenu);

foreach ($tab_contenu as $valeur) {
    $tag->set_tag($nom_dossier, $valeur, $type);
}


?>