<?php
require_once("../pdo-connect.php");
if(isset($_GET["id"])){
    $classId = $_GET["id"];
}else{
    header("location: frontend_classes.php");
}
$sql = "SELECT * FROM class WHERE id=?";
$stmt = $db_host -> prepare($sql);
try{
    $stmt -> execute([$classId]);
    $row = $stmt -> fetch();
}catch(PDOException $e){
    echo "無此課程或是獲取資料失敗: ".$e -> getMessage();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/class.css">
    <?php require_once("../css.php")?>
    <title><?=$row["name"]?></title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 py-2">
            <h2 class="py-2"><?=$row["name"]?></h2>
            <div class="py-2">
                <img class="cover-fit" src="../sql/class_sql/images/<?=$row["image"]?>" alt="<?=$row["name"]?>">
            </div>
            <p class="py-2">課程價格: $ <?=$row["price"]?></p>
            <p class="py-2">課程敘述: <?=$row["description"]?></p>
            <a href="" role="button" class="btn btn-primary">購買</a>
            <a href="frontend_classes.php" role="button" class="btn btn-primary"><i class="fas fa-chevron-left"></i> 回課程列表</a>
        </div>
    </div>
</div>
</body>
</html>