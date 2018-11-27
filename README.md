# video

Basé sur PHP / AJAX / SQL

Ayant vécu par deux fois le malheur de perdre tout les partages du à un bug sur nextcloud ( un petit milliers de partages avec des emails différents)
Le système est conçu de manière simple et robuste, la volonté étant de remplacer nextcloud pour une utilisation intensive et professionnelle
(50 connections simultanées).

Il permet de partager des photos en affichant un diaporama en lazy load avec Slick et de télécharger l'ensemble avec un zip streamé
Il permet de partager des vidéos en affichant un leteur vidéo et un bouton de téléchargement
Il permet de partager un dossier compressé directement en zip streamé

Le système ne fait aucunn fichier temporaire
Le système donne un accès a ses partage via un email contenant un lien clé
