<?php
//vérification du login

if (isset($_SESSION['login']) && isset($_SESSION['pass']) && $admin->check_login_crypt($_SESSION['login'], $_SESSION['pass'])) {

    if (!isset($uri[1])) {
        header('location:/admin/dossiers');
    }
    //ROUTAGE
    switch ($uri[1]) {

        case 'dossiers':
            //controleur navigation dossiers
            if (!isset($uri[2])) {
                $chemin = "";
            } else {
                $slices = array_slice($uri, 2);
                $chemin = '';
                foreach ($slices as $u) {
                    $chemin .= $u . '/';
                }
                $chemin = urldecode($chemin);
            }

            $listefichiers = $dossier->contenu_dossier($chemin, $data);
            $breadcrumb = breadcrumb($chemin);
            include('vue/head.php');
            include('vue/nav.php');
            include('vue/admin.php');

            break;


        case "video":
            include('vue/head.php');
            include('vue/nav.php');
            include('ctrl/video.php');
            break;

        case "photos":
            include('vue/head.php');
            include('vue/nav.php');
            include('ctrl/photos.php');
            break;

        case "historique":
            include('vue/head.php');
            include('ctrl/historique.php');
            break;

        case "partage":
            include('vue/head.php');
            include('vue/nav.php');
            include('vue/liste_partage.php');
            // include('ctrl/liste_partage.php');
            break;

        case "stats": 
            include('vue/head.php');
            include('vue/nav.php');

            if (isset($uri[2]) && $uri[2] == 'introuvables'){
                include('ctrl/introuvables.php');
            }
            elseif(isset($uri[2]) && $uri[2] == 'bandePassante'){
                include('ctrl/bande_passante.php');
                break;
            
            } else {
                include('ctrl/stats.php');
            }
            break;

        case "parametres":
            include('vue/head.php');
            include('vue/nav.php');

            if (isset($uri[2]) && $uri[2] == 'users') { //bien ça !
                include('ctrl/users.php');
            } else {
                include('ctrl/parametres.php');
            }

            break;

        case "test":
            include('vue/head.php');
            include('vue/nav.php');
            include('ctrl/bande_passante.php');
            break;

        case "action":
            switch ($uri[2]) {
                case "deconnecter":
                    include ('ctrl/actions/deconnecter.php');
                    break;

                case "addUser":
                    include('ctrl/actions/set_user.php');
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

                case "supprZip":
                    include('ctrl/actions/suppr_zip.php');
                    break;

                case "unsetPartage":
                    include('ctrl/actions/unset_partage.php');
                    break;

                case "clearIntrouvables":
                    include('ctrl/actions/clear_introuvables.php');
                    break;
                
                case "uploadBanniere":
                    include('ctrl/actions/upload_banniere.php');
                    break;

                case "uploadInvitation":
                    include('ctrl/actions/upload_invitation.php');
                    break;

                case "uploadLogo":
                    include('ctrl/actions/upload_logo.php');
                    break;

                case "dlPhotos":
                    include('ctrl/actions/dl_photos.php');
                    break;

            }
    }
} else {
    //renvoi au login
    header('location:/');
}
