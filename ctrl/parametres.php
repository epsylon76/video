<?php

//s'il y a un POST, enregistrer les données dans la table
if(isset($_POST['page_titre'])){
set_params($_POST); //c'est la page config .php qui contient les fonctions de paramètres

}

//re récupérer les paramètres avant d'afficher
$params = get_params();
$max_upload = max_file_upload();

include('vue/parametres.php');
