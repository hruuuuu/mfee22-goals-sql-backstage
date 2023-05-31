<?php
require_once("../pdo-connect.php");
$sqlCategory = "SELECT * FROM class_category";
$stmtCategory = $db_host -> prepare($sqlCategory);
try{
    $stmtCategory -> execute();
    $rowCategory = $stmtCategory -> fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "課程分類獲取失敗: ". $e -> getMessage();
}
if(isset($_GET["id"])){
    $id = $_GET["id"];
}else{
    $id = 0;
}
$sql = "SELECT * FROM class WHERE id=?";
$stmt = $db_host -> prepare($sql);
try{
    $stmt -> execute([$id]);
    $productExist = $stmt -> rowCount();
    $row = $stmt -> fetch();
}catch(PDOException $e){
    echo "取得課程資料時發生錯誤: ".$e -> getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require_once("../css.php")?>
    <title>編輯課程資料</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 my-3">
            <?php if($productExist === 0):?>
                課程不存在
            <?php else: ?>
                <h2 class="py-2">編輯課程資料</h2>
                <div class="px-2">
                    <form action="doUpdate.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?=$row["id"]?>">
                        <div class="py-2">
                            <label for="product-name" class="form-label">課程名稱</label>
                            <input type="text" id="product-name" class="form-control" name="product-name" value="<?=$row["name"]?>" required>
                        </div>
                        <div class="py-2">
                            <label for="product-image" class="form-label">課程圖片</label>
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <input type="file" id="product-image" class="form-control" name="product-image-file">
                                    <div class="mx-2">或</div>
                                    <input type="url" id="product-image" class="form-control" name="product-image-url" placeholder="輸入圖片網址">
                                </div>
                                <?php if(isset($_SESSION["err_msg"])):?>
                                <span class="text-nowrap text-center text-danger mt-2"><?=$_SESSION["err_msg"]?></span>
                                <?php endif;
                                unset($_SESSION["err_msg"]);?>
                            </div>
                        </div>
                        <div class="py-2">
                            <label for="product-description" class="form-label">課程描述</label>
                            <textarea name="product-description" id="product-description" cols="30" rows="5" class="form-control" required><?php if(isset($row["description"])) echo $row["description"]?></textarea>
                        </div>
                        <div class="py-2">
                            <label class="form-label">課程分類</label>
                            <select class="form-select" name="product-category" id="product-category" value="<?=$row["category_id"]?>"required>
                                <option selected>--- 請選擇以下一個分類 ---</option>
                                <?php foreach ($rowCategory as $value):?>
                                    <option value=<?=$value["id"]?> <?php if(isset($row["category_id"]) && $row["category_id"] == $value["id"]) echo "selected"?>><?=$value["name"]?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="py-2">
                            <label for="product-price" class="form-label">課程價格</label>
                            <input type="number" id="product-price" class="form-control" name="product-price" value="<?=$row["price"]?>" required>
                        </div>
                        <div class="py-2">
                            <label for="product-valid" class="form-label">課程上下架</label>
                            <select class="form-select" name="product-valid" id="product-valid" required>
                                <option selected>--- 請選擇以下一個選項 ---</option>
                                <option value="1" <?php if(isset($row["valid"]) && $row["valid"] == 1) echo "selected"?>>上架</option>
                                <option value="2" <?php if(isset($row["valid"]) && $row["valid"] == 2) echo "selected"?>>下架</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary my-2">修改</button>
                        <a href="classes.php" class="btn btn-primary my-2" role="button"><i class="fas fa-chevron-left"></i> 回課程列表</a>
                    </form>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>
</body>
</html>
