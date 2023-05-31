<?php
require_once("../pdo-connect.php");
if (!isset($_GET["id"])) {
    header("location: order.php");
}
$id = $_GET["id"];
//---main sql---
//user_order
$sqlUserOrder = "SELECT * FROM user_order";
$stmtUserOrder = $db_host->prepare($sqlUserOrder);
try {
    $stmtUserOrder->execute();
    $rowsUserOrder = $stmtUserOrder->fetchAll(PDO::FETCH_ASSOC);
    $rowsCountUserOrder = $stmtUserOrder->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

//---associated sql---
//users
$sqlUsers = "SELECT * FROM users";
$stmtUsers = $db_host->prepare($sqlUsers);
try {
    $stmtUsers->execute();
    $rowsUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

//user_order_product
$sqlUserOrderProduct = "SELECT * FROM user_order_product WHERE order_id = ?";
$stmtUserOrderProduct = $db_host->prepare($sqlUserOrderProduct);
try {
    $stmtUserOrderProduct->execute([$id]);
    $rowsUserOrderProduct = $stmtUserOrderProduct->fetchAll(PDO::FETCH_ASSOC);
    $rowsCountUserOrderProduct = $stmtUserOrderProduct->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

//user_order_class
$sqlUserOrderClass = "SELECT * FROM user_order_class WHERE order_id = ?";
$stmtUserOrderClass = $db_host->prepare($sqlUserOrderClass);
try {
    $stmtUserOrderClass->execute([$id]);
    $rowsUserOrderClass = $stmtUserOrderClass->fetchAll(PDO::FETCH_ASSOC);
    $rowsCountUserOrderClass = $stmtUserOrderClass->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

//products
$sqlProducts = "SELECT * FROM products WHERE valid = 1";
$stmtProducts = $db_host->prepare($sqlProducts);
try {
    $stmtProducts->execute();
    $rowsProducts = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
    $productArr = [];
    foreach ($rowsProducts as $valueProducts) {
        array_push($productArr, ["name" => $valueProducts["name"], "image" => $valueProducts["image"], "price" => $valueProducts["price"]]);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

//class
$sqlClass = "SELECT * FROM class WHERE valid = 1";
$stmtClass = $db_host->prepare($sqlClass);
try {
    $stmtClass->execute();
    $rowsClass = $stmtClass->fetchAll(PDO::FETCH_ASSOC);
    $classArr = [];
    foreach ($rowsClass as $valueClass) {
        array_push($classArr, ["name" => $valueClass["name"], "image" => $valueClass["image"], "price" => $valueClass["price"]]);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

//order_status
$sqlOrderStatus = "SELECT * FROM order_status";
$stmtOrderStatus = $db_host->prepare($sqlOrderStatus);
try {
    $stmtOrderStatus->execute();
    $rowsOrderStatus = $stmtOrderStatus->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$sql = "SELECT user_order.*,
        order_payment.id AS id,
        order_payment.name AS payment_name,
        order_delivery.id AS id,
        order_delivery.name AS delivery_name,
        order_status.id AS id,
        order_status.name AS status_name,
        users.name AS user_name,
        users.account AS user_account,
        users.email AS user_email
        FROM user_order
            JOIN order_payment ON order_payment.id = user_order.payment_id
            JOIN order_delivery ON order_delivery.id = user_order.delivery_id
            JOIN order_status ON order_status.id = user_order.status_id
            JOIN users ON users.id = user_order.user_id
WHERE user_order.id = ?";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute([$id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $rowsCount = $stmt->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}
$itemsPerPage = 10;
$page = ceil($id / $itemsPerPage);
$total = 0;
?>
<!doctype html>
<html lang="en">
<head>
    <title>訂單</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/order.css?<?= time() ?>">
</head>
<body>
<div class="container py-5">
    <?php if (isset($_SESSION["msg"])): ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION["msg"] ?>
        </div>
    <?php elseif (isset(($_SESSION)["error_msg"])): ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION["error_msg"] ?>
        </div>
    <?php endif;
    unset($_SESSION["msg"]);
    unset($_SESSION["error_msg"]);
    ?>
    <div class="d-flex justify-content-between align-items-end">
        <a href="order.php" class="text-decoration-none">
            <h1>訂單內容</h1>
        </a>
    </div>
    <div class="py-3 d-flex justify-content-between">
        <a href="order.php?page=<?= $page ?>" role="button" class="btn btn-primary">
            <i class="fas fa-chevron-left fa-fw"></i>
            返回列表
        </a>
        <form action="doEditStatus.php" method="post" id="detailForm">
            <div class="input-group input-group-sm mt-2">
                <input type="hidden" value="<?= $id ?>" name="id">
                <select class="form-select" name="status">
                    <option disabled selected>---更改狀態---</option>
                    <?php foreach ($rowsOrderStatus as $valueOrderStatus): ?>
                        <option value="<?= $valueOrderStatus["id"] ?>"
                            <?php if ($rows[0]["status_id"] === $valueOrderStatus["id"]) echo "selected disabled" ?>
                        ><?= $valueOrderStatus["name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-outline-primary" type="submit" id="detailSubmit">
                    <i class="fas fa-check fa-fw"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="row">
        <aside class="col-4">
            <div class="detail-aside bg-light d-flex py-3 px-5">
                <div class="detail-aside-tr">
                    <div class="detail-aside-th">訂單編號</div>
                    <div class="detail-aside-th">訂單時間</div>
                    <div class="detail-aside-th">總金額</div>
                    <div class="detail-aside-th">出貨狀態</div>
                    <div class="detail-aside-th">
                        <hr/>
                    </div>
                    <div class="detail-aside-th">會員編號</div>
                    <div class="detail-aside-th">訂購人帳號</div>
                    <div class="detail-aside-th">訂購人姓名</div>
                    <div class="detail-aside-th">訂購人Email</div>
                    <div class="detail-aside-th">付款方式</div>
                    <div class="detail-aside-th">
                        <hr/>
                    </div>
                    <div class="detail-aside-th">送貨方式</div>
                    <div class="detail-aside-th">收件人姓名</div>
                    <div class="detail-aside-th">收件人電話</div>
                    <div class="detail-aside-th">收件人地址</div>
                </div>
                <div class="detail-aside-tr">
                    <div class="detail-aside-td"><?= $id ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["time"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["total"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["status_name"] ?></div>
                    <div class="detail-aside-td">
                        <hr/>
                    </div>
                    <div class="detail-aside-td"><?= $rows[0]["user_id"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["user_account"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["user_name"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["user_email"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["payment_name"] ?></div>
                    <div class="detail-aside-td">
                        <hr/>
                    </div>
                    <div class="detail-aside-td"><?= $rows[0]["delivery_name"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["receiver_name"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["receiver_tel"] ?></div>
                    <div class="detail-aside-td"><?= $rows[0]["receiver_address"] ?></div>
                </div>
            </div>
        </aside>
        <main class="col-8 d-flex flex-column">
            <div class="detail-table detail-product mb-5">
                <div class="detail-tr detail-tr-product bg-light">
                    <div class="detail-th">商品名稱</div>
                    <div class="detail-th">圖片</div>
                    <div class="detail-th text-end">單價</div>
                    <div class="detail-th text-end">數量</div>
                    <div class="detail-th text-end">總計</div>
                </div>
                <?php if (!$rowsUserOrderProduct): ?>
                    <div class="detail-tr-empty">
                        <div class="detail-td">無購買品項。</div>
                    </div>
                <?php else:
                    $productTotal = 0; ?>
                    <?php foreach ($rowsUserOrderProduct as $valueUserOrderProduct): ?>
                    <div class="detail-tr detail-tr-product">
                        <div class="detail-td"><?= $productArr[$valueUserOrderProduct["product_id"] - 1]["name"] ?></div>
                        <div class="detail-td">
                            <img class="detail-img"
                                 src="../sql/product_sql/images/<?= $productArr[$valueUserOrderProduct["product_id"] - 1]["image"] ?>"
                                 alt="product_img"></div>
                        <div class="detail-td text-end"><?php $productPrice = $productArr[$valueUserOrderProduct["product_id"] - 1]["price"];
                            echo "$productPrice" ?></div>
                        <div class="detail-td text-end"><?php $productAmount = $valueUserOrderProduct["amount"];
                            echo "$productAmount" ?></div>
                        <div class="detail-td text-end"><?php
                            if (!$rowsUserOrderProduct):
                                $singleProductTotal = 0;
                            else:
                                $singleProductTotal = $productPrice * $productAmount;
                                $productTotal += $singleProductTotal;
                                echo number_format($singleProductTotal);
                            endif; ?></div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="detail-table detail-class">
                <div class="detail-tr detail-tr-class bg-light">
                    <div class="detail-th">課程名稱</div>
                    <div class="detail-th">圖片</div>
                    <div class="detail-th text-end">總計</div>
                </div>
                <?php if (!$rowsUserOrderClass): ?>
                    <div class="detail-tr-empty">
                        <div class="detail-td">無購買品項。</div>
                    </div>
                <?php else:
                    $classTotal = 0; ?>
                    <?php foreach ($rowsUserOrderClass as $valueUserOrderClass): ?>
                    <div class="detail-tr detail-tr-class">
                        <div class="detail-td"><?= $classArr[$valueUserOrderClass["class_id"] - 1]["name"] ?></div>
                        <div class="detail-td">
                            <img class="detail-img"
                                 src="../sql/class_sql/images/<?= $classArr[$valueUserOrderClass["class_id"] - 1]["image"] ?>"
                                 alt="class_img"></div>
                        <div class="detail-td text-end"><?php
                            if (!$rowsUserOrderClass):
                                $singleClassTotal = 0;
                            else:
                                $singleClassTotal = $classArr[$valueUserOrderClass["class_id"] - 1]["price"];
                                $classTotal += $singleClassTotal;
                                echo number_format($singleClassTotal);
                            endif; ?></div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="detail-total border-top w-100 p-2 text-end">
                <h5><?= $rowsCountUserOrderProduct ?> 個商品，<?= $rowsCountUserOrderClass ?>
                    個課程</h5>
                <h5>共計 <?php $total = number_format($productTotal + $classTotal);
                    echo "$total" ?> 元</h5>
            </div>
            <form action="doEditTotal.php?id=<?= $id ?>&page=<?= $page ?>" method="post"
                  class="d-flex justify-content-end">
                <input type="hidden" value="<?= $total ?>" name="total">
                <button class="btn btn-outline-primary btn-sm opacity-0">更新</button>
            </form>
        </main>
    </div>
</div>
</body>
</html>