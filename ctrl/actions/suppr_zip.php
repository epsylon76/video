<?php
// Your existing rrmdir function (with minor improvements for robustness)
function rrmdir($src) {
    if (!file_exists($src)) {
        return; // Path doesn't exist, nothing to do
    }
    if (is_file($src)) {
        return unlink($src); // It's a file, delete it and return
    }
    if (!is_dir($src)) {
        return false; // Not a file or a directory, something is wrong
    }

    $dir = opendir($src);
    if ($dir === false) {
        return false; // Could not open directory
    }

    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..') && ($file != '.placeholder')) {
            $full = $src . '/' . $file;
            if (is_dir($full)) {
                rrmdir($full);
            } else {
                unlink($full);
            }
        }
    }
    closedir($dir);
    return rmdir($src); // Remove the directory itself
}

$zipfolder = './zip/';

// Ensure the directory exists
if (!is_dir($zipfolder)) {
    echo $zipfolder . ' does not exist or is not a directory.';
    exit;
}

// Iterate through the direct children of $zipfolder and remove them
$items = scandir($zipfolder);
foreach ($items as $item) {
    if (($item != '.') && ($item != '..') && ($item != '.placeholder')) {
        $path = $zipfolder . $item;
        if (is_dir($path)) {
            echo '<br>Removing directory: ' . $path;
            rrmdir($path); // Remove subdirectory recursively
        } else {
            echo '<br>Removing file: ' . $path;
            unlink($path); // Remove file
        }
    }
}
echo '<br>Contents of ' . $zipfolder . ' have been cleared.';
?>
