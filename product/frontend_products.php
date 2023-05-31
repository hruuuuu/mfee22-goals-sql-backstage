<?php
require_once("../pdo-connect.php");
if(isset($_GET["product"]) && $_GET["product"] == "food"){
$sqlcategory = "SELECT * FROM products_category";
$stmtCategory = $db_host -> prepare($sqlcategory);
try{
    $stmtCategory -> execute();
    $rowCategory = $stmtCategory -> fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "產品分類獲取失敗: ". $e -> getMessage();
}

$sqlTotal = "SELECT * FROM products WHERE valid = 1";
$stmtTotal = $db_host -> prepare($sqlTotal);
$stmtTotal -> execute();
$totalProducts = $stmtTotal -> rowCount();

if(isset($_GET["order"])){
    $orderMethod = $_GET["order"];
    switch ($orderMethod){
        case "nameDesc":
            $sqlProducts = "SELECT * FROM products ORDER BY name DESC";
            break;
        case "nameAsc":
            $sqlProducts = "SELECT * FROM products ORDER BY name ASC";
            break;
        case "priceDesc":
            $sqlProducts = "SELECT * FROM products ORDER BY price DESC";
            break;
        case "priceAsc":
            $sqlProducts = "SELECT * FROM products ORDER BY price ASC";
            break;
        case "idDesc":
            $sqlProducts = "SELECT * FROM products ORDER BY id DESC";
            break;
        case "idAsc":
            $sqlProducts = "SELECT * FROM products ORDER BY id ASC";
            break;
        default:
            break;
    }
    $stmtProducts = $db_host -> prepare($sqlProducts);
    try{
        $stmtProducts -> execute();
        $productsCount = $stmtProducts -> rowCount();
        $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}else if(isset($_GET["search"])){
    $search = $_GET["search"];
    $sqlProducts = "SELECT * FROM products WHERE name LIKE '%$search%' AND valid = 1";
    $stmtProducts = $db_host -> prepare($sqlProducts);
    try{
        $stmtProducts -> execute();
        $productsCount = $stmtProducts -> rowCount();
        $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}else if(isset($_GET["category"])){
    $category = $_GET["category"];
    $sqlProducts = "SELECT * FROM products WHERE products_category = ? AND valid = 1";
    $stmtProducts = $db_host -> prepare($sqlProducts);
    try{
        $stmtProducts -> execute([$category]);
        $productsCount = $stmtProducts -> rowCount();
        $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
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
        $max_price = 180;
    }else{
        $max_price = $_GET["maxprice"];
    }
    $sqlProducts = "SELECT * FROM products WHERE products.price BETWEEN ? AND ?";
    $stmtProducts = $db_host -> prepare($sqlProducts);
    try{
        $stmtProducts -> execute([$min_price, $max_price]);
        $productsCount = $stmtProducts -> rowCount();
        $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
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
    $totalPages = $totalProducts / $pageItems;
    $remainItems = $totalProducts / $pageItems;
    $startItem = ($page - 1) * $pageItems;
    $startNum = ($page - 1) * $pageItems + 1;
    $endNum = $page * $pageItems;
    if($remainItems !== 0){
        $totalPages = ceil($totalProducts / $pageItems);
        if($page == $totalPages){
            $endNum = $totalProducts;
        }
    }
    if($page == $totalPages){
        $nextPage = $totalPages;
    }else if($page == 1){
        $prevPage = 1;
    }
    $sqlProducts = "SELECT * FROM products WHERE valid = 1 ORDER BY id LIMIT $startItem, $pageItems";
    $stmtProducts = $db_host -> prepare($sqlProducts);
    try{
        $stmtProducts -> execute();
        $productsCount = $stmtProducts -> rowCount();
        $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $e){
        echo "無法取得資料庫內容: ".$e -> getMessage();
    }
}





}else if(isset($_GET["product"]) && $_GET["product"] == "class"){
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
    $totalProducts = $stmtTotal -> rowCount();

    if(isset($_GET["order"])){
        $orderMethod = $_GET["order"];
        switch ($orderMethod){
            case "nameDesc":
                $sqlProducts = "SELECT * FROM class ORDER BY name DESC";
                break;
            case "nameAsc":
                $sqlProducts = "SELECT * FROM class ORDER BY name ASC";
                break;
            case "priceDesc":
                $sqlProducts = "SELECT * FROM class ORDER BY price DESC";
                break;
            case "priceAsc":
                $sqlProducts = "SELECT * FROM class ORDER BY price ASC";
                break;
            case "idDesc":
                $sqlProducts = "SELECT * FROM class ORDER BY id DESC";
                break;
            case "idAsc":
                $sqlProducts = "SELECT * FROM class ORDER BY id ASC";
                break;
            default:
                break;
        }
        $stmtProducts = $db_host -> prepare($sqlProducts);
        try{
            $stmtProducts -> execute();
            $productsCount = $stmtProducts -> rowCount();
            $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "無法取得資料庫內容: ".$e -> getMessage();
        }
    }else if(isset($_GET["search"])){
        $search = $_GET["search"];
        $sqlProducts = "SELECT * FROM class WHERE name LIKE '%$search%' AND valid = 1";
        $stmtProducts = $db_host -> prepare($sqlProducts);
        try{
            $stmtProducts -> execute();
            $productsCount = $stmtProducts -> rowCount();
            $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "無法取得資料庫內容: ".$e -> getMessage();
        }
    }else if(isset($_GET["category"])){
        $category = $_GET["category"];
        $sqlProducts = "SELECT * FROM class WHERE category_id = ? AND valid = 1";
        $stmtProducts = $db_host -> prepare($sqlProducts);
        try{
            $stmtProducts -> execute([$category]);
            $classesCount = $stmtProducts -> rowCount();
            $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
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
        $sqlProducts = "SELECT * FROM class WHERE class.price BETWEEN ? AND ?";
        $stmtProducts = $db_host -> prepare($sqlProducts);
        try{
            $stmtProducts -> execute([$min_price, $max_price]);
            $productsCount = $stmtProducts -> rowCount();
            $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
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
        $totalPages = $totalProducts / $pageItems;
        $remainItems = $totalProducts / $pageItems;
        $startItem = ($page - 1) * $pageItems;
        $startNum = ($page - 1) * $pageItems + 1;
        $endNum = $page * $pageItems;
        if($remainItems !== 0){
            $totalPages = ceil($totalProducts / $pageItems);
            if($page == $totalPages){
                $endNum = $totalProducts;
            }
        }
        if($page == $totalPages){
            $nextPage = $totalPages;
        }else if($page == 1){
            $prevPage = 1;
        }
        $sqlProducts = "SELECT * FROM class WHERE valid = 1 ORDER BY id LIMIT $startItem, $pageItems";
        $stmtProducts = $db_host -> prepare($sqlProducts);
        try{
            $stmtProducts -> execute();
            $productsCount = $stmtProducts -> rowCount();
            $rowProducts = $stmtProducts -> fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo "無法取得資料庫內容: ".$e -> getMessage();
        }
    }
}else{
    header("location: frontend_products.php?product=food");
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>商品列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php require_once("../css.php")?>
    <link rel="stylesheet" href="../css/product.css">
    <!--J Query-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="py-2 d-flex justify-content-between">
            <h1>商品列表</h1>
            <div class="py-2"></div>
            <div class="d-flex align-items-center w-50">
                <label for="" class="pb-2 pe-2 text-nowrap">價格範圍 :</label>
                <div class="d-flex align-items-center pb-2">
                    <input type="text" class="form-control" name="minprice" id="minprice"
                           value="<?php if(isset($_GET["minprice"]))echo $min_price;?>">
                    <div class="mx-2">~</div>
                    <input type="text" class="form-control" name="maxprice" id="maxprice"
                           value="<?php if(isset($_GET["maxprice"]))echo $max_price;?>">
                    <button type="submit" class="price-btn btn btn-primary text-nowrap ms-2">搜尋</button>
                </div>
            </div>
            <div>
                <div class="form-floating d-flex position-relative">
                    <input type="text" id="search" class="form-control" name="product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&search" placeholder="Search">
                    <label for="search">Search</label>
                    <button type="button" class="search-btn btn btn-primary text-nowrap ms-2 bg-light text-primary position-absolute"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav nav-tabs mt-4 switch-product border-bottom-0" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo ($_GET["product"] == "food") ? "active" :"";?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">餐盒</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo ($_GET["product"] == "class") ? "active" :"";?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">課程</button>
                    </li>
                </ul>
                    <div class="pt-2 pb-1 d-flex align-items-center">
                        <div class="text-nowrap d-flex flex-column">
                            <?php if(!isset($_GET["category"]) && !isset($_GET["search"]) && !isset($_GET["minprice"]) && !isset($_GET["order"])):?>
                                <div class="ms-2 me-3 text-end">
                                    共 <?=$totalProducts?> 筆
                                </div>
                            <?php else:?>
                                <div class="ms-2 me-3 text-end">
                                    共 <?=$productsCount?> 筆
                                </div>
                            <?php endif;?>
                            <a href="frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>" class="ms-2 me-3 text-nowrap">清除搜尋或篩選結果</a>
                        </div>

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
            <div class="row gx-0 mb-3">
                <?php if($productsCount > 0):
                    foreach ($rowProducts as $value):?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card rounded-0">
                                <a href="frontend_single-<?php echo ($_GET["product"] == "food") ? "product" :"class";?>.php?id=<?=$value["id"]?>">
                                    <figure class="m-0 ratio ratio-4x3">
                                        <div>
                                            <img class="cover-fit" src="../sql/<?php echo ($_GET["product"] == "food") ? "product" :"class";?>_sql/images/<?=$value["image"]?>" alt="">
                                        </div>
                                    </figure>
                                </a>
                                <div class="py-2 px-3 filter-badge-list">
                                    <a href="frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&category=<?php echo ($_GET["product"] == "food") ? $value["products_category"] :$value["category_id"];?>" class="badge bg-info"><?php echo ($_GET["product"] == "food") ? $rowCategory[$value["products_category"] - 1]["name"] :$rowCategory[$value["category_id"] - 1]["name"];?></a>
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
                        <div>
                            無商品資料
                        </div>
                    </div>
                <?php endif;?>
            </div>
            <?php if(isset($_GET["page"]) || $page == 1):?>
            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item <?php if($page == 1) echo "disabled";?>">
                        <a class="page-link" href="frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&page=<?=$prevPage?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for($i = 1; $i <= $totalPages; $i++):?>
                        <li class="page-item <?php if($page == $i)echo "active";?>"><a class="page-link" href="frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&page=<?=$i?>"><?=$i?></a></li>
                    <?php endfor;?>
                    <li class="page-item <?php if($page == $totalPages) echo "disabled";?>">
                        <a class="page-link" href="frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&page=<?=$nextPage?>" aria-label="Next">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $('#order').change(function(){
        var destination = $(this).val();
        location.href = `frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&order=${destination}`;
    })

    $('#search').keydown(function(e){
        if(e.keyCode === 13){
            var value = $('#search').val();
            location.href = `frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&search=${value}`;
        }
    })

    $('.search-btn').click(function(){
        var value = $('#search').val();
        location.href = `frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&search=${value}`;
    })

    $('#minprice').keydown(function(e){
        if(e.keyCode === 13){
            var min = $('#minprice').val();
            var max = $('#maxprice').val();
            location.href = `frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&minprice=${min}&maxprice=${max}`;
        }
    })

    $('#maxprice').keydown(function(e){
        if(e.keyCode === 13){
            var min = $('#minprice').val();
            var max = $('#maxprice').val();
            location.href = `frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&minprice=${min}&maxprice=${max}`;
        }
    })

    $('.price-btn').click(function(){
        var min = $('#minprice').val();
        var max = $('#maxprice').val();
        location.href = `frontend_products.php?product=<?php echo ($_GET["product"] == "food") ? "food" :"class";?>&minprice=${min}&maxprice=${max}`;
    })

    $('#home-tab').click(function(e){
        e.preventDefault();
        location.href = "frontend_products.php?product=food";
    })

    $('#profile-tab').click(function(e){
        e.preventDefault();
        location.href = "frontend_products.php?product=class";
    })
</script>
</html>
