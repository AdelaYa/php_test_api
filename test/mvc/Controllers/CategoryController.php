<?php

namespace Controllers;

use Core\BaseController;
use Core\BaseView;
use Models\CategoryModel;

class CategoryController extends BaseController
{
    public function categoryAction(): BaseView
    {
        $name = $_SESSION['userName'];
        $userId = $_SESSION['userId'];
        $model = new CategoryModel();

        if ($this->validateCategoryData($model)) {
            header('Location: /category/category');
            exit();
        }

        // $this->page404();


        return $this->output('Category/categories', [
            'name' => $name, 'userId' => $userId, 'model' => $model,
        ]);
    }

    public function validateCategoryData($model): bool
    {
        if (isset($_POST['categoryName'])) {
            $categoryName = htmlspecialchars(trim($_POST['categoryName']));
            $userId = $_SESSION['userId'];

            $categoryData = array("name" => $categoryName, "client_id" => $userId);
            $model->addCategoryToDB($categoryData);
            return true;

        } elseif (isset($_POST['newCategoryName']) and !empty($_POST['newCategoryName'])) {
            $newCategoryName = htmlspecialchars(trim($_POST['newCategoryName']));
            $categoryID = $_POST['categoryID'];

            $categoryData = array("newName" => $newCategoryName, "categoryID" => $categoryID);
            $model->editCategory($categoryData);
            return true;


        } elseif (isset($_POST['categoryID']) and isset($_POST['name'])) {

            $categoryID = $_POST['categoryID'];

            $categoryData = array("categoryID" => $categoryID);
            $model->deleteCategory($categoryData);
            return true;

        }
        return false;
    }
}