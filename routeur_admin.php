<?php
//vérification du login

if (isset($_SESSION['login']) && isset($_SESSION['pass']) && $admin->check_login_crypt($_SESSION['login'], $_SESSION['pass']))
{
    
    if(!isset($uri[1])){
        header('location:/admin/dossiers');
    }
    //ROUTAGE
    switch($uri[1]){
        
        case 'dossiers':
            //controleur navigation dossiers
            if (!isset($uri[2])) {
                $chemin = "/";
            } else {
                $slices = array_slice($uri, 2);
                $chemin = '';
                foreach($slices as $u){
                    $chemin .= $u.'/';
                }
                $chemin = urldecode($chemin);
            }
            
            $listefichiers = $dossier->contenu_dossier($chemin, $data);
            $breadcrumb = $dossier->breadcrumb($chemin);
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
                }
                
            }else{
                //renvoi au login
                header('location:/');
            }
            