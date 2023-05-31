<?php
require_once("../pdo-connect.php");
//---main sql---
//blog
$sqlBlog = "SELECT * FROM blog";
$stmtBlog = $db_host->prepare($sqlBlog);
try {
    $stmtBlog->execute();
    $rowsBlogCategory = $stmtBlog->fetchAll(PDO::FETCH_ASSOC);
    $rowsCountBlog = $stmtBlog->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

//---associated sql---
//blog_category
$sqlBlogCategory = "SELECT * FROM blog_category";
$stmtBlogCategory = $db_host->prepare($sqlBlogCategory);
try {
    $stmtBlogCategory->execute();
    $rowsBlogCategory = $stmtBlogCategory->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
//blog_author
$sqlBlogAuthor = "SELECT * FROM blog_author";
$stmtBlogAuthor = $db_host->prepare($sqlBlogAuthor);
try {
    $stmtBlogAuthor->execute();
    $rowsBlogAuthor = $stmtBlogAuthor->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

//---filter conditions---
if (isset($_GET["category"])) {
    $category = $_GET["category"];
    $sql = "SELECT * FROM blog WHERE valid = 1 AND category_id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$category]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["author"])) {
    $author = $_GET["author"];
    $sql = "SELECT * FROM blog WHERE valid = 1 AND author_id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$author]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["search"])) {
    if (isset($_GET["column"])) {
        $column = $_GET["column"];
        $search = $_GET["search"];
        switch ($column) {
            case 0:
                $sql = "SELECT * FROM blog WHERE valid = 1 AND id LIKE ?";
                break;
            case 1:
                $sql = "SELECT * FROM blog WHERE valid = 1 AND title LIKE ?";
                break;
            case 2:
                $sql = "SELECT * FROM blog WHERE valid = 1 AND context LIKE ?";
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
    $sql = "SELECT * FROM blog WHERE valid = 1 AND created_at BETWEEN ? AND ? ORDER BY created_at DESC";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$startDate, $endDate]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["orderDate"])) {
    $orderDate = $_GET["orderDate"];
    switch ($orderDate) {
        case "dateDesc":
            $sql = "SELECT * FROM blog WHERE valid = 1 ORDER BY created_at DESC";
            break;
        case "dateAsc":
            $sql = "SELECT * FROM blog WHERE valid = 1 ORDER BY created_at ASC";
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
            $sql = "SELECT * FROM blog WHERE valid = 1 ORDER BY id DESC";
            break;
        case "idAsc":
            $sql = "SELECT * FROM blog WHERE valid = 1 ORDER BY id ASC";
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
} elseif (isset($_GET["batchId"])) {
    $batchId = $_GET["batchId"];
    $batch_param = join(',', array_fill(0, count($batchId), '?'));
    $sql = "SELECT * FROM blog WHERE valid = 1 AND id IN ($batch_param)";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute($batchId);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["batchEdit"])) {
    $batchEdit = $_GET["batchEdit"];
    $batch_param = join(',', array_fill(0, count($batchEdit), '?'));
    $sql = "SELECT * FROM blog WHERE valid = 1 AND id IN ($batch_param)";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute($batchEdit);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $itemsPerPage = 5;
    $startItem = ($page * $itemsPerPage) - $itemsPerPage;
    $totalItems = $rowsCountBlog;
    if ($totalItems % $itemsPerPage === 0) {
        $totalPages = $totalItems / $itemsPerPage;
    } else {
        $totalPages = ceil($totalItems / $itemsPerPage);
    }
    $sql = "SELECT * FROM blog WHERE valid = 1 ORDER BY id ASC LIMIT $startItem, $itemsPerPage";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $rowsCount = $stmt->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
$blogColumnSearch = ['編號', '標題', '內容'];
?>
<!doctype html>
<html lang="en">

<head>
    <title>Blog</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../css/blog.css?<?= time() ?>">
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
    <div>
        <a href="blog.php" class="text-decoration-none">
            <h1>文章列表</h1>
        </a>
    </div>
    <div class="d-flex justify-content-between w-100">
        <div class="py-3 d-flex flex-column align-items-end w-100">
            <div class="d-flex flex-column align-items-end">
                    <span>共<?php if (isset($page)) :
                            echo $totalItems;
                        else :
                            echo $rowsCount;
                        endif; ?>筆</span>
                <a href="blog.php" class="text-decoration-none">清除搜索及篩選結果</a>
            </div>
            <div class="d-flex justify-content-between w-100">
                <div class="d-flex">
                    <a href="../dashboard.php" role="button" class="me-1 btn btn-primary btn-sm">
                        回主頁
                    </a>
                    <a href="add-post.php" role="button" class="me-2 btn btn-primary btn-sm">
                        新增文章
                        <i class="fas fa-plus fa-fw"></i>
                    </a>
                </div>
                <div class="d-flex">
                    <form action="blog.php" method="get">
                        <div class="input-group input-group-sm">
                            <select class="form-select" name="column">
                                <option <?= (!isset($column)) ? "selected disabled" : "disabled" ?>>---選擇欄位---
                                </option>
                                <?php foreach ($blogColumnSearch as $key => $value) : ?>
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
                    <form action="blog.php" method="get" class="mx-3">
                        <div class="input-group input-group-sm d-flex align-items-center">
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
                    <form action="doBatch.php" method="post" id="blogBatchForm">
                        <div class="input-group input-group-sm w-auto">
                            <select class="form-select" name="batch_action">
                                <option disabled selected>---批量操作---</option>
                                <option value="0">編輯</option>
                                <option value="1">儲存</option>
                                <option value="2">刪除</option>
                            </select>
                            <button class="btn btn-outline-primary" type="submit" id="blogBatchSubmit">
                                <i class="fas fa-check fa-fw"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="blog-table">
        <div class="blog-tr bg-light">
            <div class="blog-th">
                <div class="form-check me-2">
                    <input class="form-check-input" type="checkbox" value="" id="checkAll">
                </div>
                <span>批量<br/>操作</span>
            </div>
            <div class="blog-th">刪除</div>
            <div class="blog-th">編輯</div>
            <div class="blog-th">編號
                <?php if (!isset($orderId) or $orderId === "idAsc" or isset($orderDate)) : ?>
                    <a href="blog.php?orderId=idDesc" class="btn btn-outline-primary btn-sm ms-2" role="button">
                        <i class="fas fa-sort-amount-up-alt fa-fw"></i>
                    </a>
                <?php elseif ($orderId === "idDesc") : ?>
                    <a href="blog.php?orderId=idAsc" class="btn btn-outline-primary btn-sm ms-2" role="button">
                        <i class="fas fa-sort-amount-down fa-fw"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="blog-th">標題</div>
            <div class="blog-th">圖片</div>
            <div class="blog-th">作者
                <div class="dropdown">
                    <a class="btn btn-outline-primary dropdown-toggle ms-2 btn-sm" href="#" role="button"
                       id="blogAuthorDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogAuthorDropdown">
                        <li>
                            <a class="dropdown-item <?php if (!isset($author))
                                echo "active"; ?>" aria-current="page" href="blog.php">全部</a>
                        </li>
                        <?php foreach ($rowsBlogAuthor as $valueBlogAuthor) : ?>
                            <li>
                                <a class="dropdown-item <?php if (isset($author) && $valueBlogAuthor["id"] == $author) echo "active" ?>"
                                   href="blog.php?author=<?= $valueBlogAuthor["id"] ?>"><?= $valueBlogAuthor["name"] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="blog-th">日期
                <?php if (!isset($orderDate) or ($orderDate === "dateAsc") or (isset($orderId))) : ?>
                    <a href="blog.php?orderDate=dateDesc" class="btn btn-outline-primary btn-sm ms-2" role="button">
                        <i class="fas fa-sort-amount-up-alt fa-fw"></i>
                    </a>
                <?php elseif ($orderDate === "dateDesc") : ?>
                    <a href="blog.php?orderDate=dateAsc" class="btn btn-outline-primary btn-sm ms-2" role="button">
                        <i class="fas fa-sort-amount-down fa-fw"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="blog-th">內容</div>
            <div class="blog-th">類別
                <div class="dropdown">
                    <a class="btn btn-outline-primary dropdown-toggle ms-2 btn-sm" href="#" role="button"
                       id="blogCategoryDropdown" data-bs-toggle="dropdown" aria-expanded="false"></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="blogCategoryDropdown">
                        <li>
                            <a class="dropdown-item <?php if (!isset($category))
                                echo "active"; ?>" aria-current="page" href="blog.php">全部</a>
                        </li>
                        <?php foreach ($rowsBlogCategory as $valueBlogCategory) : ?>
                            <li>
                                <a class="dropdown-item <?php if (isset($category) && $valueBlogCategory["id"] == $category) echo "active" ?>"
                                   href="blog.php?category=<?= $valueBlogCategory["id"] ?>"><?= $valueBlogCategory["name"] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php if (!$rows or isset($_SESSION["error_msg"])) : ?>
            <div class="blog-tr-empty">
                <div class="blog-td">目前沒有資料。</div>
            </div>
        <?php else : ?>
            <?php foreach ($rows as $value) : ?>
                <div class="blog-tr">
                    <div class="blog-td">
                        <input class="form-check-input order-check" type="checkbox" value="<?= $value["id"] ?>"
                               name="batch_id[]" form="blogBatchForm">
                    </div>
                    <div class="blog-td">
                        <a href="doDelete.php?id=<?= $value["id"] ?>" role="button"
                           class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt fa-fw"></i></a>
                    </div>
                    <div class="blog-td">
                        <a href="edit-post.php?id=<?= $value["id"] ?>" role="button"
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit fa-fw"></i></a>
                    </div>
                    <div class="blog-td d-flex justify-content-center"><?= $value["id"] ?></div>
                    <div class="blog-td">
                        <?php if (isset($batchEdit)) : ?>
                            <textarea class="form-control h-100" id="" name="title[]" form="blogBatchForm"
                                      rows="3"><?= $value["title"] ?></textarea>
                        <?php else :
                            echo $value["title"];
                        endif; ?>
                    </div>
                    <div class="blog-td">
                        <?php //依據img的形式(網址or檔案)判別路徑
                        if (substr($value["image"], 0, 4) === "http") : ?>
                            <img class="blog-img" src="<?= $value["image"] ?>" alt="blog-cover">
                        <?php else : ?>
                            <img class="blog-img" src="./upload/<?= $value["image"] ?>" alt="blog-cover">
                        <?php endif; ?>
                    </div>
                    <div class="blog-td">
                        <?= $rowsBlogAuthor[$value["author_id"] - 1]["name"] ?>
                    </div>
                    <div class="blog-td"><?= $value["created_at"] ?></div>
                    <div class="blog-td">
                        <?php if (isset($batchEdit)) : ?>
                            <div class="blog-content">
                                <textarea class="form-control h-100" id="" name="context[]" form="blogBatchForm"
                                          rows="3"><?= $value["context"] ?></textarea>
                            </div>
                        <?php else : ?>
                            <div class="blog-content">
                                <?= $value["context"] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="blog-td">
                        <?= $rowsBlogCategory[$value["category_id"] - 1]["name"] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($page)) : ?>
            <nav aria-label="Page navigation mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
                        <a class="page-link" href="blog.php?page=<?php if ($page < $totalPages) :
                            $prevPage = $page - 1;
                            echo $prevPage;
                        else :
                            echo 1;
                        endif; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
                        <a class="page-link" href="blog.php?page=1" aria-label="first">
                            <span aria-hidden="true">第一頁</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php if ($page == $i) echo "active" ?>" <?php if ($page === $i) echo "aria-current='page'" ?>>
                            <a class="page-link" href="blog.php?page=<?= $i ?>"><?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($page == $totalPages) echo "disabled" ?>">
                        <a class="page-link" href="blog.php?page=<?= $totalPages ?>" aria-label="last">
                            <span aria-hidden="true">最後頁</span>
                        </a>
                    </li>
                    <li class="page-item <?php if ($page == $totalPages) echo "disabled" ?>">
                        <a class="page-link" href="blog.php?page=<?php if ($page < $totalPages) :
                            $nextPage = $page + 1;
                            echo $nextPage;
                        else :
                            echo $totalPages;
                        endif; ?>" aria-label="Next">
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