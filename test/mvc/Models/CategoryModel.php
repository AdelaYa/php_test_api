<?php

namespace Models;

use Core\BaseModel;
use PDO;

class CategoryModel extends BaseModel
{

    public function addCategoryToDB($categoryData): void
    {

        $sql = "INSERT INTO categories (name, client_id) VALUES(:name, :client_id);";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($categoryData);

    }

    public function deleteCategory($categoryData): void
    {
        // $dbConnect->exec('TRUNCATE TABLE product;');
        unset($categoryData['name']);
        $sql = "DELETE FROM categories WHERE id= :categoryID;";
        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($categoryData);

    }


    public function editCategory($categoryData): void
    {

        $sql = "UPDATE categories SET name= :newName WHERE id= :categoryID";


        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute($categoryData);

    }

    public function getCategories(): array
    {
        $sql = "SELECT * FROM categories";

        $stmt = $this->dbConnect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}