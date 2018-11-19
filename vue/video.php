<div class="container">
	<h1>Vidéo</h1>

	<video id="video-id" style="width:100%"> <source src="<?php echo $chemin ?>" type="video/mp4"/>
 </video>
	<script> fluidPlayer("video-id"); </script>



<a class="btn btn-primary" id="dl_button" href="<?php echo $chemin ?>" download >Télécharger la vidéo</a>
</div>
