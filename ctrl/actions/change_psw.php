<?php

if(isset($_POST['login']) && isset($_POST['psw'])){
    $admin->ch_psw($_POST['login'], $_POST['psw']);
}

header('Location: /admin/parametres/users/');