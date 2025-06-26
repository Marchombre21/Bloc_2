<?php
require_once '../config/config.php';
header('Content-Type: application/json');


$stmt = $db->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($categories);