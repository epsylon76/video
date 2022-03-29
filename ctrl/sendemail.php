<?php

include('./config/mail_config.php');
include('./config/email_template.php');

$mail->SMTPDebug  = 0; //debug
$mail->Subject = utf8_decode($params['email_sujet']);
$mail->Body = $corps;
$mail->SetFrom($params['email_expediteur']);
$mail->AddAddress($email);
$mail->Send();
