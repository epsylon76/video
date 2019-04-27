<div class="container">
	<h1>Vidéo</h1>


	<p><strong>Nom</strong> : <?php echo $nom_fichier; ?></p>
	<p>N'oubliez pas de <strong>sauvegarder la vidéo</strong></p>
	<p>Taille du fichier : <?php echo $taille_fichier; ?></p>
	<div class="text-center" style="margin-top:50px; margin-bottom:50px;">
		<a class="btn btn-primary btn-lg" id="dl_button" href="<?php echo $chemin ?>" download="<?php echo $nom_fichier; ?>" ><i class="fas fa-download"></i>&nbsp;Télécharger la vidéo</a>
	</div>
	<br>
	<?php  if(isset($_GET['id'])){ ?>
		<a class="btn btn-success" href="?cle=<?php echo $_GET['cle'] ?>"><i class="fas fa-arrow-left">&nbsp;</i>retour</a>
	<?php } ?>
</div>
