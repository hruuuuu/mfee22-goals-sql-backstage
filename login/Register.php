<!--註冊介面-->
<!doctype html>
<html lang="en">
<head>
    <title>註冊</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .wrap {
            margin-top: 100px;
        }

        label{
            text-align: right;
            width: 50px;
        }

        .home{
            position: absolute;
            margin-top: -80px;
            margin-left: 200px;
        }

        .goLogin:hover{
            /*opacity: 1;*/
            text-decoration: none;
        }

    </style>
</head>
<body>

<a href="../product/frontend_single-product.php" class="home btn btn-info text-white"  style="margin-left: 100px">回商品頁</a>
<a href="../dashboard.php" class="home btn btn-info text-white">回後台系統</a>

<div class="wrap d-flex justify-content-center">

    <div style="width:600px;">
        <h1 class="h3 pt-0 mb-5 text-center">新用戶註冊</h1>

        <form class="form-horizontal"  action="add-user.php" method="post">

        <div class="row g-3 align-items-center mb-3">
            <div class="col-3 text-center">
                <label for="name" class="col-form-label">用戶名</label>
            </div>
            <div class="col-9">
                <input id="name" name="name" class="form-control" aria-describedby="passwordHelpInline">
            </div>

        </div>

        <div class="row g-3 align-items-center mb-3">
            <div class="col-3 text-center">
                <label for="password" class="col-form-label">密碼</label>
            </div>
            <div class="col-9">
                <input type="text" name="password" id="password" class="form-control" aria-describedby="passwordHelpInline">
            </div>

        </div>

        <div class="row g-3 align-items-center mb-3">
            <div class="col-3 text-center">
                <label for="email" class="col-form-label">E-mail</label>
            </div>
            <div class="col-9">
                <input type="email" name="email" id="email" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>

        </div>

        <div class="row g-3 align-items-center mb-3">
            <div class="col-3 text-center">
                <label for="birthday" class="col-form-label">生日</label>
            </div>
            <div class="col-9">
                <input type="date" name="birthday" id="birthday" class="form-control" aria-describedby="passwordHelpInline" required>
            </div>
        </div>

            <div class="row g-3 align-items-center mb-3">
                <div class="col-3 text-center">
                    <label for="address" class="col-form-label">地址</label>
                </div>
                <div class="col-9">
                    <input  id="address" name="address" class="form-control" aria-describedby="passwordHelpInline">
                </div>

            </div>
            <div class="row g-3 align-items-center mb-3">
                <div class="col-3 text-center">
                    <label class="col-form-label">性別</label>
                </div>
                <div class="col-9">
                    <input type="radio" name="gender" value="1"> 男 <input type="radio" name="gender" value="2" style="margin-left: 40px"> 女
                </div>
            </div>

            <div>已有帳號？&nbsp<a href="login.php" class="goLogin">登入</a></div>

            <!--            <div class="mb-2">-->
<!--                <label for="myFile" class="mb-3">上傳會員圖</label>-->
<!--                <input type="file" class="form-control"  name="myFile" id="myFile" />-->
<!--                <img class="mt-3"  id="myFile0"  style="width: 200px">-->
<!--            </div>-->

            <div class="controls d-grid gap-2 mb-5 mt-3">
                <button type="submit" class="btn btn-info text-white">註冊</button>
            </div>

            </div>
            </form>
    </div>
</div>

</form>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

<!--<script>-->
<!--  預覽圖片功能   ---->
<!--    $("#myFile").change(function(){-->
<!--        var objUrl = getObjectURL(this.files[0]) ;-->
<!--        console.log("objUrl = "+objUrl) ;-->
<!--        if (objUrl) {-->
<!--            $("#myFile0").attr("src", objUrl) ;-->
<!--        }-->
<!--    }) ;-->
<!---->
<!--    function getObjectURL(file) {-->
<!--        var url = null ;-->
<!--        if (window.createObjectURL!=undefined) { // basic-->
<!--            url = window.createObjectURL(file) ;-->
<!--        } else if (window.URL!=undefined) { // mozilla(firefox)-->
<!--            url = window.URL.createObjectURL(file) ;-->
<!--        } else if (window.webkitURL!=undefined) { // webkit or chrome-->
<!--            url = window.webkitURL.createObjectURL(file) ;-->
<!--        }-->
<!--        return url ;-->
<!--        console.log( url )-->
<!--    }-->
<!--</script>-->


</html>
<!-- Bootstrap JavaScript Libraries -->

