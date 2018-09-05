<?php

//connexion db
$DB_host = "62.210.16.15";
$DB_port = "16975";
$DB_user = "abeille";
$DB_pass = "abeilleAalpha1987";
$DB_name = "video";

try
{
	$DB_con = new PDO("mysql:host={$DB_host};port={$DB_port};dbname={$DB_name}",$DB_user,$DB_pass);
	$DB_con->exec("SET CHARACTER SET utf8");
	$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

//appeler $DB_con contient la connexion à la db
