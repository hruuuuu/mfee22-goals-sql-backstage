<?php
require_once("../pdo-connect.php");
if(isset($_GET["id"])){
    $id = $_GET["id"];
}else{
    header("location: classes.php");
}
$sql="UPDATE products SET valid = 2 WHERE id = ?";
$stmt = $db_host -> prepare($sql);
try{
    $stmt -> execute([$id]);
    echo "課程刪除成功";
    header("location: classes.php");
}catch(PDOException $e){
    echo "刪除課程時發生錯誤: ".$e -> getMessage();
}
?>