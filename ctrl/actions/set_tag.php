<?php
include_once('/mdl/tag.php');
$tag = new tag();

$nom_dossier = $_POST['nom_dossier'];
$type = $_POST['type'];
$tagInput =  $_POST['liste_tag'];
$retour = $_POST['retour'];
$tagLabel = $_POST['tag'];

$tab_tagInput = explode(' ', preg_replace('/\s+/', ' ', ltrim(rtrim($tagInput))));
$tab_tagLabel = explode(' ', preg_replace('/\s+/', ' ', ltrim(rtrim($tagLabel))));


$tag->delete_tag_by_chemin($nom_dossier);

// mettre les tags dans la base de données
foreach ($tab_tagInput as $tagInput) {
    $tag->set_tag($nom_dossier, $tagInput, $type);
}

if($retour == '/'){
    $retour = '';
}
header('Location:/admin/dossiers/' . $retour);

?>