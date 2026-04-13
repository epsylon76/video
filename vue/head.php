<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?php echo $params['page_titre']; ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&family=Varela+Round&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.min.css" />

  <link href="https://vjs.zencdn.net/8.16.1/video-js.css" rel="stylesheet" />

  <link rel="stylesheet" href="/includes/css/custom.css">

  <?php
    $url_domaine = "https://" . $params['url_domaine'];
    $image_domaine = $url_domaine . "/img/logo.png";
  ?>
  <meta property="og:url" content="<?php echo $url_domaine; ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Mes Vidéos et Photos" />
  <meta property="og:description" content="Espace de partage sécurisé" />
  <meta property="og:image" content="<?php echo $image_domaine; ?>" />

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
  <script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>

 
  
  <script type="text/javascript" src="/includes/js/date-euro.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" defer></script>
</head>

<body style="background-color:<?php echo $params['couleur_fond']; ?>">