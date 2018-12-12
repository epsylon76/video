<div class="container">
	<h1>Vidéo</h1>
	<p>Vous pouvez sur cette page <strong>visionner en direct la vidéo</strong>, votre débit doit être suffisant car la vidéo est en <strong>pleine qualité</strong></p>
	<p>N'oubliez pas de <strong>Télécharger la vidéo</strong> via le bouton de téléchargement sous la vidéo et de sauvegarder le fichier</p>
	<a class="btn btn-primary btn-lg" id="dl_button" href="<?php echo $chemin ?>" download="video.mp4" >Télécharger la vidéo</a>
	<br>
	<br>
	<video id="video-id" style="width:100%"> <source src="<?php echo $chemin ?>" type="video/mp4"/>
	</video>
	<script> fluidPlayer("video-id"); </script>
</div>
