<?php
include('vue/nav.php');
$partage = new partage();

//les partages introuvables

$introuvable = $partage->introuvables($data);

include('vue/introuvables.php');
