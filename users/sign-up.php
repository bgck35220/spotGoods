<!doctype html>
<html lang="en">
<head>
    <title>Sign up</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-control::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #aaa;
            font-size: 14px;
            opacity: 1; /* Firefox */
        }
    </style>
</head>
<body>
<header class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="index.php">team01</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <form action="doSignUp.php" method="post">
                <h1 class="loginTitle mb-3 mt-3 fs-5 fw-normal text-muted">會員註冊</h1>
                <div class="mb-3">
                    <label for="name">姓名</label>
                    <input id="name" type="text" name="name" required class="form-control" placeholder="中/英文姓名">
                    <div class="error text-danger text-end"></div>
                </div>
                <div class="mb-3">
                    <label for="email">電子信箱</label>
                    <input id="email" type="email" name="email" required class="form-control"
                           placeholder="name@example.com">
                    <div class="error text-danger text-end"></div>
                </div>
                <div class="mb-3">
                    <label for="account">帳號</label>
                    <input id="account" type="text" name="account" required class="form-control" placeholder="設定您的帳號">
                </div>
                <div class="mb-3">
                    <label for="password">密碼</label>
                    <input id="password" type="password" name="password" required class="form-control"
                           placeholder="設定您的密碼">
                </div>
                <div class="mb-3">
                    <label for="repassword">確認密碼</label>
                    <input id="repassword" type="password" name="repassword" required class="form-control"
                           placeholder="請再次輸入密碼">
                </div>
                <div class="mb-3">
                    <label for="phone">手機號碼</label>
                    <input id="phone" type="text" name="phone" required class="form-control" placeholder="09xxxxxxxx">
                    <div class="error text-danger text-end"></div>
                </div>
                <div class="mb-3">
                    <label for="address">地址</label>
                    <input id="address" type="text" name="address" required class="form-control">
                </div>
                <button class="btn btn-secondary" type="submit">註冊</button>
            </form>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>

<script>

    // const reName = /^%&',;=?$x22]+/;

    //電子信箱格式檢查
    const reEmail = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    $("#email").blur(function () {
        if (reEmail.test($("#email").val())) {
            $(this).next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            $(this).next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });

    //手機號碼格式檢查
    const rePhone = /^09\d{8}$/;  //09開頭，數字{8次}，$代表字元結尾
    $("#phone").blur(function () {
        if (rePhone.test($("#phone").val())) {
            // alert("符合規則");
            $(this).next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            // alert("不符合規則");
            $(this).next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });

    //尚未註冊完成，離開頁面提醒
    $(".navbar-brand").click(function () {
        let result = confirm("尚未註冊完成，確定要離開此頁面?");
        if (result) {
            return true;
        } else {
            return false;
        }
    });
</script>

</body>
</html>