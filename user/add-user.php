<?php
require_once("../pdo-connect.php");
$username = $_POST["name"];
$password = $_POST["password"];
$email = $_POST["email"];
$birthday = $_POST["birthday"];
$address = $_POST["address"];
$gender = $_POST["gender"];



$sql = "INSERT INTO users (name, password, email, birthday , address, gender, valid) VALUES (?, ?, ?, ?, ?, ?, 1)";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute([$username, $password, $email, $birthday, $address, $gender]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<script>alert('註冊成功'); location.href = 'user-list.php';</script>";
//    header("location: register.php");
} catch (PDOException $e) {
    echo $e->getMessage();
}