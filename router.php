<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/api/modules/file-path.php';

// Ref: https://stackoverflow.com/questions/27381520/php-built-in-server-and-htaccess-mod-rewrites
// Ref: http://php.net/manual/en/features.commandline.webserver.php

/* Debug information */
if (0) {
    echo '<pre>';
    print_r($_SERVER);
    echo '</pre>';
}



chdir(__DIR__);

// Note: Somehow php knows how to deal with a mixture of / and \ in file path
$finalFilePath = false; // Will contain proper file path if the request is valid
$pageNotFoundPath = new FilePath(__DIR__ . '/404.php');
if (isset($_SERVER["PATH_INFO"])) {
    // e.g. http://localhost/动物, http://localhost/z
    $file = $_SERVER['DOCUMENT_ROOT'].$_SERVER["PATH_INFO"];
} else if ($_SERVER["SCRIPT_FILENAME"] != 'router.php' && is_file($_SERVER["SCRIPT_FILENAME"])) {
    // e.g. http://localhost/audio/相同/动物.mp3, http://localhost/动物.php
    $file = $_SERVER["SCRIPT_FILENAME"];
} else {
    $file = $_SERVER['DOCUMENT_ROOT'].$_SERVER["REQUEST_URI"];
}


$filePath = new FilePath($file);
if ($filePath->isFile()) {
    // File
    $finalFilePath = $filePath;
} else if ($filePath->isDirectory()){
    // Directory
    // Attempt to find an index file
    foreach (['index.php', 'index.html'] as $indexFile){
        $checkFile = new FilePath($filePath->filePath . DIRECTORY_SEPARATOR . $indexFile);
        if ($checkFile->isFile()) {
            $finalFilePath = $checkFile;
            break;
        }
    }
    if (!$finalFilePath) {
        $finalFilePath = $pageNotFoundPath;
    }
} else {
    // Auto add .php
    $checkFile = new FilePath($filePath->filePath . '.php');
    if ($checkFile->isFile()) {
        // Matches a file after add .php
        $finalFilePath = $checkFile;
    } else {
        // Support link to access restricted audio folders starting with _
        // e.g. localhost/5898775 matches /audio/_5898775
        $audioFolder = __DIR__ . $_ENV['AUDIO_FOLDER'];
        $folderCode = $filePath->fileName;
        $restrictedFilePath = new FilePath($audioFolder . '/_' . $folderCode);
        if ($restrictedFilePath->isDirectory()) {
            $finalFilePath = new FilePath(__DIR__ . '/restricted.php');
        } else {
            $finalFilePath = $pageNotFoundPath;
        }
    }
}

if ($finalFilePath) {
    if ($finalFilePath->isAcceptableAudioFile()) {
        $referer = $_SERVER['HTTP_REFERER'] ?? false;
        if ($referer) {
            // TODO: Check same referer before serving file
            header('Content-type: audio/mpeg');
            header('Content-length: ' . filesize($finalFilePath->filePath));
            header('X-Pad: avoid browser bug');
            header('Cache-Control: no-cache');
            readfile($finalFilePath->filePath);
        } else {
            // Direct request of audio file is not permitted
            // http_response_code(404);
            include($pageNotFoundPath->filePath);
        }
    } else if ($finalFilePath->shouldIgnore()) {
        include($pageNotFoundPath->filePath);
    } else if ($finalFilePath->isFile()) {
        include($finalFilePath->filePath);
    }
}
