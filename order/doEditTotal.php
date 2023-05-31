<?php
require_once("../pdo-connect.php");
if (isset($_GET["id"]) && isset($_POST["total"])) {
    $page = $_GET["page"];
    $id = $_GET["id"];
    $total = $_POST["total"];
    $sql = "UPDATE user_order SET total = ? WHERE id = ?";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$total, $id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["msg"] = "更新完成。";
        header("location: order_detail.php?id=$id");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    $_SESSION["error_msg"] = "更新金額失敗。";
    header("location: order . php");
}
