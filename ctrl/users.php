<?php
include('vue/nav.php');
$admin = new admin();
$liste_admins = $admin->liste_users();

include ('vue/users.php');
