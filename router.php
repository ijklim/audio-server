<?php
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
if (isset($_SERVER["PATH_INFO"])) {
    // e.g. http://localhost/动物, http://localhost/z
    $filePath = $_SERVER['DOCUMENT_ROOT'].$_SERVER["PATH_INFO"];
} else if ($_SERVER["SCRIPT_FILENAME"] != 'router.php' && is_file($_SERVER["SCRIPT_FILENAME"])) {
    // e.g. http://localhost/audio/相同/动物.mp3, http://localhost/动物.php
    $filePath = $_SERVER["SCRIPT_FILENAME"];
} else {
    $filePath = $_SERVER['DOCUMENT_ROOT'].$_SERVER["REQUEST_URI"];
}



if (preg_match('/(.)+\/\.(.)+/', $filePath)) {
    // File or directory starting with . is prohibited
    // Note: \/ = /
    // Note: \. = .
    echo "Invalid request";
} else if (is_file($filePath)) {
    // File
    $finalFilePath = $filePath;
} else if (is_dir($filePath)){
    // Directory
    // Attempt to find an index file
    foreach (['index.php', 'index.html'] as $indexFile){
        $checkFile = realpath($filePath . DIRECTORY_SEPARATOR . $indexFile);
        if (is_file($checkFile)) {
            $finalFilePath = $checkFile;
            break;
        }
    }
    if (!$finalFilePath) {
        http_response_code(404);
    }
} else {
    // Auto add .php
    $checkFile = realpath($filePath . '.php');
    if (is_file($checkFile)) {
        // Matches a file after add .php
        $finalFilePath = $checkFile;
    } else {
        // Support link to access restricted audio folders starting with _
        // e.g. localhost/5898775 matches /audio/_5898775
        require_once __DIR__ . '/autoload.php';
        $audioFolder = __DIR__ . $_ENV['AUDIO_FOLDER'];
        $folderCode = pathinfo($filePath, PATHINFO_FILENAME);
        $restrictedFolder = $audioFolder . '/_' . $folderCode;
        if (is_dir($restrictedFolder)) {
            $finalFilePath = __DIR__ . '/restricted.php';
        } else {
            echo '<p>* File not found: ' . $filePath;
        }
    }
}

if ($finalFilePath) {
    switch (strtolower(substr($finalFilePath, -4))) {
        case '.mp3':
            $referer = $_SERVER['HTTP_REFERER'] ?? false;
            if ($referer) {
                // TODO: Check same referer before serving file
                header('Content-type: audio/mpeg');
                header('Content-length: ' . filesize($finalFilePath));
                header('X-Pad: avoid browser bug');
                header('Cache-Control: no-cache');
                readfile($finalFilePath);
            } else {
                // Direct request of audio file is not permitted
                http_response_code(404);
                echo 'Resource is not available';
            }
            break;
        default:
            include($finalFilePath);
            break;
    }
}
