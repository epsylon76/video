<?php
include_once('./mdl/tag.php');
include('./config/dbconn.php');


$tag = new tag();

$nom_dossier = $_POST['nom_dossier'];
$type = $_POST['type'];
$tagInput =  $_POST['liste_tag'];
$retour = $_POST['retour'];
$tagLabel = $_POST['tag'];

$tab_tagInput = explode(' ', preg_replace('/\s+/', ' ', ltrim(rtrim($tagInput))));
$tab_tagLabel = explode(' ', preg_replace('/\s+/', ' ', ltrim(rtrim($tagLabel))));


// mettre les tags dans la base de donné 
foreach ($tab_tagInput as $tagInput) {
    if($tagInput != ' ' || $tagInput != ''){
        $tag->set_tag($nom_dossier, $tagInput, $type);
    }
}

// enlever les tags de la base de donné si tag enlevé de l'input
foreach ($tab_tagLabel as $tagLabel) {
    if (!in_array($tagLabel, $tab_tagInput)) {
        echo $tagLabel;
        $tag->delete_tag($tagLabel, $nom_dossier);
    }
}


if($retour == '/'){
    $retour = '';
}
header('Location:/admin/dossiers/' . $retour);

?>