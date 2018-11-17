<div class="container">
	<h1>Vidéo</h1>


<video id="my-video" class="video-js" controls preload="auto" style="width:100%" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
	<source src="<?php echo $chemin ?>" type='video/mp4'>
	<source src="<?php echo $chemin ?>" type='video/webm'>
	<p class="vjs-no-js">
		To view this video please enable JavaScript, and consider upgrading to a web browser that
		<a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
	</p>
</video>

<a class="btn btn-primary" id="dl_button" href="<?php echo $chemin ?>" download >Télécharger la vidéo</a>
</div>
