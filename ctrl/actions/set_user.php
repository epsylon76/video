<?php

if(isset($_POST['new_login']) && isset($_POST['new_password'])){

    $admin->add_user($_POST['new_login'],$_POST['new_password']);
}
header('location: /admin/parametres/users/');