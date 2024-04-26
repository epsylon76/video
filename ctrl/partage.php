<?php
//PAGE CLIENT
include('vue/head.php');

if(isset($uri[1])){
    $liste = $partage->liste_partages($uri[1]);
}
else{
    $liste = [];
}


include('vue/partage.php');
