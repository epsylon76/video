<?php
if ($uri[1] == 'login_admin') {
    include 'ctrl/actions/login_admin.php';
}


//vérification du login
if (isset($_SESSION['login']) && isset($_SESSION['pass']) && $admin->check_login_crypt($_SESSION['login'], $_SESSION['pass'])) {

    switch ($uri[1]) {

        case 'login_admin':
            include 'ctrl/actions/login_admin.php';
            break;

        case 'set_partage':
            include 'ctrl/actions/set_partage.php';
            break;

        case 'setTag':
            include 'ctrl/actions/set_tag.php';
            break;

        case "dlPhotos":
            include('ctrl/actions/dl_photos.php');
            break;

        case "uploadLogo":
            include('ctrl/actions/upload_logo.php');
            break;

        case "uploadBanniere":
            include('ctrl/actions/upload_banniere.php');
            break;

        case "uploadInvitation":
            include('ctrl/actions/upload_invitation.php');
            break;

        case "supprZip":
            include('ctrl/actions/suppr_zip.php');
            break;

        case "unsetPartage":
            include('ctrl/actions/unset_partage.php');
            break;

        case "clearIntrouvables":
            include('ctrl/actions/clear_introuvables.php');
            break;

        case "changePsw":
            include('ctrl/actions/change_psw.php');
            break;

        case "renvoiMail":
            include('ctrl/actions/renvoi_mail.php');
            break;

        case "renvoiDate":
            include('ctrl/actions/renvoi_date.php');
            break;

        case "deconnecter":
            include('ctrl/actions/deconnecter.php');
            break;

        case "addUser":
            include('ctrl/actions/set_user.php');
            break;

        case 'set_envois':
            include 'ctrl/actions/set_envois.php';
            break;

        case 'renvoi_bulk':
            include 'ctrl/actions/renvoi_bulk.php';
            break;

        case 'do_captures':
            include 'ctrl/actions/do_captures.php';
            break;
    }
}
