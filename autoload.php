<?php
// Root Folder: __DIR__
require_once __DIR__ . '/vendor/autoload.php';

// Load .env
// Ref: https://github.com/vlucas/phpdotenv
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// Load configurations
class Configurations {
    private static $items;

    public static function get($key = null) {
        if (is_null(self::$items)) {
            // Load configurations from /config/app.php
            self::$items = require __DIR__ . '/config/app.php';
        }

        if (is_null($key)) {
            return self::$items;
        } else if (array_key_exists($key, self::$items)) {
            return self::$items[$key];
        } else {
            return null;
        }
    }
}

function config($key = null) {
    return Configurations::get($key);
}