<?php

include('./config/mail_config.php');
include('./config/email_template.php');

if (isset($email_type) && $email_type == 2) {
    $sujet = $params['email_sujet_alt'];
} else {
    $sujet = $params['email_sujet'];
}


$mail->SMTPDebug  = 0; //debug
$mail->Subject = utf8_decode($sujet);
$mail->Body = $corps;
$mail->SetFrom($params['email_expediteur']);
$mail->AddAddress($email);
$mail->Send();
