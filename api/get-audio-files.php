<?php
// Root Folder: __DIR__ . '/..'
require(__DIR__ . '/..' . '/autoload.php');

// Locate available audio types: first level folders in AUDIO_FOLDER
$audioFolder = __DIR__ . '/../' . $_ENV['AUDIO_FOLDER'];
$scanResults = scandir($audioFolder);

$audioTypes = array();

/**
 Remove -, capitalize first letter of each word
    */
function getPrettyName($name) {
    $result = str_replace('-', ' ', $name);
    $result = ucwords($result);
    return $result;
}

foreach ($scanResults as $scanResult) {
    if ($scanResult == '.' || $scanResult == '..') {
        // Do nothing
    } else if (is_dir($audioFolder."/".$scanResult)) {
        $audioFileFolder = $audioFolder."/".$scanResult;
        $files = array_filter(
            scandir($audioFileFolder),
            function($file) {
                global $audioFileFolder;
                return is_file($audioFileFolder . '/' . $file);
            }
        );
        // Add folder information
        $files = array_map(function($file) {
            global $scanResult;
            return array(
                'audioName' => getPrettyName(str_replace('.mp3', '' , $file)),
                'audioPath' => $_ENV['AUDIO_FOLDER'] . '/' . $scanResult . '/' . $file
            );
        }, $files);
        $audioTypes[] = [
            'name' => getPrettyName($scanResult),
            'folder' => $scanResult,
            'files' => $files
        ];
    }
}

$response = $audioTypes;

header('Content-Type: application/json');
echo json_encode($response, JSON_FORCE_OBJECT);
