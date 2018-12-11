<?php
// $_GET['email']
$email = $_GET['email'];
include('ctrl/sendemail.php');

if(isset($_SESSION['login'])){
  header('Location: ./?page=liste');
}else{
  header('Location: ./');
}
