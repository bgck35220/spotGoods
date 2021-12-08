<?php
require_once("pdo-connect.php");

//檢查使用者帳號是已存在
$sqlCheck = "SELECT account FROM users";
$checkResult = $db_host->prepare($sqlCheck);
try{
    $checkResult->execute();
    $userRows = $checkResult->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    echo $e->getMessage();
    $db_host = NULL;
}
?>

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
        .error{
            font-size: 14px;
        }
        .show-password{
            font-size: 14px;
            color: #777;
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
                        <input id="name" type="text" name="name" required class="form-control" placeholder="中文 / 英文姓名">
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
                        <input id="account" type="text" name="account" required class="form-control" placeholder="數字/英文/底線，5-16個字，以英文開頭，大小寫不限">
                        <div class="error text-danger text-end"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password">密碼</label>
                        <input id="password" type="password" name="password" required class="form-control"
                               placeholder="至少5個字，需包含大小寫字母和數字，可以有特殊符號">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center p-1">
                                <input type="checkbox" id="showPassword"><span class="show-password ms-2">顯示密碼</span>
                            </div>
                            <div id="passwordError" class="error text-danger text-end d-float"></div>
                        </div>
                    </div>
<!--                    <div class="mb-3">-->
<!--                        <label for="repassword">確認密碼</label>-->
<!--                        <input id="repassword" type="password" name="repassword" required class="form-control"-->
<!--                               placeholder="請再次輸入密碼">-->
<!--                        <div class="d-flex align-items-center justify-content-between">-->
<!--                            <div class="d-flex align-items-center p-1">-->
<!--                                <input type="checkbox" id="showPassword"><span class="show-password ms-2">顯示密碼</span>-->
<!--                            </div>-->
<!--                            <div id="repasswordError" class="error text-danger text-end d-float"></div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="mb-3">
                        <label for="phone">手機號碼</label>
                        <input id="phone" type="text" name="phone" required class="form-control" placeholder="09xxxxxxxx">
                        <div class="error text-danger text-end"></div>
                    </div>
                    <div class="mb-3">
                        <label for="address">地址</label>
                        <input id="address" type="text" name="address" required class="form-control">
                        <div class="error text-danger text-end"></div>
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
    // 顯示密碼
    // $("#showPassword").mousedown(function(){
    //     $("#password").attr("type", "text");
    // });
    // $("#showPassword").mouseup(function(){
    //     $("#password").attr("type", "password");
    // });
    $(":checkbox").click(function(){
        if($(this).is(":checked")==true){
            $("#password").attr("type", "text");
        }else{
            $("#password").attr("type", "password");
        }
    });


    //姓名驗證: 只能全中文/英文
    const reName = /^[\u4e00-\u9fa5]+$|^[a-zA-Z\s]+$/;
    $("#name").blur(function () {
        if (reName.test($("#name").val())) {
            $(this).next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            $(this).next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });


    //電子信箱格式檢查
    // const reEmail = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    const reEmail = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
    $("#email").blur(function () {
        if (reEmail.test($("#email").val())) {
            $(this).next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            $(this).next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });


    //帳號檢查
    //字母開頭，允許5-16位元組，允許字母數字下劃線
    const reAccount = /^[a-zA-Z][a-zA-Z0-9_]{4,15}$/;
    $("#account").blur(function () {
        if (reAccount.test($("#account").val())) {
            $(this).next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            $(this).next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });


    //密碼檢查
    // const rePassword=/^[a-zA-Z]\w{5,}$/;
    // 字母開頭，允許6-14位元組，允許字母數字下劃線
    // const rePassword=/^(?=.*[^a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{6,}$/;
    // 高強度密碼，6位數以上，並且至少包含 大寫字母、小寫字母、數字、符號 各一
    // const rePassword=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,10}$/;
    // 包含大小寫字母和數字的組合，不能使用特殊字元，長度在6-18之間
    // const rePassword=/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,18}$/;

    // 5位數以上，並且至少包含 大寫字母、小寫字母、數字 各一，可以有特殊符號
    const rePassword=/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{5,}$/;
    $("#password").blur(function () {
        if (rePassword.test($("#password").val())) {
            $("#passwordError").text("");
            $(this).removeClass("border-danger");
        } else {
            $("#passwordError").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });

    //二次輸入密碼檢查
    // $("#repassword").blur(function () {
    //     if (rePassword.test($("#repassword").val())) {
    //         $("#repasswordError").text("");
    //         $(this).removeClass("border-danger");
    //     } else {
    //         $("#repasswordError").text("輸入格式有誤");
    //         $(this).addClass("border-danger");
    //     }
    // });


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

    // 尚未註冊完成，離開頁面提醒
    $(".navbar-brand").click(function () {
        let result = confirm("尚未註冊完成，確定要離開此頁面?");
        if (result) {
            return true;
        } else {
            return false;
        }
    });

    //離開網頁提醒
    // window.onbeforeunload=function(e){
    //     var e=window.event||e;
    //     e.returnValue=("確定離開當前頁面嗎？");
    // }


    //

    //let users=<?//=json_encode($userRows)?>//;
    //// console.log(users.account);
    //console.log(users[0].account);


</script>
</body>
</html>