<?php

$liste = $partage->liste_partages($_GET['cle']);

include('vue/banniere.php');
include('vue/partage.php');
