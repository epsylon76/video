<?php
// $_GET['email']
$email = $_GET['email'];
$partage = new partage();
$cle = $partage->cle_from_email($email);
include('ctrl/sendemail.php');
header('Location: ./?page=liste');

