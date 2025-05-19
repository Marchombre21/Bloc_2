<?php
$path = $_GET['route'] ?? '';

 // Alors là c'est 100% codeRabbit. 
 if (!preg_match('/^[a-zA-Z0-9_\-\/]+\.php$/', $path)) {
     http_response_code(400);
     echo "Invalid request";
     exit;
 }

$file = realpath(__DIR__ . '/../api/' . $path);
 $apiDir = realpath(__DIR__ . '/../api/');
 
 if ($file && file_exists($file) && strpos($file, $apiDir) === 0) {
    require $file;
} else {
    http_response_code(404);
    echo "Not found";
}