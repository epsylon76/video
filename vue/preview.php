<div class="container">
  <h1>Prévisualisation Vidéo</h1>

  <p>utilisation <strong>au Hangar Uniquement</strong>, le débit demandé par la vidéo empèche son visionnage en direct à l'exterieur. <strong>Téléchargement obligatoire en dehors</strong></p>
  <video class="video-js" style="width:100%; height:500px;" id="my-video" class="video-js" controls preload="auto" width="640" height="264">
    <source src="<?php echo $chemin ?>" type="video/mp4">
  </video>

  </div>

  <script src="https://vjs.zencdn.net/7.3.0/video.js"></script>
