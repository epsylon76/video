<?php
$datachemin = urldecode($data.$chemin);
$chemin = urldecode($chemin);

$video_array = glob($data.$chemin.'/{*.mp4,*.MP4}', GLOB_BRACE);
