<?php

namespace Models;

use Core\BaseModel;
use PDO;

class ProductModel extends BaseModel
{
    public function getProducts(): array
    {
        $sql = "SELECT * FROM product";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductDescription(): array
    {
        $sql = "SELECT * from product JOIN product_description ON product_description.product_id = product.ID;";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProductToDB($productData, $productDescriptionData): void
    {


        $sql = "INSERT INTO product (name, price, id_categories) VALUES(:name, :price, :id_categories)";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($productData);

        $sql = "SELECT ID FROM product WHERE name= :name AND price=:price AND id_categories= :id_categories";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($productData);
        $result = $stmt->fetch();
        $productDescriptionData['productID'] = $result['ID'];

        $sql = "INSERT INTO product_description (description, product_id) VALUES(:description, :productID)";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($productDescriptionData);

    }

    public function deleteProduct($productData): void
    {
        // $this->dbConnect->exec('TRUNCATE TABLE product;');

        $sql = "DELETE FROM product WHERE id= :productID;";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($productData);

    }

    public function editProductDescription($productDescriptionData): void
    {
        if (!empty($productDescriptionData["newDescription"])) {
            $sql = "UPDATE product_description SET description= :newDescription WHERE product_id= :productID";
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->execute($productDescriptionData);
        }
    }

    public function editProduct($productData): void
    {
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
            $stmt = $this->dbConnect->prepare($sql);
            $stmt->execute($productData);
        }
    }
}