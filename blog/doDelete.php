<?php
require_once("../pdo-connect.php");
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "UPDATE blog SET valid = 0 WHERE id = ? AND valid = 1";
    $stmt = $db_host->prepare($sql);
    try {
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        echo "successfully deleted";
        header("location: blog.php");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header("location: blog.php");
}