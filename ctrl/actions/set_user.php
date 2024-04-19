<?php

$admin->add_user($_GET['new_login'], $_GET['new_password']);

header('location/?page=users');