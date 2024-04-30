<?php echo $params['analytics']; //analytics seulement sur la vue client ?>

<link href="/includes/css/video.css" rel="stylesheet">

<div class="container">
	<h1 style="display:flex; justify-content:center; font-size:2rem;"> <?php echo $nom_fichier; ?></h1>

	<div class="video-wrapper">
		<video id="id-video" data-chemin="<?php echo $chemin?>" controls preload="none">
			<source id="id-source" src="<?php echo $chemin; ?>" type="video/mp4" />
		</video>
	</div>

	<div style="margin-top: 20px;">
		<p>N'oubliez pas de <strong>sauvegarder la vidéo</strong></p>
		<p><strong>Taille du fichier :</strong> <?php echo HumanSize($taille_fichier); ?></p>
		<div style="display: flex; justify-content:center;">
			<a id="bouton-dl" class="btn btn-primary" style="font-size:14;" data-taille="<?php echo $taille_fichier ?>" data-chemin="<?php echo $chemin; ?>" data-email="<?php echo $email; ?>" href="<?php echo $chemin; ?>" download="<?php echo $nom_fichier; ?>"><i class="fas fa-download"></i> Télécharger la vidéo</a>
		</div>
	</div>

	<div>
		<?php if ($mode == "user") { ?>
			<a class="btn btn-success" href="/cle/<?php echo $uri[1]; ?>"><i class="fas fa-arrow-left"></i> Retour</a>
		<?php } ?>
	</div>
</div>

<script>


</script>
