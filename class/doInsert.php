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
    !isset($_POST["product-valid"])){
    header("location: add-class.php");
}
$name = $_POST["product-name"];
$description = $_POST["product-description"];
$category = $_POST["product-category"];
$price = $_POST["product-price"];
$valid = $_POST["product-valid"];
$imageUrl = $_POST["product-image-url"];
$imageFile = $_FILES["product-image-file"];
$imageFileName = $_FILES["product-image-file"]["name"];

if(($imageFileName === "") && ($imageUrl === "")){
    $_SESSION["err_msg"] = "請選一種方式上傳圖片";
    header("location: add-class.php");
}else if(($imageFileName !== "") && ($imageUrl !== "")){
    $_SESSION["err_msg"] = "請只選一種方式上傳圖片";
    header("location: add-class.php");
}else if(($imageFileName === "") && (substr($imageUrl, 0, 4) !== "http")){
    $_SESSION["err_msg"] = "請選擇上傳圖片或是修正圖片網址";
    header("location: add-class.php");
}else if(($imageFileName === "") && ($imageUrl !== "")){
    $newSql = "INSERT INTO class (name, description, price, image, category_id, valid)
VALUES (?, ?, ?, ?, ?, ?)";
    $stmtNewSql = $db_host -> prepare($newSql);
    unset($_SESSION["err_msg"]);
    unset($_SESSION["empty_msg"]);
    try{
        $stmtNewSql -> execute([$name, $description, $price, $imageUrl, $category, $valid]);
        echo "課程新增成功";
        header("location: classes.php");
    }catch(PDOException $e){
        echo "課程新增錯誤: ". $e -> getMessage();
    }
}else{
    if($imageFile["error"] === 0){
        if(move_uploaded_file($imageFile["tmp_name"], "../sql/class_sql/images/".$imageFile["name"])){
            $newSql = "INSERT INTO class (name, description, price, image, category_id, valid)
VALUES (?, ?, ?, ?, ?, ?)";
            $stmtNewSql = $db_host -> prepare($newSql);
            unset($_SESSION["err_msg"]);
            unset($_SESSION["empty_msg"]);
            try{
                $stmtNewSql -> execute([$name, $description, $price, $imageFileName, $category, $valid]);
                echo "課程新增成功";
                header("location: classes.php");
            }catch(PDOException $e){
                echo "課程新增錯誤: ". $e -> getMessage();
            }
        }else{
            echo "上傳失敗: ".print_r($_FILES);
        }
    }
}
?>

