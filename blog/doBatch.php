<?php
require_once("../pdo-connect.php");
if (isset($_POST["batch_id"]) && isset($_POST["batch_action"])) {
    $batch_id = $_POST["batch_id"];
    $batch_action = $_POST["batch_action"];
    $batch_ids = http_build_query(array('batchId' => $batch_id));
    $batch_edit = http_build_query(array('batchEdit' => $batch_id));
    switch ($batch_action) {
        case 0:
            header("location: blog.php?$batch_edit");
            break;
        case 1:
            $title = $_POST["title"];
            $context = $_POST["context"];
            $blogData = [];
            foreach ($batch_id as $key => $value) {
                $blogData = ["title" => $title[$key], "context" => $context[$key], "id" => $value];
                $sql = "UPDATE blog SET title=:title, context=:context WHERE id=:id";
                $stmt = $db_host->prepare($sql);
                try {
                    $stmt->execute($blogData);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
            }
            $_SESSION["msg"] = "成功批量修改內容。";
            header("location: blog.php?$batch_ids");
            break;
        case 2:
            $batch_params = str_repeat('?,', count($batch_id) - 1) . '?';
            var_dump($batch_params);
            $sql = "UPDATE blog SET valid = 0 WHERE id IN ($batch_params)";
            $stmt = $db_host->prepare($sql);
            try {
                $stmt->execute($batch_id);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION["msg"] = "成功批量刪除資料。";
                header("location: blog.php");
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            break;
    }
} else {
    $_SESSION["error_msg"] = "操作失敗。請先批量勾選，選擇操作後點擊確認。";
    header("location: blog.php");
}