<!--編輯資料功能-->
<?php
$id=$_POST["id"];
$name=$_POST["name"];
$email=$_POST["email"];
$address=$_POST["address"];

require_once("../pdo-connect.php");

$sql = "UPDATE users SET email='$email', name='$name', address='$address' WHERE id='$id'";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute();
//    move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/".$_FILES["myFile"]["name"] );
} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($stmt->execute() === TRUE) {
    echo "<script>alert('修改成功!'); location.href = 'user-list.php';</script>";

} else {
    echo "<script>alert('失敗!'); location.href = 'user-list.php';</script>";

}

// 上傳資料功能
//if($_FILES["myFile"]["error"]===0) {  //沒有錯誤訊息時
//    move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/" . $_FILES["myFile"]["name"]);
//
//        $file_name = $_FILES["myFile"]["name"];
//    var_dump( $file_name);
//    $sql = "UPDATE users SET image = ? WHERE id ='$id'" ;
//    ;
//        $stmt = $db_host->prepare($sql);
//        try {
//            $stmt->execute([$file_name]);
//
//            echo "upload success";
////            header("location: file-upload.php");
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//        echo "upload success";
//    }else{
//        echo "upload failed";
//    }

?>
