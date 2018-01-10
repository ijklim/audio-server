<?php
require_once 'modules/file-path.php';

// Locate available audio types: first level folders in AUDIO_FOLDER
$audioFolder = __DIR__ . '/..' . $_ENV['AUDIO_FOLDER'] . '/_' . $_GET['folderCode'];
$scanResults = scandir($audioFolder);

$audioTypes = array();
$audioFiles = array();

foreach ($scanResults as $scanResult) {
    $filePath = new FilePath($audioFolder . '/' . $scanResult);
    if ($filePath->isAcceptableAudioFile()) {
        $audioFiles[] = [
            'audioName' => $filePath->displayName,
            'audioPath' => $_ENV['AUDIO_FOLDER'] . '/_' . $_GET['folderCode'] . '/' . $scanResult
        ];
    } else if ($filePath->isAudioTypeNameFile()) {
        $audioType = $filePath->displayName;
        $folder = $filePath->dirName;
    }
}

$audioTypes[] = [
    'name' => $audioType ?? htmlentities($_GET['folderCode']),
    'folder' => $folder ?? $_ENV['AUDIO_FOLDER'],
    'audioFiles' => $audioFiles
];

$response = $audioTypes;

header('Content-Type: application/json');
echo json_encode($response, JSON_FORCE_OBJECT);
