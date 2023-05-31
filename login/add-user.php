<!--註冊功能-->
<?php
require_once("../pdo-connect.php");
$username = $_POST["name"];
$password = $_POST["password"];
$email = $_POST["email"];
$birthday = $_POST["birthday"];
$address = $_POST["address"];
$gender = $_POST["gender"];

$sql = "INSERT INTO users (name, password, email, birthday , address, gender, created_time, valid) VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
$stmt = $db_host->prepare($sql);
try {
    $date=date('Y-m-d');
    $stmt->execute([$username, $password, $email, $birthday, $address, $gender, $date]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<script>alert('註冊成功'); location.href = '../dashboard.php';</script>";
//    header("location: register.php");
} catch (PDOException $e) {
    echo $e->getMessage();
}