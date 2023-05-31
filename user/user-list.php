<!--會員列表-->
<?php
require_once("../pdo-connect.php");
$sql = "SELECT * FROM users WHERE valid = 1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute();
    $rows = $stmt->rowCount();
    $rowUserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
if (isset($_GET["s"])) {
    $search = $_GET["s"];
    //    echo $search;
    $sql = "SELECT * FROM users WHERE name LIKE '%$search%'";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->rowCount();
        $rowUserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["newUser"])) {
    $new = $_GET["newUser"];
    $sql = "SELECT * FROM users WHERE created_time = CURDATE()";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->rowCount();
        //        var_dump($rows);
        $rowUserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["userId"])) {
    $userId = $_GET["userId"];
    switch ($userId) {
        case "idDesc":
            $sql = "SELECT * FROM users WHERE valid = 1 ORDER BY id DESC";
            break;
        case "idAsc":
            $sql = "SELECT * FROM users WHERE valid = 1 ORDER BY id ASC";
            break;
    }
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->rowCount();
        $rowUserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_GET["startDate"])) {
    $startDate = $_GET["startDate"];
    $date = date("Y-m-d");
    if ($startDate > $date) {
        echo "<script>alert('篩選日期晚於今日，請重新輸入'); location.href = 'user-list.php';</script>";
    }
    $sql = "SELECT * FROM users WHERE created_time > ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$startDate]);
        $rows = $stmt->rowCount();
        $rowUserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $itemsPerPage = 15;
    $startItem = ($page * $itemsPerPage) - $itemsPerPage;
    $totalItems = $rows;
    if ($totalItems % $itemsPerPage === 0) {
        $totalPages = $totalItems / $itemsPerPage;
    } else {
        $totalPages = ceil($totalItems / $itemsPerPage);
    }
    $sql = "SELECT * FROM users WHERE valid = 1 ORDER BY id ASC LIMIT $startItem, $itemsPerPage";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute();
        $rows = $stmt->rowCount();
        $rowUserList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>用戶列表</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <style>
        thead,
        tbody {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>
                <a href="user-list.php" style="text-decoration: none">會員列表</a>
            </h1>

        </div>
        <div class="d-flex justify-content-end">
            <span>共<?php if (isset($page)) :
                        echo $totalItems;
                    else :
                        echo $rows;
                    endif; ?> 位使用者</span>
        </div>
        <div class="py-3 d-flex justify-content-between align-items-center">
            <a href="../dashboard.php" class="btn btn-primary">回主頁</a>
            <div class="d-flex">
                <form action="user-list.php" method="get">
                    <div class="me-2 d-flex align-items-center">
                        <input type="search" class="form-control " placeholder="請搜尋姓名" name="s" value="<?php if (isset($search)) echo $search; ?>">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <form action="user-list.php" method="get">
                    <div class="d-flex align-items-center">
                        <input type="date" class="form-control" id="startDate" name="startDate" value="<?php if (isset($startDate)) echo $startDate ?>">
                        <button class="btn btn-outline-primary text-nowrap" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <main class="col-lg-12">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr style="border-bottom:groove black;">
                            <th>編號<?php if (!isset($userId) or $userId === "idAsc") : ?>
                                <a href="user-list.php?userId=idDesc" class="btn btn-outline-primary btn-sm mx-2" role="button">
                                    <div>↓</div>
                                </a>
                            <?php elseif ($userId === "idDesc") : ?>
                                <a href="user-list.php?userId=idAsc" class="btn btn-outline-primary btn-sm mx-2" role="button">
                                    <div>↑</div>
                                </a>
                            <?php endif; ?>
                            </th>
                            <th>姓名</th>
                            <th>密碼</th>
                            <th>email</th>
                            <th>生日</th>
                            <th>地址</th>
                            <th>性別</th>
                            <th>加入日期</th>
                            <th>編輯 / 刪除</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows > 0) :
                            foreach ($rowUserList as $value) : //關聯式陣列
                        ?>
                                <tr>
                                    <td><?= $value["id"] ?></td>
                                    <td><?= $value["name"] ?></td>
                                    <td><?= $value["password"] ?>
                                    <td><?= $value["email"] ?></td>
                                    <td><?= $value["birthday"] ?></td>
                                    <td><?= $value["address"] ?></td>
                                    <td><?php
                                        if ($value["gender"] == 1)
                                            echo "男";
                                        else
                                            echo "女"; ?> </td>
                                    <td><?= $value["created_time"] ?> </td>
                                    <td>
                                        <a href="user-edit.php?id=<?= $value["id"] ?>  role=" edit" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit fa-fw"></i></a> ｜
                                        <a href="doDelete.php?id=<?= $value["id"] ?>" role="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt fa-fw"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4">沒有資料</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (isset($page)) : ?>
                    <nav aria-label="Page navigation mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php if ($page == 1) echo "disabled" ?>">
                                <a class="page-link" href="user-list.php?page=<?php
                                                                                if ($page < $totalPages) :
                                                                                    $prevPage = $page - 1;
                                                                                    echo $prevPage;
                                                                                else :
                                                                                    echo 1;
                                                                                endif; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php if ($page == $i) echo "active" ?>" <?php if ($page === $i) echo "aria-current='page'" ?>>
                                    <a class="page-link" href="user-list.php?page=<?= $i ?>"><?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if ($page == $totalPages) echo "disabled" ?>">
                                <a class="page-link" href="user-list.php?page=<?php if ($page < $totalPages) :
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

            </main>
        </div>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>