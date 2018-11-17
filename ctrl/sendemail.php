<?php

include('./config/mail_config.php');
include('./config/email_template.php');

$mail->Subject = "Partage";
$mail->Body = $corps;
$mail->AddAddress($email);

 if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
    echo "Message has been sent";
 }
