<?php

// $email = $_GET['email'];

$cle = $partage->cle_from_email($uri[3]);
include('ctrl/sendemail.php');
header('Location: /admin/partage/');

