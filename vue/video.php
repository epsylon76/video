<?php echo $params['analytics']; //analytics seulement sur la vue client ?>

<link href="/includes/css/video.css" rel="stylesheet">
<script src="https://cdn.fluidplayer.com/v3/current/fluidplayer.min.js"></script>


<div class="container">
	<h1 style="display:flex; justify-content:center; font-size:2rem;"> <?php echo $nom_fichier; ?></h1>


		<video id="id-video" data-chemin="<?php echo $chemin?>" controls preload="none">
			<source id="id-source" src="<?php echo urldecode($chemin); ?>" type="video/mp4" />
		</video>


	<div style="margin-top: 20px;">
		<p><strong>Taille du fichier :</strong> <?php echo HumanSize($taille_fichier); ?></p>
		<div style="display: flex; justify-content:center;">
			<a id="bouton-dl" class="btn btn-primary" style="font-size:14;" data-taille="<?php echo $taille_fichier ?>" data-chemin="<?php echo $chemin; ?>" data-email="<?php echo $email; ?>" data-action="dl_video" href="<?php echo $chemin; ?>" download="<?php echo $nom_fichier; ?>"><i class="fas fa-download"></i> Télécharger la vidéo</a>
		</div>
	</div>

	<div>
		<?php if ($mode == "user") { ?>
			<a class="btn btn-success" href="/cle/<?php echo $uri[1]; ?>"><i class="fas fa-arrow-left"></i> Retour</a>
		<?php } ?>
	</div>
</div>

<script>
var player = fluidPlayer('id-video');

</script>
