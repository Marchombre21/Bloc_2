<?php
session_start();
$path = $_GET['route'] ?? '';

 // Alors là c'est 100% codeRabbit. 
 if (!preg_match('/^[a-zA-Z0-9_\-\/]+\.php$/', $path)) {
     http_response_code(400);
     echo "Invalid request";
     exit;
 }

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized', 'status' => 401]);
    exit();
}

$file = realpath(__DIR__ . '/../api/' . $path);
 $apiDir = realpath(__DIR__ . '/../api/');
 //strpos nécessaire car si un pirate venait à mettre une adresse comme route="../../config/config.php" ça le bloquerait.
 if ($file && file_exists($file) && strpos($file, $apiDir) === 0) {
    require $file;
} else {
    http_response_code(404);
    echo "Not found";
}