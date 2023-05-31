<?php
    require_once("../pdo-connect.php");
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        header("location: products.php");
    }
    $sql="UPDATE products SET valid = 2 WHERE id = ?";
    $stmt = $db_host -> prepare($sql);
    try{
        $stmt -> execute([$id]);
        echo "商品刪除成功";
        header("location: products.php");
    }catch(PDOException $e){
        echo "刪除商品時發生錯誤: ".$e -> getMessage();
    }
?>