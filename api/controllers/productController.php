<?php

include_once("../classes/createInstanceFunctions.php");
include_once("../controllers/mainController.php");
include_once("../controllers/sizeController.php");
include_once("../controllers/imageController.php");
include_once("../controllers/productInCategoryController.php");

class ProductController extends MainController {

    private $createFunction = "createProduct";

    function __construct() {
        parent::__construct("product", "product");
    }

    public function getAll(){
        $products = $this->database->fetchAll($this->createFunction);

        $imageController = new ImageController();
        $images = $imageController->getAll();

        $sizeController = new SizeController();
        $sizes = $sizeController->getAll();

        foreach((array)$products as $key => $product) {

            $imageList = [];
            foreach((array)$images as $key => $image){
                if($product->ProductId == $image->ProductId){
                    array_push($imageList, $image);
                }
            }

            $sizeList = [];
            foreach((array)$sizes as $key => $size){
                if($product->ProductId == $size->ProductId){
                    array_push($sizeList, $size);
                }
            }

            $product->Images = $imageList;
            $product->Sizes = $sizeList;
        }

        return $products;

    }

    public function getById($id){

        $product = $this->database->fetchById($id, $this->createFunction);

        $imageController = new ImageController();
        $images = $imageController->getAll();

        $sizeController = new SizeController();
        $sizes = $sizeController->getAll();


            $imageList = [];
            foreach((array)$images as $key => $image){
                if($product->ProductId == $image->ProductId){
                    array_push($imageList, $image);
                }
            }

            $sizeList = [];
            foreach((array)$sizes as $key => $size){
                if($product->ProductId == $size->ProductId){
                    array_push($sizeList, $size);
                }
            }

            $product->Images = $imageList;
            $product->Sizes = $sizeList;

        return $product;

    }



    public function newProduct($newProduct){

        $productInformation = $newProduct[0];
        $productName = $productInformation[name];
        $productDescription = $productInformation[description];
        $productPrice = $productInformation[price];

        $product = new ProductToBeAdded(null, $productName, $productDescription, $productPrice);

        $productId = $this->database->insert($product);

        $sizeInformation = $newProduct[1];

        foreach((array)$sizeInformation as $key => $sizes) {

            foreach((array)$sizes as $key => $value) {
                if ($key == "stock") {
                    $stock = $value;
                }
                if ($key == "size") {
                    $size = $value;
                }

            }

            $size = new Size(null, $productId, $stock, $size);

            $sizeController = new SizeController();
            $return = $sizeController->newProduct($size);

        }

        $images = $newProduct[2];

        foreach((array)$images as $key => $image) {

            foreach((array)$image as $key => $value) {
                if($key == "imgType"){
                    $imgType = $value;
                }
                if($key == "src") {
                    $imgSrc = $value;
                }
            }

            $image = new Image(null, $productId, $imgType, $imgSrc);

            $imageController = new ImageController();
            $return = $imageController->newProduct($image);

        }


        $productCategory = $newProduct[3];

        $category = new ProductInCategory($productId, $productCategory);

        $productInCategoryController = new ProductInCategoryController();
        $categoryInsert = $productInCategoryController->insert($category);
        

        return $productId;

    }


    public function updateStock($sizes) {

        $array = [];

        foreach((array)$sizes as $key => $value) {

            $query = "UPDATE size SET SizesInStock=".$value["SizesInStock"]." WHERE ID =".$value["ID"];

            $response = $this->database->freeQuery($query, "createSize");

            array_push($array, $response);
        }

        return "success";

    }

    public function deleteProduct($product) {

        $id = $product["ProductId"];
        $images = $product["Images"];

        

        $sizesQuery = "DELETE FROM size WHERE ProductID =".$id.";";
        $this->database->freeQuery($sizesQuery, "createSize");

        $imageQuery = "DELETE FROM images WHERE ProductID =".$id.";";
        $this->database->freeQuery($imageQuery, "createSize");

        $categoryQuery = "DELETE FROM productincategory WHERE ProductID =".$id.";";
        $this->database->freeQuery($categoryQuery, "createSize");

        $productQuery = "DELETE FROM product WHERE ID =".$id.";";
        $this->database->freeQuery($productQuery, $this->createFunction);
        
        $array = [];

        foreach((array)$images as $key => $value) {

            $img = "../../ASSETS/PRODUCTS/".$value["ImageSrc"];

            unlink($img);

        }

        return "success";



    }


}



?>