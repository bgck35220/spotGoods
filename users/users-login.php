<?php
session_start();
//若使用者已登入到dashboard頁面，但回到login頁面
//還是會導向dashboard，避免回到sign-in，因使用者還沒按登出
if(isset($_SESSION["user"])){
    header("location: dashboard.php");
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* body{
            /*background: #ddd;
        }*/
        .wrapper{
            /*background: #f8f9fa;*/
            width: 380px;
            height: 400px;
            text-align: center;
            display: flex;
            justify-content: center;
            position: absolute;
            top: 60px;
            border-radius: 10px;
            border: 1px solid #eee;
            /*box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.15);*/
        }
        .login-pantel {
            width: 300px;
        }
        .form-control{
            position: relative;
        }
        .form-control:focus{
            z-index: 1;
        }
        .form-floating>label{
            z-index: 2;
        }

        .input-up .form-control {
            border-radius: .25rem .25rem 0 0;
        }

        .input-bottom .form-control {
            border-top: none;
            border-radius: 0 0 .25rem .25rem;
        }
    </style>

</head>
<body>
<header class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="index.php">team01</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- 會員登入 -->
<div class="d-flex justify-content-center align-items-center position-relative">
    <?php $maxErrorTimes=6; ?>
    <div class="wrapper">
        <div class="login-pantel text-center">
            <form action="doLogin.php" method="post">
                <div class="">
                    <?php if(isset($_SESSION["error_times"]) && $_SESSION["error_times"]>=$maxErrorTimes): ?>
                        <h3 class="mt-3">登入錯誤次數太多<br>請稍後再嘗試</h3>
                    <?php else: ?>
                        <h1 class="loginTitle pt-4 mb-3 mt-5 fs-5 fw-normal text-muted">會員登入</h1>

                        <div class="form-floating input-up">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Account" name="account" required>
                            <label for="floatingInput">帳號 Account</label>
                        </div>
                        <div class="form-floating input-bottom mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                            <label for="floatingPassword">密碼 Password</label>
                        </div>
                        <?php if(isset($_SESSION["error_msg"])): ?>
                            <div class="alert alert-danger" role="alert"><?=$_SESSION["error_msg"]?><br>您還可以嘗試登入 <?php
                                $canError=$maxErrorTimes-$_SESSION["error_times"];
                                echo $canError;
                                ?> 次</div>
                            <?php
                            unset($_SESSION["error_msg"]);
                        endif;
                        ?>
                        <div class="d-grid gap-2 my-3">
                            <button class="btn btn-info text-white" type="submit">登入</button>
                        </div>
                        <div class="text-muted">還不是會員嗎? 請點此 <a href="sign-up.php" class="text-info">註冊</a></div>
                    <?php endif;?>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
