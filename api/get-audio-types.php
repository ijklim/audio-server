<?php
require($_SERVER['DOCUMENT_ROOT'].'\autoload.php');

// Locate available audio types: first level folders in AUDIO_FOLDER
$audioFolder = $_SERVER['DOCUMENT_ROOT'].$_ENV['AUDIO_FOLDER'];
$files = scandir($audioFolder);

$audioTypes = array();

/**
 Remove -, capitalize first letter of each word
    */
function getPrettyName($name) {
    $result = str_replace('-', ' ', $name);
    $result = ucwords($result);
    return $result;
}

foreach ($files as $file) {
    if ($file == '.' || $file == '..') {
        // Do nothing
    } else if (is_dir($audioFolder."/".$file)) {
        $audioTypes[] = [
            'name' => getPrettyName($file),
            'folder' => $file
        ];
    }
}

$response = $audioTypes;

header('Content-Type: application/json');
echo json_encode($response, JSON_FORCE_OBJECT);
