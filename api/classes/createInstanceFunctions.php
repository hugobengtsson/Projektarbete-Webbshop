<?php


include_once("../classes/productClass.php");
include_once("../classes/subscriberClass.php");

function createProduct($id, $name, $description, $price) {
    return new Product((int)$id, $name, $description, $price);
}


include_once("../classes/imageClass.php");

function createImage($id, $productId, $imageType, $imageSrc) {
    return new Image((int)$id, $productId, $imageType, $imageSrc);
}


include_once("../classes/sizeClass.php");

function createSize($id, $productId, $sizesInStock, $size) {
    return new Size((int)$id, $productId, (int)$sizesInStock, $size);
}


include_once("../classes/categoryClass.php");

function createCategory($id, $categoryName, $categoryDescription, $categoryImg) {
    return new Category((int)$id, $categoryName, $categoryDescription, $categoryImg);
}

include_once("../classes/productInCategoryClass.php");

function createProductInCategory($productId, $categoryId) {
    return new ProductInCategory((int)$productId, (int)$categoryId);
}


include_once("../classes/productInCategoryClass.php");

function gettAllCategoryInProduct($categoryId,$productId,$categoryName,$categoryIMG) {
    return new CategoryInProduct((int)$categoryId,(int)$productId,$categoryName,$categoryIMG );
}


// CREATES A NEW USER FROM THE UserClass
include_once("../classes/userClass.php");

function createUser($ID, $UserEmail, $UserPassword, $UserRegisterDate, $UserFirstName, $UserLastName,
$TermsConditions, $UserIsAdmin, $AdminRequest,  $UserCountry, $UserCity,  $UserStreet, $UserZipCode) {
    
    return new User((int)$ID, $UserEmail, $UserPassword, (int)$UserRegisterDate, $UserFirstName, $UserLastName,
   (int)$TermsConditions, (int)$UserIsAdmin, (int)$AdminRequest,  $UserCountry, $UserCity,  $UserStreet, $UserZipCode);
} 

include_once("../classes/subscriberClass.php");

function createSubscriber($Id, $Email, $Name) {
    return new Subscriber((int)$ID, $Email, $Name);
}


include_once("../classes/freightClass.php");

function createFreightOption($id, $type, $cost) {
    return new FreightOption((int)$id, $type, $cost);
}


?>