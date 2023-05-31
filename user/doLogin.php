<?php
require_once ("../pdo-connect.php");

if(isset($_POST["name"])){
    $name=$_POST["name"];
    $password=$_POST["password"];
}else{
    exit();
}
$sql="SELECT * FROM users WHERE name=? AND password = ? AND valid=1";
$stmt=$db_host->prepare($sql);
try{
    $stmt->execute([$name, $password]);
    $userExist=$stmt->rowCount();  //可以取得執行 SQL 語法影響的筆數

    if($userExist>0){
        $row=$stmt->fetch();
        $_SESSION["name"]=$name;
        echo "<script>alert('登入成功!'); location.href = 'user-list.php';</script>";
    } else{
        echo "<script>alert('登入失敗，請確認!'); location.href = 'login.php';</script>";
    }
}catch(PDOException $e){
    echo $e->getMessage();
}



