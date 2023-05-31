<!--登入-->
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
        if ($name=="admin"){
            $_SESSION["name"]=$name;
            echo "<script>alert('歡迎 管理者!'); location.href = '../dashboard.php';</script>";
        }else{
        $_SESSION["name"]=$name;
        echo $_SESSION["name"];
        var_dump($_SESSION["name"]);
        echo "<script>alert('登入成功，即將返回商品頁!'); location.href = '../product/frontend_single-product.php';</script>";
        }
    }else{
        echo "<script>alert('帳號或密碼錯誤，請確認'); location.href = 'login.php';</script>";
    }
}catch(PDOException $e){
    echo $e->getMessage();
}

