<?php
include "database.php";
$database = new Database();

//error_reporting(E_ERROR | E_PARSE);
if (isset($_POST['authClick'])) {
    if (isset($_POST['authorization_login']) and isset($_POST['authorization_password'])) {
        $login = htmlspecialchars(trim($_POST['authorization_login']));
        $password = $_POST['authorization_password'];
        $data = array('login' => $login, 'password' => $password);
        $userId = $database->checkInDb($data);
        if (!empty($userId)) {
            setcookie('userId', $userId, time() + 3600);
            header('Location: /test/categories.php');
            exit;
        }
    }
}

if (isset($_POST['register_login']) and isset($_POST['register_password'])) {
    $login = htmlspecialchars(trim($_POST['register_login']));
    $password = $_POST['register_password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $data = array('login' => $login, 'password' => $hash);

    $database->addUserToDb($data);

}  //isset(addProduct)
elseif (isset($_POST['productName']) and isset($_POST['productPrice'])) {
    $productName = htmlspecialchars(trim($_POST['productName']));
    $productPrice = htmlspecialchars(trim($_POST['productPrice']));
    $productCategory = htmlspecialchars(trim($_POST['productCategory']));
    $productDescription = htmlspecialchars(trim($_POST['productDescription']));


    $productDescriptionData = array("description" => $productDescription);
    $productData = array("name" => $productName, "price" => $productPrice, "id_categories" => $productCategory);
    $database->addProductToDB($productData, $productDescriptionData);
    //header
} elseif (isset($_POST['newProductName']) or isset($_POST['newProductPrice']) or isset($_POST['newProductDescription'])) {

    $newProductName = htmlspecialchars(trim($_POST['newProductName']));
    $newProductPrice = $_POST['newProductPrice'];
    $newProductCategory = $_POST['newProductCategory'];
    $newProductDescription = htmlspecialchars(trim($_POST['newProductDescription']));
    $productID = $_POST['productID'];

    $productDescriptionData = array("newDescription" => $newProductDescription, "productID" => $productID);

    $productData = array("newName" => $newProductName, "newPrice" => $newProductPrice, "id_categories" => $newProductCategory, "productID" => $productID);
    $database->editProductDescription($productDescriptionData);
    $database->editProduct($productData);


} elseif (isset($_POST['productID'])) {

    $productID = $_POST['productID'];

    $productData = array("productID" => $productID);
    $database->deleteProduct($productData);

} elseif (isset($_POST['categoryName'])) {
    $categoryName = htmlspecialchars(trim($_POST['categoryName']));
    $userId = $_POST['UserId'];

    $categoryData = array("name" => $categoryName, "client_id" => $userId);
    $database->addCategoryToDB($categoryData);
    //header
} elseif (isset($_POST['newCategoryName'])) {

    $newCategoryName = htmlspecialchars(trim($_POST['newCategoryName']));
    $categoryID = $_POST['categoryID'];
    $userId = $_POST['UserId'];

    $categoryData = array("newName" => $newCategoryName, "categoryID" => $categoryID, "client_id" => $userId);
    $database->editCategory($categoryData);

} elseif (isset($_POST['categoryID'])) {

    $categoryID = $_POST['categoryID'];

    $categoryData = array("categoryID" => $categoryID);
    $database->deleteCategory($categoryData);

}
