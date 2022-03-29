<?php
include('./vue/nav.php');

$historique = new historique();

$liste_historique = $historique->liste_historique();

include('./vue/historique.php');
