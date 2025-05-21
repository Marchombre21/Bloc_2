<?php

use Composer\Autoload\ClassLoader;

class EditModel
{
    public $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;

    }

    public function getDatasUser($id): array
    {
        $query = $this->db->prepare("select * from users where id = :id");
        $query->bindValue(":id", $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getDatasProduct($name)
    {
        $query = $this->db->prepare("select * from products where name = :name");
        $query->bindValue(":name", $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function applyEditsProducts($name, $price, $id, $available): bool
    {
        try {
            $query = $this->db->prepare("update products set name = :name, price = :price, available = :available where id = :id");
            $query->bindValue(":name", $name);
            $query->bindValue(":price", $price);
            $query->bindValue(":available", $available);
            $query->bindValue(":id", $id);
            return $query->execute();
        } catch (PDOException $e) {
            $_SESSION["changes"]["errors"] = "Une erreur a eu lieu lors de l'enregistrement des données.";
            error_log($e->getMessage());
            return false;
        }

    }

    public function applyEditsUser($firstname, $lastname, $email, $function, $id): bool
    {
        try {
            $query = $this->db->prepare("update users set firstname = :firstname, lastname = :lastname, email = :email, function = :function where id like :id");
            $query->bindValue(":firstname", $firstname);
            $query->bindValue(":lastname", $lastname);
            $query->bindValue(":email", $email);
            $query->bindValue(":function", $function);
            $query->bindValue(":id", $id);
            return $query->execute();
        } catch (PDOException $e) {
            $_SESSION["changes"]["errors"] = "Une erreur a eu lieu lors de l'enregistrement des données.";
            error_log($e->getMessage());
            return false;
        }

    }

    public function getOldImage($name): array
    {
        $query = $this->db->prepare("SELECT image FROM products WHERE name = :name");
        $query->execute([':name' => $name]);
        return $query->fetch();
    }

    public function updatePath($fileName, $id)
    {
        try {
            $query = $this->db->prepare("UPDATE products SET image = :image WHERE id = :id");
            return $query->execute(['image' => $fileName, 'id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

    }

    public function getDescription($category)
    {
        $query = $this->db->prepare("select description from categories where id like :id");
        $query->execute(["id" => $category]);
        return $query->fetch();
    }

    public function updateDescription($description, $id)
    {
        try {
            $query = $this->db->prepare("update categories set description = :description where id like :id");
            return $query->execute(["description" => $description, "id" => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

    }

    public function deleteProduct($id): bool
    {
        try {
            $query = $this->db->prepare("delete from products where id = :id");
            return $query->execute(["id" => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, __DIR__ . "/log_test.txt");

            return false;
        }
    }

    public function addProduct($fileName, $name, $price, $id, $available)
    {
        try {
            $query = $this->db->prepare("insert into products(name, price, image, category, available) values(:name, :price, :file, :id, :available)");
            return $query->execute([
                ":file" => $fileName,
                ":name" => $name,
                ":price" => $price,
                ":id" => $id,
                ":available" => $available
            ]);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, __DIR__ . "/log_test.txt");
            return false;
        }
    }

}
?>