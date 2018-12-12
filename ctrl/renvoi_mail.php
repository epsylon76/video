<?php
// $_GET['email']
$email = $_GET['email'];

$partage = new partage();

$cle = $partage->cle_from_email($email);

include('ctrl/sendemail.php');

if(isset($_SESSION['login'])){
  header('Location: ./?page=liste');
}else{
  header('Location: ./');
}
