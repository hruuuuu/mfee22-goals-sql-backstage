<?php
require_once("../pdo-connect.php");
if (isset($_POST["id"]) && isset($_POST["status"])) {
    $id = $_POST["id"];
    $status = $_POST["status"];
    $sql = "UPDATE user_order SET status_id = ? WHERE id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$status, $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["msg"] = "成功更改狀態。";
        header("location: order.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} elseif (isset($_POST["batch_id"]) && isset($_POST["batch_status"])) {
    $batch_status = array($_POST["batch_status"]);
    $batch_id = $_POST["batch_id"];
    var_dump($batch_id);
    $batch_params = str_repeat('?,', count($batch_id) - 1) . '?';
    $sql = "UPDATE user_order SET status_id = ? WHERE id IN ($batch_params)";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute(array_merge($batch_status, $batch_id)); //合併陣列(這邊用array_unshift會失敗)
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["msg"] = "更改狀態成功。";
        header("location: order.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo "something went wrong";
    }
} else {
    $_SESSION["error_msg"] = "更改狀態失敗。請先選擇操作後點擊確認。";
    header("location: order.php");
}