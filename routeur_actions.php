<?php
if($uri[1] == 'login_admin'){
    include 'ctrl/actions/login_admin.php';
}


//vérification du login
if (isset($_SESSION['login']) && isset($_SESSION['pass']) && $admin->check_login_crypt($_SESSION['login'], $_SESSION['pass'])) {

    switch ($uri[1]) {

        case 'set_partage':
            include 'ctrl/actions/set_partage.php';
            break;


        case 'setTag':
            include 'ctrl/actions/set_tag.php';
            break;

        case 'set_envois':
            include 'ctrl/actions/set_envois.php';
            break;

        case 'renvoi_bulk':
            include 'ctrl/actions/renvoi_bulk.php';
            break;
    }
}