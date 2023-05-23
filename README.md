# video

Basé sur PHP / AJAX / SQL

Ayant vécu par deux fois le malheur de perdre tout les partages du à un bug sur nextcloud ( un petit milliers de partages avec des emails différents)
Le système est conçu de manière simple et robuste, la volonté étant de remplacer nextcloud pour une utilisation intensive et professionnelle
(50 connections simultanées).

Il permet de partager des photos avec un zip streamé
Il permet de partager des vidéos
Il permet de partager un dossier compressé directement en zip streamé

Le système donne un accès a ses partage via un email contenant un lien clé

il faut donner le dossier dans les paramètres, içi /stockage_video/
exemple :
//192.168.1.224/videos_venturizone /stockage_video      cifs    auto,username=abeille,password=$$$$$$$,vers=3.0,iocharset=utf8,file_mode=0777,dir_mode=0777        0       0                 
nécéssite php-mbstring
