<?php
//vérification du login

switch($uri[1]){

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
        include ('ctrl/actions/deconnecter.php');
        break;

    case "addUser":
        include('ctrl/actions/set_user.php');
        break;

    }

        