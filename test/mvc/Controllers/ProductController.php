<?php

namespace Controllers;

use Core\BaseController;
use Core\BaseView;
use Models\ProductModel;

class ProductController extends BaseController
{
    public function productAction(): BaseView
    {
        $name = $_SESSION['userName'];
        $userId = $_SESSION['userId'];
        $model = new ProductModel();

        if ($this->validateProductData($model)) {
            header('Location: /product/product/');
            exit();

        }

        // $this->page404();

        return $this->output('Product/products', [
            'name' => $name, 'userId' => $userId, 'model' => $model,
        ]);
    }

    public function validateProductData($model)
    {
        if (isset($_POST['productName']) and isset($_POST['productPrice'])) {
            $productName = htmlspecialchars(trim($_POST['productName']));
            $productPrice = htmlspecialchars(trim($_POST['productPrice']));
            $productCategory = htmlspecialchars(trim($_POST['productCategory']));
            $productDescription = htmlspecialchars(trim($_POST['productDescription']));


            $productDescriptionData = array("description" => $productDescription);
            $productData = array("name" => $productName, "price" => $productPrice, "id_categories" => $productCategory);
            $model->addProductToDB($productData, $productDescriptionData);
            return true;

        } elseif (isset($_POST['newProductName']) or isset($_POST['newProductPrice']) or isset($_POST['newProductDescription'])) {

            $newProductName = htmlspecialchars(trim($_POST['newProductName']));
            $newProductPrice = $_POST['newProductPrice'];
            $newProductCategory = $_POST['newProductCategory'];
            $newProductDescription = htmlspecialchars(trim($_POST['newProductDescription']));
            $productID = $_POST['productID'];

            $productDescriptionData = array("newDescription" => $newProductDescription, "productID" => $productID);

            $productData = array("newName" => $newProductName, "newPrice" => $newProductPrice, "id_categories" => $newProductCategory, "productID" => $productID);
            $model->editProductDescription($productDescriptionData);
            $model->editProduct($productData);
            return true;


        } elseif (isset($_POST['productID'])) {

            $productID = $_POST['productID'];

            $productData = array("productID" => $productID);
            $model->deleteProduct($productData);
            return true;


        }
        return false;
    }
}