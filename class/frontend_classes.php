<?php
require_once("../pdo-connect.php");
$sqlcategory = "SELECT * FROM class_category";
$stmtCategory = $db_host -> prepare($sqlcategory);
try{
    $stmtCategory -> execute();
    $rowCategory = $stmtCategory -> fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "課程分類獲取失敗: ". $e -> getMessage();
}

$sqlTotal = "SELECT * FROM class WHERE valid = 1";
$stmtTotal = $db_host -> prepare($sqlTotal);
$stmtTotal -> execute();
$totalClasses = $stmtTotal -> rowCount();

if(isset($_GET["order"])){
    $orderMethod = $_GET["order"];
    switch ($orderMethod){
        case "nameDesc":
            $sqlClasses = "SELECT * FROM class ORDER BY name DESC";
            break;
        case "nameAsc":
            $sqlClasses = "SELECT * FROM class ORDER BY name ASC";
            break;
        case "priceDesc":
            $sqlClasses = "SELECT * FROM class ORDER BY price DESC";
            break;
        case "priceAsc":
            $sqlClasses = "SELECT * FROM class ORDER BY price ASC";
            break;
        case "idDesc":
            $sqlClasses = "SELECT * FROM class ORDER BY id DESC";
            break;
        case "idAsc":
            $sqlClasses = "SELECT * FROM class ORDER BY id ASC";
            break;
        default:
            break;
    }
    $stmtClasses = $db_host -> prepare($sqlClasses);
    try{
        $stmtClasses -> execute();
        $classesCount = $stmtClasses -> rowCount();
        $rowClasses = $stmtClasses -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}else if(isset($_GET["search"])){
    $search = $_GET["search"];
    $sqlClasses = "SELECT * FROM class WHERE name LIKE '%$search%' AND valid = 1";
    $stmtClasses = $db_host -> prepare($sqlClasses);
    try{
        $stmtClasses -> execute();
        $classesCount = $stmtClasses -> rowCount();
        $rowClasses = $stmtClasses -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}else if(isset($_GET["category"])){
    $category = $_GET["category"];
    $sqlClasses = "SELECT * FROM class WHERE category_id = ? AND valid = 1";
    $stmtClasses = $db_host -> prepare($sqlClasses);
    try{
        $stmtClasses -> execute([$category]);
        $classesCount = $stmtClasses -> rowCount();
        $rowClasses = $stmtClasses -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}else if(isset($_GET["minprice"]) || isset($_GET["maxprice"])){
    $min_price = $_GET["minprice"];
    $max_price = $_GET["maxprice"];
    if($min_price == ""){
        $min_price = 0;
    }else{
        $min_price = $_GET["minprice"];
    }
    if($max_price == ""){
        $max_price = 3000;
    }else{
        $max_price = $_GET["maxprice"];
    }
    $sqlClasses = "SELECT * FROM class WHERE class.price BETWEEN ? AND ?";
    $stmtClasses = $db_host -> prepare($sqlClasses);
    try{
        $stmtClasses -> execute([$min_price, $max_price]);
        $classesCount = $stmtClasses -> rowCount();
        $rowClasses = $stmtClasses -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}else{
    if(isset($_GET["page"])){
        $page = $_GET["page"];
        $prevPage = $page - 1;
        $nextPage = $page + 1;
    }else{
        $page = 1;
        $prevPage = 1;
        $nextPage = $page + 1;
    }
    $pageItems = 6;
    $totalPages = $totalClasses / $pageItems;
    $remainItems = $totalClasses / $pageItems;
    $startItem = ($page - 1) * $pageItems;
    $startNum = ($page - 1) * $pageItems + 1;
    $endNum = $page * $pageItems;
    if($remainItems !== 0){
        $totalPages = ceil($totalClasses / $pageItems);
        if($page == $totalPages){
            $endNum = $totalClasses;
        }
    }
    if($page == $totalPages){
        $nextPage = $totalPages;
    }else if($page == 1){
        $prevPage = 1;
    }
    $sqlClasses = "SELECT * FROM class WHERE valid = 1 ORDER BY id LIMIT $startItem, $pageItems";
    $stmtClasses = $db_host -> prepare($sqlClasses);
    try{
        $stmtClasses -> execute();
        $classesCount = $stmtClasses -> rowCount();
        $rowClasses = $stmtClasses -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>課程列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require_once("../css.php")?>
    <link rel="stylesheet" href="../css/class.css">
    <!--J Query-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="py-2 d-flex justify-content-between">
            <h1>課程列表</h1>
            <div>
                <form action="frontend_classes.php" method="get">
                    <div class="form-floating d-flex position-relative">
                        <input type="text" id="search" class="form-control" name="search" placeholder="Search">
                        <label for="search">Search</label>
                        <button type="submit" class="search-btn btn btn-primary text-nowrap ms-2 bg-light text-primary position-absolute"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="py-2">
                <h4>課程類別</h4>
                <ul class="list-unstyled filter-list">
                    <?php foreach ($rowCategory as $value):?>
                        <li class="<?php if(isset($category) && $category == $value["id"]) echo "active"?>"><a href="frontend_classes.php?category=<?=$value["id"]?>"><?=$value["name"]?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="py-2">
                <form action="frontend_classes.php" method="get">
                    <label for="">價格範圍 :</label>
                    <div class="d-flex align-items-center py-2">
                        <input type="text" class="form-control" name="minprice" id="minprice"
                               value="<?php if(isset($_GET["minprice"]))echo $min_price;?>">
                        <div class="mx-2">~</div>
                        <input type="text" class="form-control" name="maxprice" id="maxprice"
                               value="<?php if(isset($_GET["maxprice"]))echo $max_price;?>">
                        <button type="submit" class="btn btn-primary ms-2 text-nowrap">搜尋</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="py-2 d-flex justify-content-between align-items-center">
                <?php if($classesCount > 0):?>
                    <div>
                        <?php if(!isset($_GET["category"]) && !isset($_GET["search"]) && !isset($_GET["minprice"]) && !isset($_GET["order"])):?>
                            第 <?=$startNum?> ~ <?=$endNum?> 筆 / 共 <?=$totalClasses?> 筆商品
                        <?php else:?>
                            共 <?=$classesCount?> 筆商品
                        <?php endif;?>
                    </div>
                <?php else:?>
                    <div>
                        無課程資料
                    </div>
                <?php endif;?>
                <div class="d-flex align-items-center">
                    <a href="frontend_classes.php" class="ms-2 me-3 text-nowrap">清除搜尋或篩選結果</a>
                    <select class="form-select" name="order" id="order">
                        <option value="nameDesc" <?php if(isset($_GET["order"]) && $_GET["order"] == "nameDesc")echo "selected"?>>依名稱 ↓ </option>
                        <option value="nameAsc" <?php if(isset($_GET["order"]) && $_GET["order"] == "nameAsc")echo "selected"?>>依名稱 ↑ </option>
                        <option value="priceDesc" <?php if(isset($_GET["order"]) && $_GET["order"] == "priceDesc")echo "selected"?>>價格 高 -> 低</option>
                        <option value="priceAsc" <?php if(isset($_GET["order"]) && $_GET["order"] == "priceAsc")echo "selected"?>>價格 低 -> 高</option>
                        <option value="idDesc" <?php if(isset($_GET["order"]) && $_GET["order"] == "idDesc")echo "selected"?>>編號 大 -> 小</option>
                        <option value="idAsc" <?php if(isset($_GET["order"]) && $_GET["order"] == "idAsc")echo "selected"?>>編號 小 -> 大</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <?php if($classesCount > 0):
                    foreach ($rowClasses as $value):?>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card">
                                <a href="../product/frontend_single-class.php?id=<?=$value[">
                                    <figure class="m-0 ratio ratio-4x3">
                                        <div>
                                            <img class="cover-fit" src="../sql/class_sql/images/<?=$value["image"]?>" alt="">
                                        </div>
                                    </figure>
                                </a>
                                <div class="py-2 px-3 filter-badge-list">
                                    <a href="frontend_classes.php?category=<?=$value["category_id"]?>" class="badge bg-info"><?=$rowCategory[$value["category_id"] -1]["name"]?></a>
                                </div>
                                <div class="py-2 px-3">
                                    <h6 class=""><?=$value["name"]?></h6>
                                    <p class="">售價: <?=$value["price"]?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:?>
                    <div>

                    </div>
                <?php endif;?>
            </div>
            <?php if(isset($_GET["page"]) || $page == 1):?>
            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="frontend_classes.php?page=<?=$prevPage?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for($i = 1; $i <= $totalPages; $i++):?>
                        <li class="page-item <?php if($page == $i)echo "active";?>"><a class="page-link" href="frontend_classes.php?page=<?=$i?>"><?=$i?></a></li>
                    <?php endfor;?>
                    <li class="page-item">
                        <a class="page-link" href="frontend_classes.php?page=<?=$nextPage?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif;?>
        </div>
    </div>
</div>
</body>
<script>

    $('#order').change(function(){
        var destination = $(this).val();
        location.href = `frontend_classes.php?order=${destination}`;
    })
</script>
</html>
