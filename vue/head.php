<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">


  <title><?php echo $params['page_titre']; ?></title>



  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">



  <!-- Font Awesome -->
  <link rel="stylesheet" href="/includes/css/fontawesome_6.5.2.min.css">
  <script src="/includes/js/fontawesome_6.5.2.min.js"></script>

  <!-- Fonts -->
  <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">




  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <!--datatables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  <script type="text/javascript" src="/includes/js/date-euro.js"></script>


  <!-- videojs -->
  <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />

  <link rel="stylesheet" href="/includes/css/custom.css">

  <?php
  $url_domaine = "http://" . $params['url_domaine'];
  $image_domaine = "http://" . $params['url_domaine'] . "/img/logo.png";
  ?>
  <meta property="og:url" content="<?php echo $url_domaine; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Mes Vidéos et Photos" />
  <meta property="og:description" content="Mon espace de partage vidéo et photos" />
  <meta property="og:image" content="<?php echo $image_domaine; ?>" />


  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body style="background-color:<?php echo $params['couleur_fond']; ?>">