<!--刪除會員資料(軟刪除)-->
<?php
require_once("../pdo-connect.php");
$id=$_GET["id"];
$sql="UPDATE users SET valid=0 WHERE id='$id'";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if ($stmt->execute() === TRUE) {
    echo "<script>alert('刪除資料成功!'); location.href = 'user-list.php';</script>";
} else {
    echo "<script>alert('失敗'); location.href = 'user-list.php';</script>";
}
?>
