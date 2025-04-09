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
            include('ctrl/historique.php');
            include('vue/head.php');
            include('vue/historique.php');
            break;

        case "envois":
            include('ctrl/envois.php');
            include('vue/head.php');
            include('vue/nav.php');
            include('vue/envois.php');
            break;

        case "partage":
            include('ctrl/liste_partage.php');
            include('vue/head.php');
            include('vue/nav.php');
            include('vue/liste_partage.php');

            break;

        case "stats":
            include('vue/head.php');
            include('vue/nav.php');

            if (isset($uri[2]) && $uri[2] == 'introuvables') {
                include('ctrl/introuvables.php');
            } elseif (isset($uri[2]) && $uri[2] == 'bandePassante') {
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

        case "tags":
            include('vue/head.php');
            include('vue/nav.php');

            if (isset($uri[2])) {
                include('ctrl/tag.php');
            } else {
                include('ctrl/liste_tag.php');
                include('vue/liste_tag.php');
            }

            break;


        case "captures":
            include('vue/head.php');
            include('vue/nav.php');

            $chemin = '';
            for ($i = 2; isset($uri[$i]); $i++) {
                $chemin .= $uri[$i];
                if(isset($uri[$i+1])){
                    $chemin .= '/';
                }
            }
            include 'ctrl/captures.php';
            include 'vue/captures.php';
            include 'vue/footer.php';
            break;
    }
} else {
    //renvoi au login
    header('location:/');
}
