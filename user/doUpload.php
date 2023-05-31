<!--上傳資料功能(未使用)-->
<?php
require_once ("../pdo-connect.php");
//var_dump($_FILES["myFile"]);

//$_FILES["file"]["name"]：上傳檔案的原始名稱。
// $_FILES["file"]["name"]：上傳檔案的原始名稱。
//$_FILES["file"]["type"]：上傳的檔案類型。
//$_FILES["file"]["size"]：上傳的檔案原始大小。
//$_FILES["file"]["tmp_name"]：上傳檔案後的暫存資料夾位置。
//$_FILES["file"]["error"]：如果檔案上傳有錯誤，可以顯示錯誤代碼。

if($_FILES["myFile"]["error"]===0){  //沒有錯誤訊息時
    if(move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/".$_FILES["myFile"]["name"] )){

        $now=date("Y-m-d H:i:s");
        $file_name=$_FILES["myFile"]["name"];
        $user_id=$_SESSION["user"]["id"];

        $sql="INSERT INTO user_upload (user_id, file_name, uploaded_at, valid) VALUES (?, ? ,? , 1)";
        $stmt=$db_host->prepare($sql);
        try{
            $stmt->execute([$user_id, $file_name, $now]);

//            echo "upload success";
            header("location: file-upload.php");
        }catch(PDOException $e){
            echo $e->getMessage();
        }

//        echo "upload success";
    }else{
        echo "upload failed";
    }

}


?>