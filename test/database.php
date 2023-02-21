<?php

use Models\DbConnect;

include "DbConnect.php";


class  Database
{
    public function addUserToDb($data): void
    {
        $dbConnect = DbConnect::getConnect();
        $sql = "INSERT INTO logins  (login, password_hash) VALUES (:login, :password)";
        $query = $dbConnect->prepare($sql);
        $query->execute($data);
        echo "Успешно";
    }

    public function checkInDb($data)
    {
        $dbConnect = DbConnect::getConnect();
        $dataPassword = $data['password'];
        unset($data['password']);


        $sql = "SELECT * FROM logins WHERE login = :login;)";
        $query = $dbConnect->prepare($sql);
        $query->execute($data);
        $result = $query->fetch();
        if ($result["login"] != $data['login'] or !password_verify($dataPassword, $result["password_hash"])) {
            echo "Неверный логин или пароль";
        } else {
            return $result["id"];
        }
        return null;
    }


    public function addProductToDB($productData, $productDescriptionData): void
    {
        $dbConnect = DbConnect::getConnect();


        $sql = "INSERT INTO product (name, price, id_categories) VALUES(:name, :price, :id_categories)";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($productData);

        $sql = "SELECT ID FROM product WHERE name= :name AND price=:price AND id_categories= :id_categories";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($productData);
        $result = $stmt->fetch();
        $productDescriptionData['productID'] = $result['ID'];

        $sql = "INSERT INTO product_description (description, product_id) VALUES(:description, :productID)";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($productDescriptionData);

    }

    public function deleteProduct($productData): void
    {
        $dbConnect = DbConnect::getConnect();
        // $dbConnect->exec('TRUNCATE TABLE product;');

        $sql = "DELETE FROM product WHERE id= :productID;";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($productData);

    }

    public function editProductDescription($productDescriptionData): void
    {
        $dbConnect = DbConnect::getConnect();
        if (!empty($productDescriptionData["newDescription"])) {
            $sql = "UPDATE product_description SET description= :newDescription WHERE product_id= :productID";
            $stmt = $dbConnect->prepare($sql);
            $stmt->execute($productDescriptionData);
        }
    }

    public function editProduct($productData): void
    {
        $dbConnect = DbConnect::getConnect();
        if (!empty($productData["newName"])) {
            if (!empty($productData["newPrice"])) {
                if (!empty($productData["id_categories"])) {
                    $sql = "UPDATE product SET name= :newName, price= :newPrice, id_categories= :id_categories WHERE id= :productID";
                } else {
                    unset($productData["id_categories"]);
                    $sql = "UPDATE product SET name= :newName, price= :newPrice WHERE id= :productID";
                }
            } elseif (!empty($productData["id_categories"])) {
                unset($productData["newPrice"]);
                $sql = "UPDATE product SET name= :newName, id_categories= :id_categories WHERE id= :productID";
            } else {
                unset($productData["id_categories"]);
                unset($productData["newPrice"]);
                $sql = "UPDATE product SET name= :newName WHERE id= :productID";
            }

        } elseif (!empty($productData["newPrice"])) {
            unset($productData["newName"]);
            if (!empty($productData["id_categories"])) {
                $sql = "UPDATE product SET price= :newPrice, id_categories= :id_categories WHERE id= :productID";
            } else {
                unset($productData["id_categories"]);
                $sql = "UPDATE product SET price= :newPrice WHERE id= :productID";
            }

        } elseif (!empty($productData["id_categories"])) {
            unset($productData["newName"]);
            unset($productData["newPrice"]);
            $sql = "UPDATE product SET id_categories= :id_categories WHERE id= :productID";
        }
        if (!empty($sql)) {
            $stmt = $dbConnect->prepare($sql);
            $stmt->execute($productData);
        }
    }

    public function addCategoryToDB($categoryData): void
    {
        $dbConnect = DbConnect::getConnect();

        $sql = "INSERT INTO categories (name, client_id) VALUES(:name, :client_id);";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($categoryData);

    }

    public function deleteCategory($categoryData): void
    {
        $dbConnect = DbConnect::getConnect();
        // $dbConnect->exec('TRUNCATE TABLE product;');

        $sql = "DELETE FROM categories WHERE id= :categoryID;";
        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($categoryData);

    }


    public function editCategory($categoryData): void
    {
        $dbConnect = DbConnect::getConnect();

        $sql = "UPDATE categories SET name= :newName WHERE id= :categoryID";


        $stmt = $dbConnect->prepare($sql);
        $stmt->execute($categoryData);

    }

    public function getProducts(): array
    {
        $sql = "SELECT * FROM product";

        $stmt = DbConnect::getConnect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories(): array
    {
        $sql = "SELECT * FROM categories";

        $stmt = DbConnect::getConnect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductDescription(): array
    {
        $sql = "SELECT * from product JOIN product_description ON product_description.product_id = product.ID;";

        $stmt = DbConnect::getConnect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}









