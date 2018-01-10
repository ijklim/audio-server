<?php
// Root Folder: __DIR__ . '/..'
require(__DIR__ . '/..' . '/autoload.php');

// Locate available audio types: first level folders in AUDIO_FOLDER
$audioFolder = __DIR__ . '/..' . $_ENV['AUDIO_FOLDER'] . '/_' . $_GET['folderCode'];
$scanResults = scandir($audioFolder);

$audioFiles = array();

/**
 * Check whether $file is an acceptable audio file
 */
function is_audio_file($file) {
    return (is_file($file) && strtolower(substr($file, -4)) === '.mp3');
}

/**
 * Remove -, capitalize first letter of each word
 */
function formatForDisplay($name) {
    $result = str_replace('-', ' ', $name);
    //$result = ucwords($result);
    return $result;
}

/**
 * Remove file extension
 */
function removeFileExtension($file) {
    return pathinfo($file, PATHINFO_FILENAME);
}

foreach ($scanResults as $scanResult) {
    if (is_audio_file($audioFolder . '/' . $scanResult)) {
        $audioFiles[] = [
            'audioName' => formatForDisplay(removeFileExtension($scanResult)),
            'audioPath' => $_ENV['AUDIO_FOLDER'] . '/_' . $_GET['folderCode'] . '/'  .$scanResult
        ];
    }
}

$response = $audioFiles;

header('Content-Type: application/json');
echo json_encode($response, JSON_FORCE_OBJECT);
