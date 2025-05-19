<?php
require_once '../config/config.php';
header('Content-Type: application/json');

if (isset($_GET["category"])) {
    // $stmt = $db->prepare("select * from products where category like :category");
    $stmt = $db->prepare("SELECT products.* FROM products INNER JOIN categories ON products.category = categories.id WHERE categories.name LIKE :category");
    $stmt->bindValue(":category", $_GET["category"]);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else if (isset($_GET["name"])) {
    $stmt = $db->prepare("select * from products where name like :name");
    $stmt->bindValue(":name", $_GET["name"]);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    try {
        $stmt = $db->query("select * from products");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo json_encode($e->getMessage());
    }

}

echo json_encode($products);


?>