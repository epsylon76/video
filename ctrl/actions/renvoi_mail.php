<?php

$cle = $partage->cle_from_email($uri[3]);
$mailto = $uri[3];

include('ctrl/actions/sendemail.php');

header('Location: /admin/partage/');

