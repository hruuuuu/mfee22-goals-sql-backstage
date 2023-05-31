<?php
require_once("../pdo-connect.php");
date_default_timezone_set('Asia/Taipei');
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

//order_payment
$sqlOrderPayment = "SELECT * FROM order_payment";
$stmtOrderPayment = $db_host->prepare($sqlOrderPayment);
try {
    $stmtOrderPayment->execute();
    $rowsOrderPayment = $stmtOrderPayment->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

//order_delivery
$sqlOrderDelivery = "SELECT * FROM order_delivery";
$stmtOrderDelivery = $db_host->prepare($sqlOrderDelivery);
try {
    $stmtOrderDelivery->execute();
    $rowsOrderDelivery = $stmtOrderDelivery->fetchAll(PDO::FETCH_ASSOC);
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

if (isset($_GET["user"])) {
    $user = $_GET["user"];
    if ($user === 'all') {
        $sql = "SELECT * FROM user_order";
        $stmt = $db_host->prepare($sql);
        try {
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowsCount = $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        $sql = "SELECT * FROM user_order WHERE user_id = ?";
        $stmt = $db_host->prepare($sql);
        try {
            $stmt->execute([$user]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowsCount = $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
} elseif (isset($_GET["payment"])) {
    $payment = $_GET["payment"];
    $sql = "SELECT * FROM user_order WHERE payment_id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$payment]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
        $rowsTotal = 0;
        foreach ($rows as $value) {
            $rowsTotal += $value["total"];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["delivery"])) {
    $delivery = $_GET["delivery"];
    $sql = "SELECT * FROM user_order WHERE delivery_id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$delivery]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
        $rowsTotal = 0;
        foreach ($rows as $value) {
            $rowsTotal += $value["total"];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["status"])) {
    $status = $_GET["status"];
    $sql = "SELECT * FROM user_order WHERE status_id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$status]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
        $rowsTotal = 0;
        foreach ($rows as $value) {
            $rowsTotal += $value["total"];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["search"])) {
    if (isset($_GET["column"])) {
        $column = $_GET["column"];
        $search = $_GET["search"];
        switch ($column) {
            case 0:
                $sql = "SELECT * FROM user_order WHERE id LIKE ?";
                break;
            case 1:
                $sql = "SELECT * FROM user_order WHERE user_id LIKE ?";
                break;
            case 2:
                $sql = "SELECT * FROM user_order WHERE receiver_name LIKE ?";
                break;
            case 3:
                $sql = "SELECT * FROM user_order WHERE receiver_tel LIKE ?";
                break;
            case 4:
                $sql = "SELECT * FROM user_order WHERE receiver_address LIKE ?";
                break;
        }
        $stmt = $db_host->prepare($sql);
        try {
            $stmt->execute(["%$search%"]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowsCount = $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        $_SESSION["error_msg"] = "請選擇查找欄位。";
    }
} elseif (isset($_GET["startDate"])) {
    if ($_GET["endDate"] === '') {
        $startDate = $_GET["startDate"];
        $endDate = date("Y-m-d");
    } elseif ($_GET["startDate"] === '') {
        $startDate = "2020-01-01";
        $endDate = $_GET["endDate"];
    } elseif ($_GET["startDate"] === '' && $_GET["endDate"] === '') {
        $startDate = "2020-01-01";
        $endDate = date("Y-m-d");
    } else {
        $startDate = $_GET["startDate"];
        $endDate = $_GET["endDate"];
    }
    $date = date("Y-m-d");
    if ($endDate > $date or $startDate > $date) {
        $_SESSION["error_msg"] = "篩選日期不可晚於今日，請重新選擇。";
    } elseif ($startDate > $endDate) {
        $_SESSION["error_msg"] = "結束日期需晚於開始日期，請重新選擇。";
    }
    $sql = "SELECT * FROM user_order WHERE DATE(time) BETWEEN ? AND ? ORDER BY time DESC";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$startDate, $endDate]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
        $rowsTotal = 0;
        foreach ($rows as $value) {
            $rowsTotal += $value["total"];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["orderDate"])) {
    $orderDate = $_GET["orderDate"];
    switch ($orderDate) {
        case "dateDesc":
            $sql = "SELECT * FROM user_order ORDER BY time DESC";
            break;
        case "dateAsc":
            $sql = "SELECT * FROM user_order ORDER BY time ASC";
            break;
    }
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["orderId"])) {
    $orderId = $_GET["orderId"];
    switch ($orderId) {
        case "idDesc":
            $sql = "SELECT * FROM user_order ORDER BY id DESC";
            break;
        case "idAsc":
            $sql = "SELECT * FROM user_order ORDER BY id ASC";
            break;
    }
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $itemsPerPage = 10;
    $startItem = ($page * $itemsPerPage) - $itemsPerPage;
    $totalItems = $rowsCountUserOrder;
    if ($totalItems % $itemsPerPage === 0) {
        $totalPages = $totalItems / $itemsPerPage;
    } else {
        $totalPages = ceil($totalItems / $itemsPerPage);
    }
    $sql = "SELECT * FROM user_order ORDER BY id ASC LIMIT $startItem, $itemsPerPage";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
$orderColumnSearch = ['訂單編號', '會員編號', '收件人姓名', '收件人電話', '收件人地址'];
$batch_id = [];
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
    <?php if (isset($_SESSION["msg"])) : ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION["msg"] ?>
        </div>
    <?php elseif (isset(($_SESSION)["error_msg"])) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $_SESSION["error_msg"] ?>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column">
            <a href="order.php" class="text-decoration-none">
                <h1>訂單列表</h1>
            </a>
            <div class="py-3 d-flex align-items-center">
                <a href="../dashboard.php" class="btn btn-primary btn-sm me-2">回主頁</a>
                <div class="d-flex">
                    <form action="order.php" method="get">
                        <div class="input-group input-group-sm">
                            <select class="form-select" name="column">
                                <option <?= (!isset($column)) ? "selected disabled" : "disabled" ?>>---選擇欄位---
                                </option>
                                <?php foreach ($orderColumnSearch as $key => $value) : ?>
                                    <option value="<?= $key ?>" <?php if (isset($column) && $column == $key) echo "selected" ?>><?= $value ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text" class="form-control" name="search" placeholder="快速查找"
                                   aria-label="searchContext" aria-describedby="searchContext"
                                   value="<?php if (isset($search)) echo $search ?>">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </form>
                    <form action="order.php" method="get">
                        <div class="input-group input-group-sm mx-3 d-flex align-items-center">
                            <input type="date" class="form-control" id="startDate" name="startDate"
                                   value="<?php if (isset($startDate)) echo $startDate ?>">
                            <span>～</span>
                            <input type="date" class="form-control" id="endDate" name="endDate"
                                   value="<?php if (isset($endDate)) echo $endDate ?>">
                            <button class="btn btn-outline-primary text-nowrap" type="submit">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="py-3 d-flex flex-column align-items-end">
            <div class="d-flex flex-column align-items-end">
                    <span>共<?php if (isset($page)) :
                            echo $totalItems;
                        elseif (!isset($rowsCount)) :
                            echo "0";
                        else :
                            echo $rowsCount;
                        endif; ?>筆</span>
                <a href="order.php" class="text-decoration-none">清除搜索及篩選結果</a>
            </div>
            <form action="doEditStatus.php" class="input-group input-group-sm mt-2" method="post" id="orderBatchForm">
                <select class="form-select" name="batch_status">
                    <option disabled selected>---批量操作---</option>
                    <?php foreach ($rowsOrderStatus as $valueOrderStatus) : ?>
                        <option value="<?= $valueOrderStatus["id"] ?>"><?= $valueOrderStatus["name"] ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-outline-primary" type="submit" id="orderBatchSubmit">
                    <i class="fas fa-check fa-fw"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="order-table">
        <div class="order-tr bg-light">
            <div class="order-th flex-column align-items-start">
                <span>批量<br/>操作</span>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkAll">
                </div>
            </div>
            <div class="order-th">檢視</div>
            <div class="order-th">
                <span>訂單<br/>編號</span>
                <?php if (!isset($orderId) or $orderId === "idAsc" or isset($orderDate)) : ?>
                    <a href="order.php?orderId=idDesc" class="btn btn-outline-primary btn-sm" role="button">
                        <i class="fas fa-sort-amount-up-alt fa-fw"></i>
                    </a>
                <?php elseif ($orderId === "idDesc") : ?>
                    <a href="order.php?orderId=idAsc" class="btn btn-outline-primary btn-sm" role="button">
                        <i class="fas fa-sort-amount-down fa-fw"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="order-th d-flex flex-column justify-content-center align-items-start">
                <span>會員編號</span>
                <form action="order.php?user=<?= $user ?>" method="get">
                    <select class="form-select form-select-sm w-75" aria-label="select status" name="user"
                            onchange='this.form.submit()'>
                        <option disabled>---選擇會員---</option>
                        <option value="all">全部</option>
                        <?php foreach ($rowsUsers as $valueUsers) : ?>
                            <option value="<?= $valueUsers["id"] ?>" <?php if (isset($user) && $valueUsers["id"] == $user) echo "selected disabled" ?>>
                                <?= $valueUsers["id"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div class="order-th">總金額</div>
            <div class="order-th"><span>付款<br/>方式</span>
                <div class="dropdown">
                    <a class="btn btn-outline-primary dropdown-toggle btn-sm" href="#" role="button"
                       id="blogAuthorDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogAuthorDropdown">
                        <li>
                            <a class="dropdown-item <?php if (!isset($payment))
                                echo "active"; ?>" aria-current="page" href="order.php">全部</a>
                        </li>
                        <?php foreach ($rowsOrderPayment as $valueOrderPayment) : ?>
                            <li>
                                <a class="dropdown-item <?php if (isset($payment) && $valueOrderPayment["id"] == $payment) echo "active" ?>"
                                   href="order.php?payment=<?= $valueOrderPayment["id"] ?>"><?= $valueOrderPayment["name"] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="order-th"><span>送貨<br/>方式</span>
                <div class="dropdown">
                    <a class="btn btn-outline-primary dropdown-toggle btn-sm" href="#" role="button"
                       id="blogAuthorDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogAuthorDropdown">
                        <li>
                            <a class="dropdown-item <?php if (!isset($delivery))
                                echo "active"; ?>" aria-current="page" href="order.php">全部</a>
                        </li>
                        <?php foreach ($rowsOrderDelivery as $valueOrderDelivery) : ?>
                            <li>
                                <a class="dropdown-item <?php if (isset($delivery) && $valueOrderDelivery["id"] == $delivery) echo "active" ?>"
                                   href="order.php?delivery=<?= $valueOrderDelivery["id"] ?>"><?= $valueOrderDelivery["name"] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="order-th">收件人<br/>姓名</div>
            <div class="order-th">收件人<br/>電話</div>
            <div class="order-th">收件人<br/>地址</div>
            <div class="order-th"><span>訂單<br/>狀態</span>
                <div class="dropdown">
                    <a class="btn btn-outline-primary dropdown-toggle btn-sm" href="#" role="button"
                       id="blogAuthorDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogAuthorDropdown">
                        <li>
                            <a class="dropdown-item <?php if (!isset($status))
                                echo "active"; ?>" aria-current="page" href="order.php">全部</a>
                        </li>
                        <?php foreach ($rowsOrderStatus as $valueOrderStatus) : ?>
                            <li>
                                <a class="dropdown-item <?php if (isset($status) && $valueOrderStatus["id"] == $status) echo "active" ?>"
                                   href="order.php?status=<?= $valueOrderStatus["id"] ?>"><?= $valueOrderStatus["name"] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="order-th">訂單時間
                <?php if (!isset($orderDate) or ($orderDate === "dateAsc") or (isset($orderId))) : ?>
                    <a href="order.php?orderDate=dateDesc" class="btn btn-outline-primary btn-sm" role="button">
                        <i class="fas fa-sort-amount-up-alt fa-fw"></i>
                    </a>
                <?php elseif ($orderDate === "dateDesc") : ?>
                    <a href="order.php?orderDate=dateAsc" class="btn btn-outline-primary btn-sm" role="button">
                        <i class="fas fa-sort-amount-down fa-fw"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="order-th">更改狀態</div>
        </div>
        <?php if (!$rows or isset($_SESSION["error_msg"])) : ?>
            <div class="order-tr-empty">
                <div class="order-td">目前沒有資料。</div>
            </div>
        <?php else : ?>
        <div class="order-tr">
            <?php foreach ($rows as $value) : ?>
                <div class="order-td">
                    <input class="form-check-input order-check" type="checkbox" value="<?= $value["id"] ?>"
                           name="batch_id[]" form="orderBatchForm">
                </div>
                <div class="order-td">
                    <a href="order_detail.php?id=<?= $value["id"] ?>" role="button"
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye fa-fw"></i>
                    </a>
                </div>
                <div class="order-td"><?= $value["id"] ?></div>
                <div class="order-td"><?= $value["user_id"] ?></div>
                <div class="order-td"><?= number_format($value["total"]) ?></div>
                <div class="order-td"><?= $rowsOrderPayment[$value["payment_id"] - 1]["name"] ?></div>
                <div class="order-td"><?= $rowsOrderDelivery[$value["delivery_id"] - 1]["name"] ?></div>
                <div class="order-td"><?= $value["receiver_name"] ?></div>
                <div class="order-td"><?= $value["receiver_tel"] ?></div>
                <div class="order-td"><?= $value["receiver_address"] ?></div>
                <div class="order-td"><?= $rowsOrderStatus[$value["status_id"] - 1]["name"] ?></div>
                <div class="order-td"><?= $value["time"] ?></div>
                <div class="order-td">
                    <form action="doEditStatus.php" method="post" class="input-group">
                        <input type="hidden" value="<?= $value["id"] ?>" name="id">
                        <select class="form-select form-select-sm" aria-label="select status" name="status">
                            <option disabled>---選擇更改狀態---</option>
                            <?php foreach ($rowsOrderStatus as $valueOrderStatus) : ?>
                                <option value="<?= $valueOrderStatus["id"] ?>" <?php if ($valueOrderStatus["id"] == $value["status_id"]) echo "disabled selected" ?>>
                                    <?= $valueOrderStatus["name"] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn btn-outline-primary btn-sm" type="submit">
                            <i class="fas fa-check fa-fw"></i>
                        </button>
                    </form>
                </div>
            <?php endforeach;
            $total = 0;
            $total += (int)$value["total"]; ?>
            <?php endif; ?>
        </div>
        <?php if (!isset($_SESSION["error_msg"])) : ?>
            <?php if (isset($user) && $user !== 'all') : ?>
                <div class="order-tr-empty bg-light">
                    <div class="order-td">會員編號 <?= $user ?>，累積消費共計 <?= $rowsCount ?> 筆訂單，總金額 <?= $total ?>。</div>
                </div>
            <?php endif; ?>
            <?php if (isset($payment)) : ?>
                <div class="order-tr-empty bg-light">
                    <div class="order-td">使用<?= $rowsOrderPayment[$payment - 1]["name"] ?>方式付款之訂單共 <?= $rowsCount ?>
                        筆，付款總金額<?= number_format($rowsTotal) ?>。
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($delivery)) : ?>
                <div class="order-tr-empty bg-light">
                    <div class="order-td">使用<?= $rowsOrderDelivery[$delivery - 1]["name"] ?>送貨方式之訂單共 <?= $rowsCount ?>
                        筆，總金額<?= number_format($rowsTotal) ?>。
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($status)) : ?>
                <div class="order-tr-empty bg-light">
                    <div class="order-td"><?= $rowsOrderStatus[$status - 1]["name"] ?>之訂單共 <?= $rowsCount ?>
                        筆，總金額<?= number_format($rowsTotal) ?>。
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($startDate)) : ?>
                <div class="order-tr-empty bg-light">
                    <div class="order-td">訂單日期<?= $startDate ?>～<?= $endDate ?>之訂單共 <?= $rowsCount ?>
                        筆，總金額<?= number_format($rowsTotal) ?>。
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (isset($page)) : ?>
            <nav aria-label="Page navigation mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
                        <a class="page-link" href="order.php?page=<?php if ($page < $totalPages) :
                            $prevPage = $page - 1;
                            echo $prevPage;
                        else :
                            echo 1;
                        endif; ?>" aria-label="previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
                        <a class="page-link" href="order.php?page=1" aria-label="first">
                            <span aria-hidden="true">第一頁</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php if ($page == $i) echo "active" ?>" <?php if ($page === $i) echo "aria-current='page'" ?>>
                            <a class="page-link" href="order.php?page=<?= $i ?>"><?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($page == $totalPages) echo "disabled" ?>">
                        <a class="page-link" href="order.php?page=<?= $totalPages ?>" aria-label="last">
                            <span aria-hidden="true">最後頁</span>
                        </a>
                    </li>
                    <li class="page-item <?php if ($page == $totalPages) echo "disabled" ?>">
                        <a class="page-link" href="order.php?page=<?php if ($page < $totalPages) :
                            $nextPage = $page + 1;
                            echo $nextPage;
                        else :
                            echo $totalPages;
                        endif; ?>" aria-label="next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>
<?php
unset($_SESSION["msg"]);
unset($_SESSION["error_msg"]);
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<script>
    const checkAll = document.querySelector("#checkAll");
    const checks = document.querySelectorAll(".order-check");
    checkAll.addEventListener("click", () => {
        if (checkAll.checked) {
            checks.forEach((check) => {
                check.checked = true;
            });
        } else {
            checks.forEach((check) => {
                check.checked = false;
            });
        }
    });
</script>
</body>

</html>