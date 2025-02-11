<?php

$params['depart_file'] = $_POST['depart_file'];
set_params($params);

if($_POST['depart_file'] >= date('Y-m-d H:i:s')){
    file_reset();
}

header('location:/admin/envois');