<?php

require_once("./pdo-connect.php");

//商城用戶
$sql = "SELECT * FROM users WHERE valid = 1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute();
    $rows = $stmt->rowCount();
    $rowOrderList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

//交易金額紀錄
$sqlUserOrderTotal = "SELECT * FROM user_order WHERE total";
$stmtUserOrderTotal = $db_host->prepare($sqlUserOrderTotal);
try {
    $stmtUserOrderTotal->execute();
    $rowsUserOrderTotal = $stmtUserOrderTotal->fetchAll(PDO::FETCH_ASSOC);
    $rowsCountUserOrderTotal = $stmtUserOrderTotal->rowCount();
    $userOrderTotal = 0;
    foreach ($rowsUserOrderTotal as $value) {
        $userOrderTotal += $value["total"];
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}


//訂單總數
$sqlUserOrder = "SELECT * FROM user_order";
$stmtUserOrder = $db_host->prepare($sqlUserOrder);
try {
    $stmtUserOrder->execute();
    $rowsUserOrder = $stmtUserOrder->fetchAll(PDO::FETCH_ASSOC);
    $rowsCountUserOrder = $stmtUserOrder->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

//成立訂單數
$sqlOrderTotal = "SELECT * FROM user_order WHERE status_id = 1";
$stmtOrderTotal = $db_host->prepare($sqlOrderTotal);
$stmtOrderTotal->execute();
$orderTotal = $stmtOrderTotal->rowCount();

//待出貨訂單
$sqlUnSentOrderTotal = "SELECT * FROM user_order WHERE status_id = 2";
$stmtUnSentOrderTotal = $db_host->prepare($sqlUnSentOrderTotal);
$stmtUnSentOrderTotal->execute();
$UnSentOrderTotal = $stmtUnSentOrderTotal->rowCount();

//已出貨訂單
$sqlSentOrderTotal = "SELECT * FROM user_order WHERE status_id = 3";
$stmtSentOrderTotal = $db_host->prepare($sqlSentOrderTotal);
$stmtSentOrderTotal->execute();
$SentOrderTotal = $stmtSentOrderTotal->rowCount();

//已取消訂單
$sqlCancelOrderTotal = "SELECT * FROM user_order WHERE status_id = 4";
$stmtCancelOrderTotal = $db_host->prepare($sqlCancelOrderTotal);
$stmtCancelOrderTotal->execute();
$CancelOrderTotal = $stmtCancelOrderTotal->rowCount();

//文章總數
$sqlTotal = "SELECT * FROM blog WHERE valid =1 || valid=2";
$stmtTotal = $db_host->prepare($sqlTotal);
$stmtTotal->execute();
$totalBlog = $stmtTotal->rowCount();

//上架文章數
$sqlOnSelfTotal = "SELECT * FROM blog WHERE valid = 1";
$stmtOnSelfTotal = $db_host->prepare($sqlOnSelfTotal);
$stmtOnSelfTotal->execute();
$totalOnSelfBlog = $stmtOnSelfTotal->rowCount();

//下架文章數
$sqlOffSelfTotal = "SELECT * FROM blog WHERE valid = 2";
$stmtOffSelfTotal = $db_host->prepare($sqlOffSelfTotal);
$stmtOffSelfTotal->execute();
$totalOffSelfBlog = $stmtOffSelfTotal->rowCount();

//商品總數
$sqlProductsTotal = "SELECT * FROM products WHERE valid =1 || valid=2";
$stmtProductsTotal = $db_host->prepare($sqlProductsTotal);
$stmtProductsTotal->execute();
$totalProducts = $stmtProductsTotal->rowCount();

//上架商品數
$sqlOnSelfTotal = "SELECT * FROM products WHERE valid = 1";
$stmtOnSelfTotal = $db_host->prepare($sqlOnSelfTotal);
$stmtOnSelfTotal->execute();
$totalOnSelfProducts = $stmtOnSelfTotal->rowCount();

//下架商品數
$sqlOffSelfTotal = "SELECT * FROM products WHERE valid = 2";
$stmtOffSelfTotal = $db_host->prepare($sqlOffSelfTotal);
$stmtOffSelfTotal->execute();
$totalOffSelfProducts = $stmtOffSelfTotal->rowCount();

//課程總數
$sqlClassTotal = "SELECT * FROM class WHERE valid =1 || valid=2";
$stmtClassTotal = $db_host->prepare($sqlClassTotal);
$stmtClassTotal->execute();
$totalClass = $stmtClassTotal->rowCount();

//上架課程數
$sqlOnSelfTotal = "SELECT * FROM class WHERE valid = 1";
$stmtOnSelfTotal = $db_host->prepare($sqlOnSelfTotal);
$stmtOnSelfTotal->execute();
$totalOnSelfClass = $stmtOnSelfTotal->rowCount();

//下架商品數
$sqlOffSelfTotal = "SELECT * FROM class WHERE valid = 2";
$stmtOffSelfTotal = $db_host->prepare($sqlOffSelfTotal);
$stmtOffSelfTotal->execute();
$totalOffSelfClass = $stmtOffSelfTotal->rowCount();

//今日新增會員數
$sql = "SELECT * FROM users WHERE created_time = CURDATE()";
$stmtnewUser = $db_host->prepare($sql);

try {
    $stmtnewUser->execute();
    $newUser = $stmtnewUser->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

//今日消費會員數
$sql = "SELECT * FROM user_order WHERE time >= CURDATE()";
$stmtnewConsumer = $db_host->prepare($sql);

try {
    $stmtnewConsumer->execute();
    $newConsumer = $stmtnewConsumer->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}





?>

<!doctype html>
<html lang="en">

<head>
    <title>GOALS後台管理系統</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/goals/backend/css/dashboard.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- <?php require_once("css.php"); ?> -->
</head>

<body>
    <header class="bg-light shadow fixed-top p-1">
        <div class="d-flex justify-content-between">
            <a class="
            dashboard-logo
            px-3
            text-dark text-decoration-none
            d-flex
            align-items-center
            fw-bolder
            fs-4
            mx-1
          " href="./dashboard.php">
                ＧＯＡＬＳ
            </a>
            <div class="m-2">
                <div>
                    <?php echo date("Y/m/d  h:i:sa") ?>
                </div>
                <div>
                    <?php if (isset($_SESSION["name"])) : echo "您好," . $_SESSION["name"]; ?>
                        <a href="./login/logOut.php" class="btn btn-danger ms-3 btn-sm">登出</a>
                    <?php else : echo "您尚未登入" ?>
                        <a href="./login/logIn.php" class="btn btn-primary btn-sm">登入</a>
                        <a href="./login/Register.php" class="btn btn-success btn-sm">註冊</a>
                    <?php endif; ?>
                    <!--                <button class="btn btn-primary m-2">sign out</button>-->
                </div>
            </div>
        </div>
    </header>
    <aside class="dashboard-aside bg-light position-fixed">
        <nav>
            <ul class="list-unstyled dashboard-menu mt-5">
                <li>
                    <a href=""><i class="fas fa-home fa-fw mx-1"></i>系統首頁</a>
                </li>
                <li>
                    <a class="btn btn-toggle collapsed text-start" data-bs-toggle="collapse" data-bs-target="#product-collapse" aria-expanded="false">
                        <i class="fas fa-box mx-1"></i>商品管理 <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="collapse" id="product-collapse">
                        <ul class="btn-toggle-nav list-unstyled small">
                            <li><a href="./product/products.php" class="link-dark rounded">商品列表</a></li>
                            <li><a href="./product/add-product.php" class="link-dark rounded">新增商品</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="btn btn-toggle collapsed text-start" data-bs-toggle="collapse" data-bs-target="#class-collapse" aria-expanded="false">
                        <i class="fas fa-box mx-1"></i>課程管理 <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="collapse" id="class-collapse">
                        <ul class="btn-toggle-nav list-unstyled small">
                            <li><a href="./class/classes.php" class="link-dark rounded">課程列表</a></li>
                            <li><a href="./class/add-class.php" class="link-dark rounded">新增課程</a></li>
                        </ul>
                    </div>
                </li>
                <!-- <li>
                    <a href="/goals/backend/product/products.php"><i class="fas fa-box mx-1"></i>商品管理</a>
                </li> -->
                <li>
                    <a href="./order/order.php"><i class="fas fa-folder mx-1"></i>訂單管理</a>
                </li>
                <li>
                    <a href="./user/user-list.php"><i class="fas fa-address-book fa-fw mx-1"></i>用戶管理</a>
                </li>
                <li>
                    <a class="btn btn-toggle collapsed text-start" data-bs-toggle="collapse" data-bs-target="#blog-collapse" aria-expanded="false">
                        <i class="fas fa-box mx-1"></i>文章管理 <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="collapse" id="blog-collapse">
                        <ul class="btn-toggle-nav list-unstyled small">
                            <li><a href="./blog/blog.php" class="link-dark rounded">文章列表</a></li>
                            <li><a href="./blog/add-post.php" class="link-dark rounded">新增文章</a></li>
                        </ul>
                    </div>
                </li>
                <!-- <li>
                    <a href="/goals/backend/blog/blog.php"><i class="fab fa-microblog mx-1"></i>文章管理</a>
                </li> -->
            </ul>
        </nav>
    </aside>
    <main class="main-content pt-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center my-4">
                <div class="container px-4">
                    <div class="row gx-5">
                        <div class="col">
                            <div class="card mb-3 px-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <img src="https://freesvg.org/img/abstract-user-flat-4.png" class="img-fluid rounded-start" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body ">
                                            <h5 class="card-text text-center"><?= $rows ?> 位</h5>
                                            <p class="card-text text-center">商城用戶</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-3 px-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <img src="https://freesvg.org/img/Folder-1.png" class="img-fluid rounded-start" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-text text-center"><?= $rowsCountUserOrder ?> 筆</h5>
                                            <p class="card-text text-center">商城訂單</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-3 px-3">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <img src="https://freesvg.org/img/1479847010.png" class="img-fluid rounded-start" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-text text-center">＄ <?= $userOrderTotal ?></h5>
                                            <p class="card-text text-center">交易紀錄</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="container px-4">
                    <div class="row gx-5">
                        <div class="col">
                            <div class="card p-3">
                                <div class="card-body bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">用戶信息統計</h5>
                                    <a href="./user/user-list.php" class="">查看</a>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">會員總數：<?= $rows; ?> 位</li>
                                    <li class="list-group-item">今日新增會員數：<a href="./user/user-list.php?newUser"><?= $newUser ?></a> 位</li>
                                    <li class="list-group-item">今日消費會員數：<?= $newConsumer ?> 位</li>
                                </ul>
                            </div>
                            <div class="card p-3 mt-3">
                                <div class="card-body bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">文章信息統計</h5>
                                    <a href="./blog/blog.php" class="">查看</a>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">文章總數：<?= $totalBlog ?> 筆</li>
                                    <li class="list-group-item">上架文章數：<?= $totalOnSelfBlog ?> 筆</li>
                                    <li class="list-group-item">下架文章數：<?= $totalOffSelfBlog ?> 筆</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card p-3">
                                <div class="card-body bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">訂單信息統計</h5>
                                    <a href="./order/order.php" class="">查看</a>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">訂單總數：<?= $rowsCountUserOrder ?>筆</li>
                                    <li class="list-group-item">訂單成立數：<a href="./order/order.php?status=1"><?= $orderTotal ?></a> 筆</li>
                                    <li class="list-group-item">待出貨訂單數：<a href="./order/order.php?status=2"><?= $UnSentOrderTotal ?></a> 筆</li>
                                    <li class="list-group-item">已出貨訂單數：<a href="./order/order.php?status=3"><?= $SentOrderTotal ?></a> 筆</li>
                                    </li>
                                    <li class="list-group-item">已取消訂單數：<a href="./order/order.php?status=4"><?= $CancelOrderTotal ?></a> 筆</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card p-3">
                                <div class="card-body bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">商品信息統計</h5>
                                    <a href="./product/products.php" class="">查看</a>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">商品總數：<?= $totalProducts ?> 筆</li>
                                    <li class="list-group-item">上架商品數：<?= $totalOnSelfProducts ?> 筆</li>
                                    <li class="list-group-item">下架商品數：<?= $totalOffSelfProducts ?> 筆</li>
                                </ul>
                            </div>
                            <div class="card p-3 mt-3">
                                <div class="card-body bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">課程信息統計</h5>
                                    <a href="./class/classes.php" class="">查看</a>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">課程總數：<?= $totalClass ?> 筆</li>
                                    <li class="list-group-item">上架課程數：<?= $totalOnSelfClass ?> 筆</li>
                                    <li class="list-group-item">下架課程數：<?= $totalOffSelfClass ?> 筆</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </main>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ccb3aa8802.js" crossorigin="anonymous"></script>
</body>

</html>