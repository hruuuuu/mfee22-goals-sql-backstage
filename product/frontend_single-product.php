<?php
require_once("../pdo-connect.php");
if(isset($_GET["id"])){
    $productId = $_GET["id"];
}else{
    header("location: frontend_products.php");
}
$sql = "SELECT * FROM products WHERE id=?";
$stmt = $db_host -> prepare($sql);
try{
    $stmt -> execute([$productId]);
    $row = $stmt -> fetch();
}catch(PDOException $e){
    echo "無此商品或是獲取資料失敗: ".$e -> getMessage();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/product.css">
    <?php require_once("../css.php")?>
    <title><?=$row["name"]?></title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 py-2">
                <h2 class="py-2"><?=$row["name"]?></h2>
                <div class="py-2">
                    <img class="cover-fit" src="../sql/product_sql/images/<?=$row["image"]?>" alt="<?=$row["name"]?>">
                </div>
                <p class="py-2">商品價格: $ <?=$row["price"]?></p>
                <p class="py-2">商品敘述: <?=$row["description"]?></p>
                <p class="py-2 fs-5">營養標示: <?=$row["nutrition"]?></p>
                <p class="py-2">商品成份: <?=$row["ingredients"]?></p>
<!--                <a role="button" class="btn btn-primary">購買</a>-->
                <a href="frontend_products.php" role="button" class="btn btn-primary"><i class="fas fa-chevron-left"></i> 回商品列表</a>
            </div>
        </div>
    </div>
</body>
</html>