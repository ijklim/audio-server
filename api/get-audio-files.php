<?php
// Root Folder: __DIR__ . '/..'
require(__DIR__ . '/..' . '/autoload.php');

// Locate available audio types: first level folders in AUDIO_FOLDER
$audioFolder = __DIR__ . '/..' . $_ENV['AUDIO_FOLDER'];
$scanResults = scandir($audioFolder);

$audioTypes = array();

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
    if ($scanResult == '.' || $scanResult == '..' || $scanResult[0] == '_') {
        // Do nothing
        // 1/10/18 Folders starting with _ are hidden
    } else if (is_dir($audioFolder."/".$scanResult)) {
        $audioFileFolder = $audioFolder."/".$scanResult;
        $files = array_filter(
            scandir($audioFileFolder),
            function ($file) use ($audioFileFolder) {
                return is_audio_file($audioFileFolder . '/' . $file);
            }
        );
        // Add folder information
        $files = array_map(function ($file) use ($scanResult) {
            return array(
                'audioName' => formatForDisplay(removeFileExtension($file)),
                'audioPath' => $_ENV['AUDIO_FOLDER'] . '/' . $scanResult . '/' . $file
            );
        }, $files);
        $audioTypes[] = [
            'name' => formatForDisplay($scanResult),
            'folder' => $scanResult,
            'files' => $files
        ];
    }
}

$response = $audioTypes;

header('Content-Type: application/json');
echo json_encode($response, JSON_FORCE_OBJECT);
