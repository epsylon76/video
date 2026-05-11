<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

$last_id = $_POST['last_id'] ?? 0;
$limit = $_POST['limit'] ?? 100;

$result = $partage->scan_introuvables($data, $last_id, $limit);
$introuvables = $partage->introuvables($data);

$result['total_introuvables'] = $introuvables ? count($introuvables) : 0;

header('Content-Type: application/json');
echo json_encode($result);
exit;
