<?php
// Root Folder: __DIR__
require_once __DIR__ . '/vendor/autoload.php';

// Load .env
// Ref: https://github.com/vlucas/phpdotenv
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
