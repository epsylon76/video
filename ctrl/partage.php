<?php

$liste = $partage->liste_partages($_GET['email']);

include('vue/banniere.php');
include('vue/partage.php');
