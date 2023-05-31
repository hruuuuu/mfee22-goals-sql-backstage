<?php
require_once("../pdo-connect.php");
if(empty($_POST["product-name"]) || empty($_POST["product-description"]) ||
    empty($_POST["product-category"]) || empty($_POST["product-price"]) ||
    empty($_POST["product-ingredient"]) || empty($_POST["product-nutrition"]) ||
    empty($_POST["product-valid"])){
    $_SESSION["empty_msg"] = "您有輸入值為空";
    header("location: add-product.php");
}

if(!isset($_POST["product-name"]) || !isset($_POST["product-description"]) ||
    !isset($_POST["product-category"]) || !isset($_POST["product-price"]) ||
    !isset($_POST["product-ingredient"]) || !isset($_POST["product-nutrition"]) ||
    !isset($_POST["product-valid"])){
    header("location: add-product.php");
}

$name = $_POST["product-name"];
$description = $_POST["product-description"];
$category = $_POST["product-category"];
$price = $_POST["product-price"];
$ingredient = $_POST["product-ingredient"];
$nutrition = $_POST["product-nutrition"];
$valid = $_POST["product-valid"];
$imageUrl = $_POST["product-image-url"];
$imageFile = $_FILES["product-image-file"]; //獲取檔案名稱, 路徑
$imageFileName = $_FILES["product-image-file"]["name"]; // 獲取檔案名稱

if(($imageFileName === "") && ($imageUrl === "")){ //如果檔案名稱跟網址為空(無選擇要上傳/載入之圖片)
    $_SESSION["err_msg"] = "請選一種方式上傳圖片";
    header("location: add-product.php");
}else if(($imageFileName !== "") && ($imageUrl !== "")){ //如果檔案名稱跟網址皆不為空(都選擇要上傳/載入之圖片)
    $_SESSION["err_msg"] = "請選擇只上傳圖片或是只填入圖片網址";
    header("location: add-product.php");
}else if(($imageFileName === "") && (substr($imageUrl,0, 4) !== "http")){ //如果檔案名稱為空且網址不正確或為空
    $_SESSION["err_msg"] = "請選擇上傳圖片或是修正圖片網址";
    header("location: add-product.php");
}else if(($imageFileName === "") && ($imageUrl !== "")){ //如果檔案名稱為空且網址不為空(選擇要載入之圖片)
    $newSql = "INSERT INTO products (name, description, ingredients, nutrition, price, image, valid, products_category)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtNewSql = $db_host -> prepare($newSql);
    unset($_SESSION["err_msg"]);
    unset($_SESSION["empty_msg"]);
    try{
        $stmtNewSql -> execute([$name, $description, $ingredient, $nutrition, $price, $imageUrl, $valid, $category]);
        echo "商品新增成功";

        header("location: products.php");
    }catch(PDOException $e){
        echo "商品新增錯誤: ". $e -> getMessage();
    }
}else{
    if($imageFile["error"] === 0){
        if(move_uploaded_file($imageFile["tmp_name"], "../sql/product_sql/images/".$imageFile["name"])){
            $newSql = "INSERT INTO products (name, description, ingredients, nutrition, price, image, valid, products_category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtNewSql = $db_host -> prepare($newSql);
            unset($_SESSION["err_msg"]);
            unset($_SESSION["empty_msg"]);
            try{
                $stmtNewSql -> execute([$name, $description, $ingredient, $nutrition, $price, $imageFileName, $valid, $category]);
                echo "商品新增成功";
                header("location: products.php");
            }catch(PDOException $e){
                echo "商品新增錯誤: ". $e -> getMessage();
            }
        }else{
                echo "上傳失敗: ".print_r($_FILES);
        }
    }
}
?>

