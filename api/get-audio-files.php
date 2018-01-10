<?php
require_once 'modules/file-path.php';

// Locate available audio types: first level folders in AUDIO_FOLDER
$audioFolder = __DIR__ . '/..' . $_ENV['AUDIO_FOLDER'];
$scanResults = scandir($audioFolder);

$audioTypes = array();

foreach ($scanResults as $scanResult) {
    $filePath = new FilePath($audioFolder . '/' . $scanResult);
    // echo $filePath;
    if ($filePath->shouldIgnore() || $filePath->isRestricted()) {
    // if ($filePath->shouldIgnore()) {
        // Do nothing
    } else if ($filePath->isDirectory()) {
        $audioFileFolder = $filePath->filePath;
        $audioFiles = array_filter(
            scandir($audioFileFolder),
            function ($file) use ($audioFileFolder) {
                $fp = new FilePath($audioFileFolder . '/' . $file);
                return $fp->isAcceptableAudioFile();
            }
        );
        // Add folder information
        $audioFiles = array_map(function ($file) use ($scanResult) {
            $fp = new FilePath($_ENV['AUDIO_FOLDER'] . '/' . $scanResult . '/' . $file);
            return array(
                'audioName' => $fp->displayName,
                'audioPath' => $fp->filePath
            );
        }, $audioFiles);
        $audioTypes[] = [
            'name' => $filePath->displayDirectoryName,
            'folder' => $filePath->fileName,
            'audioFiles' => $audioFiles
        ];
    }
}

$response = $audioTypes;

header('Content-Type: application/json');
echo json_encode($response, JSON_FORCE_OBJECT);
