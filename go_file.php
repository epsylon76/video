<?php
require 'config/config.php';
$params = get_params();

include_once('mdl/file_attente.php');
$file_attente = new file_attente();

include 'config/fonctions.php';


echo date('Y-m-d H:i:s');
//envois immediats
$res = $file_attente->one_file('1');

if ($res) {
    $cle = $res['cle'];
    $mailto = $res['email'];

    //email
    include('config/mail_config.php');
    include('config/email_template.php');

    if (isset($res['email_type']) && $res['email_type'] == 2) {
        $sujet = $params['email_sujet_alt'];
    } else {
        $sujet = $params['email_sujet'];
    }


    $mail->Subject = $sujet;
    $mail->Body = $corps;
    $mail->AddAddress($mailto); //$mailto doit etre défini lors de l'inclusion de ce fichier
    $mail->Send();

    //update
    $upd = $DB_con->prepare("UPDATE `file_attente` SET `done` = NOW() WHERE `file_id` = :id");
    $upd->bindParam(':id', $res['file_id']);
    $upd->execute();
}

//envois différés

if (($params['depart_file'] <= date('Y-m-d H:i:s')) && $params['file_termine'] == 0) {

    $res = $file_attente->one_file('0');
    if ($res) {
        $cle = $res['cle'];
        $mailto = $res['email'];

        //email
        include('config/mail_config.php');
        include('config/email_template.php');

        if (isset($res['email_type']) && $res['email_type'] == 2) {
            $sujet = $params['email_sujet_alt'];
        } else {
            $sujet = $params['email_sujet'];
        }


        $mail->Subject = $sujet;
        $mail->Body = $corps;
        $mail->AddAddress($mailto); //$mailto doit etre défini lors de l'inclusion de ce fichier
        $mail->Send();

        //update
        $upd = $DB_con->prepare("UPDATE `file_attente` SET `done` = NOW() WHERE `file_id` = :id");
        $upd->bindParam(':id', $res['file_id']);
        $upd->execute();
    }else{//plus aucun à faire
        file_finish(); //mettre la prog à terminé
    }
}
