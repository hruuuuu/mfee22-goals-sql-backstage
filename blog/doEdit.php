<?php
require_once("../pdo-connect.php");
if (isset($_POST["upload"])) {
    $image = $_POST["image"];
    $image_file = $_FILES["imageFile"];
    $image_file_name = $_FILES["imageFile"]["name"];

    $id = $_POST["id"];
    $title = $_POST["title"];
    $author_name = $_POST["author_name"];
    $context = $_POST["context"];
    $category = $_POST["category"];
//判斷img是檔案or路徑
    if (($image_file_name !== "") && ($image !== "")) { //如果兩者皆有內容
        $_SESSION["img_error_msg"] = "圖片檔案及網址請擇一輸入。";
        header("location: edit-post.php?id=$id");
    } elseif (($image_file_name === "") && ($image === "")) { //如果兩者皆空
        $_SESSION["img_error_msg"] = "請選擇要上傳的圖片。";
        header("location: edit-post.php?id=$id");
    } elseif (($image_file_name === "") && (substr($image, 0, 4) !== "http")) { //如果檔案為空且網址開頭錯誤
        $_SESSION["img_error_msg"] = "請輸入正確圖片網址。";
        header("location: edit-post.php?id=$id");
    } elseif (($image_file_name === "") && ($image !== "")) { //如果檔案為空且網址有內容
        $_SESSION["img_path"] = $image;
        $_SESSION["title"] = $title;
        $_SESSION["author_name"] = $author_name;
        $_SESSION["context"] = $context;
        $_SESSION["category"] = $category;
        header("location: edit-post.php?id=$id");
    } else { //如果檔案有內容且網址為空
        if ($_FILES["imageFile"]["error"] === 0) { //檢查檔案
            if (move_uploaded_file($image_file["tmp_name"], "upload/" . $image_file_name)) {
                $_SESSION["img_path"] = $image_file_name;
                $_SESSION["title"] = $title;
                $_SESSION["author_name"] = $author_name;
                $_SESSION["context"] = $context;
                $_SESSION["category"] = $category;
                header("location: edit-post.php?id=$id");
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
    $id = $_POST["id"];
    $title = $_POST["title"];
    $author_name = $_POST["author_name"];
    $context = $_POST["context"];
    $category = $_POST["category"];

    unset($_SESSION["prev_img_path"]);
    unset($_SESSION["img_path"]);

    //再作為session傳回去
    $_SESSION["title"] = $title;
    $_SESSION["author_name"] = $author_name;
    $_SESSION["context"] = $context;
    $_SESSION["category"] = $category;
    header("location: edit-post.php?id=$id");
}

if (isset($_POST["save"]) && isset($_POST["id"])) {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $image = $_POST["image_path"];
    $author_id = $_POST["author_id"];
    $author_name = $_POST["author_name"];
    $context = $_POST["context"];
    $category = $_POST["category"];
    $page = $_POST["page"];

    date_default_timezone_set('Asia/Taipei');
    $date = date("Y-m-d");

    $sqlAuthorName = "UPDATE blog_author SET name = ? WHERE id = ?";
    $stmtAuthorName = $db_host->prepare($sqlAuthorName);
    try {
        $stmtAuthorName->execute([$author_name, $author_id]);
        $rowsAuthorName = $stmtAuthorName->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $sql = "UPDATE blog SET title = ?, author_id = ?, image = ?, context = ?, created_at = ?, category_id = ?  WHERE id= '$id'";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$title, $author_id, $image, $context, $date, $category]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["msg"] = "成功修改內容。";
        header("location: blog.php?page=$page");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}