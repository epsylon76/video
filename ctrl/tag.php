<?php


$nomTag = urldecode($uri[2]);
$listeTag = $tag->get_tag_from_nom_tag($nomTag);

?>
<div class="container">
    <h3 style="margin-top:15px;" >Listes des chemins du tags : <?php echo $nomTag ?></h3>

    <?php
    foreach($listeTag as $tags){

    $type = $dossier->infos_fichier($data, $tags['nom_chemin'], '');

    if ($type[0] == 'dir' || $type[0] == 'link') { 
    

        echo '<li class="list-group-item">';
        echo '<a href="../dossiers/' . $tags["nom_chemin"] . '">' . $tags["nom_chemin"] . '</a>';
        echo '</li>';

    }else{

        echo '<li class="list-group-item">';
        echo '<a href="../video/' . $tags["nom_chemin"] . '">' . $tags["nom_chemin"] . '</a>';
        echo '</li>';

     }
    }

echo '</div>';

