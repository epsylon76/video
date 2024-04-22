<?php
//PAGE CLIENT
include('vue/head.php');

$liste = $partage->liste_partages($uri[1]);

include('vue/partage.php');
