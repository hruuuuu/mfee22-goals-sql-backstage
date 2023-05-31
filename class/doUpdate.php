<?php
require_once("../pdo-connect.php");
if(!isset($_POST["product-name"]) || !isset($_POST["product-description"]) ||
    !isset($_POST["product-category"]) || !isset($_POST["product-price"]) ||
    !isset($_POST["product-valid"])){
    header("location: edit-class.php");
}
$name = $_POST["product-name"];
$description = $_POST["product-description"];
$category = $_POST["product-category"];
$price = $_POST["product-price"];
$valid = $_POST["product-valid"];
$imageFile = $_FILES["product-image-file"];
$imageFileName = $_FILES["product-image-file"]["name"];
$imageUrl = $_POST["product-image-url"];
$id = $_POST["id"];

if(($imageFileName === "") && ($imageUrl === "")){
    $_SESSION["err_msg"] = "請選一種方式上傳圖片";
    header("location: edit-class.php?id=$id");
}else if(($imageFileName !== "") && ($imageUrl !== "")){
    $_SESSION["err_msg"] = "請選擇只上傳圖片或是只填入圖片網址";
    header("location: edit-class.php?id=$id");
}else if(($imageFileName === "") && (substr($imageUrl, 0, 4 ) !== "http")){
    $_SESSION["err_msg"] = "請選擇上傳圖片或是修正圖片網址";
    header("location: edit-class.php?id=$id");
}else if(($imageFileName === "") && ($imageUrl !== "")){
    $updateSql = "UPDATE class SET name = ?, description = ?, price = ?, image = ?, category_id = ?, valid = ? WHERE id = ?";
    $stmtUpdateSql = $db_host -> prepare($updateSql);
    unset($_SESSION["err_msg"]);
    try{
        $stmtUpdateSql -> execute([$name, $description, $price, $imageUrl, $category, $valid, $id]);
        echo "課程更新成功";
        header("location: classes.php");
    }catch(PDOException $e){
        echo "更新資料庫時出錯: ".$e -> getMessage();
    }
}else{
    if($imageFile["error"] === 0){
        if(move_uploaded_file($imageFile["tmp_name"], "../sql/class_sql/images/" .$imageFile["name"])){
            $updateSql = "UPDATE class SET name = ?, description = ?, price = ?, image = ?, category_id = ?, valid = ? WHERE id = ?";
            $stmtUpdateSql = $db_host -> prepare($updateSql);
            unset($_SESSION["err_msg"]);
            try{
                $stmtUpdateSql -> execute([$name, $description, $price, $imageFileName, $category, $valid, $id]);
                echo "課程更新成功";
                header("location: classes.php");
            }catch(PDOException $e){
                echo "更新資料庫時出錯: ".$e -> getMessage();
            }
        }
    }else{
        echo "上傳失敗: ".print_r($_FILES);
    }
}
?>
