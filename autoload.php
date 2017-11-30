<?php
    require($_SERVER['DOCUMENT_ROOT'].'\vendor\autoload.php');

    // Load .env
    // Ref: https://github.com/vlucas/phpdotenv
    $dotenv = new Dotenv\Dotenv($_SERVER['DOCUMENT_ROOT']);
    $dotenv->load();
