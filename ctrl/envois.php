<?php
$reste = $file_attente->reste('programme');

if ($params['depart_file'] <= date('Y-m-d H:i:s')) {
    if ($params['file_termine'] == 0) {
        $style = 'background-color:lightgreen;';
    } elseif ($params['file_termine'] == 1) {
        $style = 'background-color:lightblue;';
    }
} elseif ($params['depart_file'] >= date('Y-m-d H:i:s')) {
    $style = 'background-color:orange;';
}
