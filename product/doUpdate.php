<?php
require_once("../pdo-connect.php");
if(!isset($_POST["product-name"]) || !isset($_POST["product-description"]) ||
    !isset($_POST["product-category"]) || !isset($_POST["product-price"]) ||
    !isset($_POST["product-ingredient"]) || !isset($_POST["product-nutrition"]) ||
    !isset($_POST["product-valid"])){
    header("location: edit-product.php");
}
$name = $_POST["product-name"];
$description = $_POST["product-description"];
$category = $_POST["product-category"];
$price = $_POST["product-price"];
$ingredient = $_POST["product-ingredient"];
$nutrition = $_POST["product-nutrition"];
$valid = $_POST["product-valid"];
$imageFile = $_FILES["product-image-file"];
$imageFileName = $_FILES["product-image-file"]["name"];
$imageUrl = $_POST["product-image-url"];
$id = $_POST["id"];

if(($imageFileName === "") && ($imageUrl === "")){
    $_SESSION["err_msg"] = "請選一種方式上傳圖片";
    header("location: edit-product.php?id=$id");
}else if(($imageFileName !== "") && ($imageUrl !== "")){
    $_SESSION["err_msg"] = "請選擇只上傳圖片或是只填入圖片網址";
    header("location: edit-product.php?id=$id");
}else if(($imageFileName === "") && (substr($imageUrl, 0, 4 ) !== "http")){
    $_SESSION["err_msg"] = "請選擇上傳圖片或是修正圖片網址";
    header("location: edit-product.php?id=$id");
}else if(($imageFileName === "") && ($imageUrl !== "")){
    $updateSql = "UPDATE products SET name = ?, description = ?, ingredients = ?, nutrition = ?, price = ?, image = ?,
valid = ? ,products_category = ? WHERE id = ?";
    $stmtUpdateSql = $db_host->prepare($updateSql);
    unset($_SESSION["err_msg"]);
    try {
        $stmtUpdateSql->execute([$name, $description, $ingredient, $nutrition, $price, $imageUrl, $valid, $category, $id]);
        echo "商品更新成功";
        header("location: products.php");
    } catch (PDOException $e) {
        echo "更新資料庫時出錯: " . $e->getMessage();
    }
}else{
    if($imageFile["error"] === 0){
        if(move_uploaded_file($imageFile["tmp_name"], "../sql/product_sql/images/" .$imageFile["name"])){
            $updateSql = "UPDATE products SET name = ?, description = ?, ingredients = ?, nutrition = ?, price = ?, image = ?, valid = ? ,products_category = ? WHERE id = ?";
            $stmtUpdateSql = $db_host->prepare($updateSql);
            unset($_SESSION["err_msg"]);
            try {
                $stmtUpdateSql->execute([$name, $description, $ingredient, $nutrition, $price, $imageFileName, $valid, $category, $id]);
                echo "商品更新成功";
                header("location: products.php");
            } catch (PDOException $e) {
                echo "更新資料庫時出錯: " . $e->getMessage();
            }
        }
    }else{
        echo "上傳失敗: ".print_r($_FILES);
    }
}
?>
