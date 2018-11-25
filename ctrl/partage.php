<?php

$liste = $partage->liste_partages($_GET['cle']);

include('vue/partage.php');
