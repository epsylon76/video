<?php
include('vue/nav.php');

$liste_historique = $historique->liste_historique();

include('vue/historique.php');
