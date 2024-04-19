<?php
//vérification du login

switch($uri[1]){
    case 'login_admin':
        include 'ctrl/actions/login_admin.php';
        break;
}