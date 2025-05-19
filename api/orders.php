<?php
session_start();
require_once '../config/config.php';
header('Content-Type: application/json');
$datas = file_get_contents('php://input');
$data = json_decode($datas, true);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        try {
            if (isset($_GET["number"])) {
                $stmt = $db->prepare("select * from order_items where order_number like :number");
                $stmt->bindValue(":number", $_GET["number"]);
                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else if (isset($_GET["action"])) {
                // echo json_encode('action');
                $stmt = $db->prepare("select * from orders where isCompleted = 1");
                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {

                $stmt = $db->query("SELECT *, TIMESTAMPDIFF(MINUTE, order_date, NOW()) AS time FROM orders where isCompleted = 0 ORDER BY time DESC");
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode($orders);
        } catch (PDOException $e) {
            echo json_encode(["error" => $e->getMessage()]);
        }

        break;

    case 'POST':
        $response = [];

        $stmt = $db->prepare("insert into orders(order_number, order_price, order_date , tableTent) values(:number, :price, NOW(), :tent)");
        $stmt->bindValue(":number", $data["orderNumber"]);
        $stmt->bindValue(":price", $data["result"]);
        $stmt->bindValue(":tent", $data["tableTent"]);

        try {
            $stmt->execute();
            $response[] = "La commande n° " . $data["orderNumber"] . " a bien été enregistrée.";
        } catch (PDOException $e) {
            $response[] = "Une erreur est survenue lors de l'enregistrement: " . $e->getMessage();
        }

        foreach ($data["orderChoices"] as $key => $value) {
            $xxl = !empty($value['xxl']) ? 1 : 0;
            $query = $db->prepare("insert into order_items(order_number, product_name, xxl, quantity) values(:number, :name, :xxl, :quantity)");

            try {
                $query->execute([
                    ":number" => $data["orderNumber"],
                    ":name" => $value["name"],
                    ":xxl" => $xxl,
                    ":quantity" => $value["quantity"]
                ]);
            } catch (PDOException $e) {
                $response[] = "Une erreur est survenue lors de l'envoi de la commande aux cuisines: " . $e->getMessage();
            }

        }
        echo json_encode($response);
        break;

    case 'PATCH':
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "PREP") {
            if (isset($_GET["number"]) && !empty($_GET["number"])) {
                try {
                    $stmt = $db->prepare("update orders set isCompleted = true where order_number like :number");
                    $stmt->bindValue(":number", $_GET["number"]);
                    $stmt->execute();
                    echo json_encode(["success" => true]);
                    exit;
                } catch (PDOException $e) {
                    echo json_encode("Un problème est survenu lors de la validation de la commande : " . $e->getMessage());
                }

            }
        } else {

            header("location: ../../../index.php");
        }
        break;
        
    case 'DELETE':
        if (isset($_SESSION["user"]) && $_SESSION["user"]["function"] === "ACC") {
            if (isset($_GET["number"]) && !empty($_GET["number"])) {
                try {
                    $stmt = $db->prepare("delete from orders where order_number = :number");
                    $stmt->bindValue(":number", $_GET["number"]);
                    if ($stmt->execute()) {
                        echo json_encode(["success" => true]);
                    }

                } catch (PDOException $e) {
                    echo json_encode($e->getMessage());
                }

            } else {
                echo json_encode(["error" => "Aucune commande à valider dans la requête."]);
            }
        } else {
            header("location: ../../../index.php");
        }
        break;
}




?>