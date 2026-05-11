<?php
$chemin = chemin_relatif_normalise($chemin);
$datachemin = chemin_data_ou_404($data, $chemin);

$video_array = glob($datachemin . '/{*.mp4,*.MP4}', GLOB_BRACE);
