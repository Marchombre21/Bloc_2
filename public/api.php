<?php
$path = $_GET['route'] ?? '';

$file = realpath(__DIR__ . '/../api/' . $path);
if ($file && file_exists($file)) {
    require $file;
} else {
    http_response_code(404);
    echo "Not found";
}