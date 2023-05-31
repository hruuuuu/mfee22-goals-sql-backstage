<!--編輯會員介面-->
<?php
if(isset($_GET["id"])){
    $id=$_GET["id"];
}else{
    $id=0;
}

require_once("../pdo-connect.php");

$sql = "SELECT * FROM users WHERE id ='$id' AND valid=1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute();
    $userExist=$stmt->rowCount();
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();

}

?>
<!doctype html>
<html lang="en">
<head>
    <title>Edit User</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>

</head>
<body>
    <div class="container">
        <div class="py-2 d-flex justify-content-end">
            <div>
                <a class="btn btn-primary" href="user-list.php">回列表</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if($userExist===0): ?>
                    使用者不存在
                <?php else:foreach ($rows as $value): ?>
                <form action="doUpdate.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$value["id"]?>">

                    <div class="mb-3">
                        <label for="name">姓名</label>
                        <input id="name" type="text" name="name" class="form-control" value="<?=$value["name"]?>">
                    </div>

                    <div class="mb-3">
                        <label for="password">密碼</label>
                        <input id="password" type="text" name="password" class="form-control-plaintext" value="<?=$value["password"]?>" readonly>
                    </div>


                    <div class="mb-3">
                        <label for="email">email</label>
                        <input id="email" type="email" name="email" class="form-control" value="<?=$value["email"]?>">
                    </div>

                    <div class="mb-3">
                        <label for="address">地址</label>
                        <input id="address" type="text" name="address" class="form-control" value="<?=$value["address"]?>">
                    </div>

                    <div class="mb-2">
                          <label for="myFile" class="mb-3">上傳會員圖</label>
                        <input type="file" class="form-control"  name="myFile" id="myFile" />
                        <img class="mt-3"  id="myFile0"  style="width: 200px">
                    </div>

                    <button class="btn btn-primary" type="submit">送出</button>

                </form>

                <?php endforeach; endif;?>

            </div>
        </div>
    </div>

    <script>
        $("#myFile").change(function(){
            var objUrl = getObjectURL(this.files[0]) ;
            console.log("objUrl = "+objUrl) ;
            if (objUrl) {
                $("#myFile0").attr("src", objUrl) ;
            }
        }) ;
        function getObjectURL(file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
            console.log( url )
        }
    </script>


</html>