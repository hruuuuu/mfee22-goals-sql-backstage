<!--登入介面-->
<!doctype html>
<html lang="en">

<head>
    <title>登入</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        .wrap {
            margin-top: 100px;
            display: flex;
            justify-content: center;
        }

        .home {
            position: absolute;
            margin-top: -80px;
            margin-left: 200px;
        }

        label {
            text-align: right;
            width: 50px;
        }

        h1 {
            font-size: 1.75rem;
            padding-top: 0px;
            margin-bottom: ;
        }

        .goRegister:hover {
            /*opacity: 1;*/
            text-decoration: none;
        }
    </style>

</head>

<body>

    <a href="../product/frontend_single-product.php" class="home btn btn-info text-white" style="margin-left: 100px">回商品頁</a>
    <a href="../dashboard.php" class="home btn btn-info text-white">回後台系統</a>

    <div class="wrap">
        <div style="width:600px;">
            <h1 class="mb-2 text-center fw-bolder">ＧＯＡＬＳ</h1>
            <h1 class="mb-5 text-center">登 入 系 統</h1>
            <form class="form-horizontal" action="doLogin.php" method="post">
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-3 text-center">
                        <label for="name" class="col-form-label">用戶名</label>
                    </div>
                    <div class="col-9">
                        <input id="name" name="name" class="form-control" aria-describedby="passwordHelpInline">
                    </div>
                </div>

                <div class="form-floating row g-3 align-items-center mb-4">
                    <div class="col-3 text-center">
                        <label for="password" class="col-form-label">密碼</label>
                    </div>
                    <div class="col-9">
                        <input type="password" name="password" id="password" class="form-control" aria-describedby="passwordHelpInline">
                    </div>
                </div>
                <div class="text-center">還沒有帳號？&nbsp<a href="Register.php" class="goRegister">註冊</a></div>
                <div class="controls d-grid gap-2 mb-5 mt-3">
                    <button type="submit" class="btn btn-info text-white">登入</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>