<?php
// Ref: https://stackoverflow.com/questions/27381520/php-built-in-server-and-htaccess-mod-rewrites
// Ref: http://php.net/manual/en/features.commandline.webserver.php

chdir(__DIR__);
// Note: Somehow php knows how to deal with a mixture of / and \ in file path
$filePath = $_SERVER['DOCUMENT_ROOT'].$_SERVER["REQUEST_URI"];
$finalFilePath = false; // Will contain proper file path if the request is valid
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
} else {
    // Auto add .php
    $checkFile = realpath($filePath . '.php');
    if (is_file($checkFile)) {
        // Matches a file after add .php
        $finalFilePath = $checkFile;
    } else {
        echo 'File not found: ' . $filePath;
    }
}

if ($finalFilePath) {
    switch (substr($finalFilePath, -4)) {
        case '.mp3':
            header('Content-type: audio/mpeg');
            header('Content-length: ' . filesize($finalFilePath));
            header('Content-Disposition: filename=' . 'test.mp3');
            header('X-Pad: avoid browser bug');
            header('Cache-Control: no-cache');
            readfile($finalFilePath);
            break;
        default:
            include($finalFilePath);
            break;
    }
}
