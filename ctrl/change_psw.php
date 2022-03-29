<?php
$admin = new admin();
if(isset($_POST)){
    $admin->ch_psw($_POST['login'], $_POST['psw']);
}else{
    header('Location: ./');
}
header('Location: ./?page=users');

