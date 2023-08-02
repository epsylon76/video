<?php

$partage = new partage();

$res = $partage->get_partage_date_unique($_POST['date']);


foreach ($res as $un) {
    $email = $un['email'];
    $cle = $partage->cle_from_email($email);
    include('config/mail_config.php');
    include('config/email_template.php');
    $sujet = $params['email_sujet'];

    $mail->Subject = $sujet;
    $mail->Body = $corps;
    $mail->AddAddress($email);
    $mail->Send();
    echo $email . '<br>';
}
