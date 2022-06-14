<?php

include('./config/mail_config.php');
include('./config/email_template.php');

if (isset($email_type) && $email_type == 2) {
    $sujet = $params['email_sujet_alt'];
} else {
    $sujet = $params['email_sujet'];
}


$mail->Subject = utf8_decode($sujet);
$mail->Body = $corps;
$mail->AddAddress($email);
$mail->Send();
