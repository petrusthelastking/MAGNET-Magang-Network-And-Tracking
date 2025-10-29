<?php

/**
 * Laravel - Simple Router for PHP Built-in Server
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve static files directly
if ($uri !== '/' && file_exists(__DIR__.$uri)) {
    return false;
}

// Route everything else to Laravel's index.php
require_once __DIR__.'/index.php';
