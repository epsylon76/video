<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


//conf & send
$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only


$mail->Host = "smtp-relay.gmail.com";
$mail->SMTPAuth   = true;
$mail->Port = 465; // or 587
$mail->SMTPSecure = 'ssl';

$mail->Username = "";
$mail->Password = "";


$mail->CharSet = 'UTF-8'; //encoding
$mail->IsHTML(true);
$mail->SetFrom("");