<?php
require_once("../pdo-connect.php");

if (isset($_POST["upload"])) {
    $image = $_POST["image"];
    $image_file = $_FILES["imageFile"];
    $image_file_name = $_FILES["imageFile"]["name"];

    $title = $_POST["title"];
    $author_name = $_POST["author_name"];
    $context = $_POST["context"];
    $category = $_POST["category"];
//判斷img是檔案or路徑
    if (($image_file_name !== "") && ($image !== "")) { //如果兩者皆有內容
        $_SESSION["img_error_msg"] = "圖片檔案及網址請擇一輸入。";
        header("location: add-post.php");
    } elseif (($image_file_name === "") && ($image === "")) { //如果兩者皆空
        $_SESSION["img_error_msg"] = "請選擇要上傳的圖片。";
        header("location: add-post.php");
    } elseif (($image_file_name === "") && (substr($image, 0, 4) !== "http")) { //如果檔案為空且網址開頭錯誤
        $_SESSION["img_error_msg"] = "請輸入正確圖片網址。";
        header("location: add-post.php");
    } elseif (($image_file_name === "") && ($image !== "")) { //如果檔案為空且網址有內容
        $_SESSION["img_path"] = "$image";
        $_SESSION["title"] = $title;
        $_SESSION["author_name"] = $author_name;
        $_SESSION["context"] = $context;
        $_SESSION["category"] = $category;
        header("location: add-post.php");
    } else { //如果檔案有內容且網址為空
        if ($_FILES["imageFile"]["error"] === 0) { //檢查檔案
            if (move_uploaded_file($image_file["tmp_name"], "upload/" . $image_file_name)) {
                $_SESSION["img_path"] = "$image_file_name";
                $_SESSION["title"] = $title;
                $_SESSION["author_name"] = $author_name;
                $_SESSION["context"] = $context;
                $_SESSION["category"] = $category;
                header("location: add-post.php");
            } else {
                echo "未建立資料夾或資料夾權限未開啟";
                var_dump($_FILES["imageFile"]["tmp_name"]);
                echo "<br/>";
                var_dump($_FILES["imageFile"]["name"]);
            }
        } else {
            var_dump($_FILES["imageFile"]["error"]);
        }
    }
}

if (isset($_POST["remove"])) {
    //把輸入的內容傳進來
    $title = $_POST["title"];
    $author_name = $_POST["author_name"];
    $context = $_POST["context"];
    $category = $_POST["category"];

    unset($_SESSION["img_path"]);

    //再作為session傳回去
    $_SESSION["title"] = $title;
    $_SESSION["author_name"] = $author_name;
    $_SESSION["context"] = $context;
    $_SESSION["category"] = $category;
    header("location: add-post.php");
}

if (isset($_POST["add"])) {
    $title = $_POST["title"];
    $author_name = $_POST["author_name"];
    $image = $_POST["image_path"];
    $context = $_POST["context"];
    $category = $_POST["category"];
    date_default_timezone_set('Asia/Taipei');
    $date = date("Y-m-d");

    $sqlAuthor = "SELECT * FROM blog_author WHERE name = ?"; //檢查作者是否已建立
    $stmtAuthor = $db_host->prepare($sqlAuthor);
    try {
        $stmtAuthor->execute([$author_name]);
        $countAuthor = $stmtAuthor->rowCount();
        $rowsAuthor = $stmtAuthor->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    if ($countAuthor === 0) { //若尚未建立即建立
        $sqlAuthorName = "INSERT INTO blog_author (name) VALUES (?)";
        $stmtAuthorName = $db_host->prepare($sqlAuthorName);
        try {
            $stmtAuthorName->execute([$author_name]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $sqlAuthor = "SELECT * FROM blog_author WHERE name = ?";
        $stmtAuthor = $db_host->prepare($sqlAuthor);
        try {
            $stmtAuthor->execute([$author_name]);
            $rowsAuthor = $stmtAuthor->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $author = $rowsAuthor[0]["id"];
        $sql = "INSERT INTO blog (title, author_id, image, context , created_at, category_id, valid) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $db_host->prepare($sql);
        try {
            $stmt->execute([$title, $author, $image, $context, $date, $category]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["msg"] = "成功新增資料。";
            header("location: blog.php?orderId=idDesc");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else { //若已建立則傳入blog
        $author = $rowsAuthor[0]["id"];
        $sql = "INSERT INTO blog (title, author_id, image, context , created_at, category_id, valid) VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $db_host->prepare($sql);
        try {
            $stmt->execute([$title, $author, $image, $context, $date, $category]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["msg"] = "成功新增資料。";
            header("location: blog.php?orderId=idDesc");
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}