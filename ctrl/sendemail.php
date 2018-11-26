<?php

include('./config/mail_config.php');
include('./config/email_template.php');

$mail->Subject = $params['email_sujet'];
$mail->Body = $corps;
$mail->SetFrom($params['email_expediteur']);
$mail->AddAddress($email);

 //if(!$mail->Send()) {
//    echo "Mailer Error: " . $mail->ErrorInfo;
// } else {
//    echo "Message has been sent";
// }
