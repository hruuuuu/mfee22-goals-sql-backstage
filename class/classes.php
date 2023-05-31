<?php
require_once("../pdo-connect.php");
$sqlcategory = "SELECT * FROM class_category";
$stmtCategory = $db_host->prepare($sqlcategory);
try {
    $stmtCategory->execute();
    $rowCategory = $stmtCategory->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "產品分類獲取失敗: " . $e->getMessage();
}

$sqlTotal = "SELECT * FROM class WHERE valid = 1";
$stmtTotal = $db_host->prepare($sqlTotal);
$stmtTotal->execute();
$totalClasses = $stmtTotal->rowCount();

if (isset($_GET["order"])) {
    $orderMethod = $_GET["order"];
    switch ($orderMethod) {
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
    $stmtClasses = $db_host->prepare($sqlClasses);
    try {
        $stmtClasses->execute();
        $classesCount = $stmtClasses->rowCount();
        $rowClasses = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "無法取得資料庫內容: " . $e->getMessage();
    }
} else if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sqlClasses = "SELECT * FROM class WHERE name LIKE '%$search%' AND valid = 1";
    $stmtClasses = $db_host->prepare($sqlClasses);
    try {
        $stmtClasses->execute();
        $classesCount = $stmtClasses->rowCount();
        $rowClasses = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "無法取得資料庫內容: " . $e->getMessage();
    }
} else if (isset($_GET["category"])) {
    $category = $_GET["category"];
    $sqlClasses = "SELECT * FROM class WHERE category_id = ? AND valid = 1";
    $stmtClasses = $db_host->prepare($sqlClasses);
    try {
        $stmtClasses->execute([$category]);
        $classesCount = $stmtClasses->rowCount();
        $rowClasses = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "無法取得資料庫內容: " . $e->getMessage();
    }
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
        $prevPage = $page - 1;
        $nextPage = $page + 1;
    } else {
        $page = 1;
        $prevPage = 1;
        $nextPage = $page + 1;
    }
    $pageItems = 6;
    $totalPages = $totalClasses / $pageItems;
    $remainItems = $totalClasses / $pageItems;
    $startItem = ($page - 1) * $pageItems;
    if ($remainItems !== 0) {
        $totalPages = ceil($totalClasses / $pageItems);
    }
    if ($page == $totalPages) {
        $nextPage = $totalPages;
    } else if ($page == 1) {
        $prevPage = 1;
    }
    $sqlClasses = "SELECT * FROM class LIMIT $startItem, $pageItems";
    $stmtClasses = $db_host->prepare($sqlClasses);
    try {
        $stmtClasses->execute();
        $classesCount = $stmtClasses->rowCount();
        $rowClasses = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "無法取得資料庫內容: " . $e->getMessage();
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
    <?php require_once("../css.php") ?>
    <link rel="stylesheet" href="../css/class.css">
    <!--J Query-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="" style="color: #0D6EFD"><a href="./classes.php" style="text-decoration: none">課程列表</a></h1>
                <div class="d-flex justify-content-end">
                    <form action="classes.php" method="get">
                        <div class="form-floating d-flex">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Search">
                            <label for="search">Search</label>
                            <button type="submit" class="search-btn btn btn-primary text-nowrap ms-2 bg-light text-primary position-absolute"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="py-3 col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-end">
                        <a href="../dashboard.php" class="btn btn-primary me-2">回主頁</a>
                        <a href="add-class.php" class="btn btn-primary me-2"><i class="fas fa-plus"></i> 新增課程</a>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php if ($classesCount > 0) : ?>
                            <div class="text-nowrap d-flex flex-column">
                                <?php if (!isset($_GET["search"]) && !isset($_GET["category"])) : ?>
                                    <div class="ms-2 me-3 text-end">
                                        共 <?= $totalClasses ?> 筆
                                    </div>
                                <?php else : ?>
                                    <div class="ms-2 me-3 text-end">
                                        共 <?= $classesCount ?> 筆
                                    </div>
                                <?php endif; ?>
                                <a href="classes.php" class="ms-2 me-3">清除搜尋或篩選結果</a>
                            </div>
                        <?php endif; ?>
                        <select class="form-select" name="order" id="order">
                            <option value="nameDesc" <?php if (isset($_GET["order"]) && $_GET["order"] == "nameDesc") echo "selected" ?>>依名稱 ↓ </option>
                            <option value="nameAsc" <?php if (isset($_GET["order"]) && $_GET["order"] == "nameAsc") echo "selected" ?>>依名稱 ↑ </option>
                            <option value="priceDesc" <?php if (isset($_GET["order"]) && $_GET["order"] == "priceDesc") echo "selected" ?>>價格 高 -> 低</option>
                            <option value="priceAsc" <?php if (isset($_GET["order"]) && $_GET["order"] == "priceAsc") echo "selected" ?>>價格 低 -> 高</option>
                            <option value="idDesc" <?php if (isset($_GET["order"]) && $_GET["order"] == "idDesc") echo "selected" ?>>編號 大 -> 小</option>
                            <option value="idAsc" <?php if (isset($_GET["order"]) && $_GET["order"] == "idAsc") echo "selected" ?>>編號 小 -> 大</option>
                        </select>
                    </div>
                </div>
                <table class="table table-bordered-less mt-3">
                    <thead class="align-middle">
                        <tr>
                            <th class="d-flex justify-content-center align-items-center">課程編號
                                <?php if (!isset($_GET["order"]) || $orderMethod == "idAsc") : ?>
                                    <a href="classes.php?order=idDesc" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-up-alt"></i></a>
                                <?php else : ?>
                                    <a href="classes.php?order=idAsc" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-down-alt"></i></a>
                                <?php endif; ?>
                            </th>
                            <th class="text-center">課程圖片</th>
                            <th class="text-center">課程名稱</th>
                            <th class="d-flex justify-content-center align-items-center">價格
                                <?php if (!isset($_GET["order"]) || $orderMethod == "priceAsc") : ?>
                                    <a href="classes.php?order=priceDesc" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-up-alt"></i></a>
                                <?php else : ?>
                                    <a href="classes.php?order=priceAsc" role="button" class="btn btn-primary bg-white text-primary thead-btn ms-2"><i class="fas fa-sort-amount-down-alt"></i></a>
                                <?php endif; ?>
                            </th>
                            <th class="text-center">上下架狀態</th>
                            <th class="text-center d-flex justify-content-center align-items-center">
                                課程類別
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle bg-light text-primary ms-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <?php foreach ($rowCategory as $value) : ?>
                                            <li>
                                                <a class="dropdown-item" href="classes.php?category=<?= $value["id"] ?>"><?= $value["name"] ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </th>
                            <th class="text-center">編輯</th>
                            <th class="text-center">刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($classesCount > 0) :
                            foreach ($rowClasses as $value) : ?>
                                <tr>
                                    <td class="text-center"><?= $value["id"] ?></td>
                                    <td>
                                        <div class="image-wrapper text-center">
                                            <?php if (substr($value["image"], 0, 4) !== "http") : ?>
                                                <img class="cover-fit" src="../sql/class_sql/images/<?= $value["image"] ?>" alt="">
                                            <?php else : ?>
                                                <img class="cover-fit" src="<?= $value["image"] ?>" alt="">
                                            <?php endif; ?>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center"><?= $value["name"] ?></td>
                                    <td class="text-center"><?= $value["price"] ?></td>
                                    <?php if ($value["valid"] == 1) : ?>
                                        <td class="text-center">上架</td>
                                    <?php else : ?>
                                        <td class="text-center">已下架</td>
                                    <?php endif; ?>
                                    <td class="text-center"><?= $rowCategory[$value["category_id"] - 1]["name"] ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-primary bg-light text-primary edit-btn" role="button" href="edit-class.php?id=<?= $value["id"] ?>"><i class="far fa-edit"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary bg-light text-primary delete-btn" role="button" href="doDelete.php?id=<?= $value["id"] ?>"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                        else : ?>
                            <tr>
                                <td colspan="8">無課程資料</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (isset($_GET["page"]) || $page == 1) : ?>
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                        <ul class="pagination">
                            <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
                                <a class="page-link" href="classes.php?page=<?= $prevPage ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php if ($page == $i) echo "active"; ?>"><a class="page-link" href="classes.php?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?php if ($page == $totalPages) echo "disabled"; ?>">
                                <a class="page-link" href="classes.php?page=<?= $nextPage ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $('#order').change(function() {
        var destination = $(this).val();
        location.href = `classes.php?order=${destination}`;
    })
</script>

</html>