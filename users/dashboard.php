<?php
require_once("pdo-connect.php");
//一定要使用者頁面登入才能用的話，加入此判斷有沒有權限，沒登入成功就無法使用功能
if (!isset($_SESSION["user"])) {  //導進來頁面 先檢查存不存在
    header("location: users-login.php");
}

$sql = "SELECT * FROM users WHERE id=? AND valid=1";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute([$_SESSION["user"]["id"]]);
    $userExist = $stmt->rowCount();
//    echo $userExist."<br>";
//    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}


?>

<!doctype html>
<html lang="en">
<head>
    <title>我的帳戶</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        :root {
            --dark: #555;
            --light: #ccc;
        }
        .form-control::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #aaa;
            font-size: 14px;
            opacity: 1; /* Firefox */
        }

        .cover-fit {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .top{
            box-shadow: 0rem 0.1rem 0.2rem #ddd;
        }
        .menu {
            height: 580px;
        }
        .headshot-sm{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--light);
            display: block;
        }

        .headshot {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--light);
            display: block;
        }

        .myList {
            list-style: none;
            padding: 10px 0;
        }

        .myList a {
            text-decoration: none;
            letter-spacing: .5px;
            color: var(--dark);
        }

        .error{
            font-size: 14px;
        }
        .show-password{
            font-size: 14px;
            color: #777;
        }

        .headshot-big {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid var(--light);
            display: block;
            margin: 0 auto;
        }

        .border-left {
            border-left: 1px solid var(--light);
        }
    </style>

</head>
<body>
<!--header-->
<header class="bg-light top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="index.php">team01</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">關於網站</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./user-order-list.php">我的訂單</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#" tabindex="-1" aria-disabled="true">我的最愛</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="./coupon-receive.php" tabindex="-1" aria-disabled="true">優惠券領取</a>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-end align-items-center">
                        <a class="headshot-sm me-2" href="dashboard.php">
                            <?php if($_SESSION["user"]["headshots"]==NULL):?>
                                <img class="cover-fit" src="./upload/user.png" alt="user.png">
                            <?php else:?>
                                <img class="cover-fit" src="./upload/<?= $_SESSION["user"]["headshots"] ?>"
                                     alt="<?= $_SESSION["user"]["headshots"] ?>">
                            <?php endif; ?>
                        </a>
                        <a class="mb-0 text-secondary text-decoration-none" href="dashboard.php"><?= $_SESSION["user"]["account"] ?></a>
                        <a href="logOut.php" class="btn btn-info text-white ms-4">登出</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!--header-->

<div class="container px-4 mt-4">
    <div class="row g-3 menu">
        <!--左邊選單-->
        <div class="col-md-3">
            <div class="p-5 bg-light menu">
                <figure class="d-flex align-items-center">
                    <a class="headshot" href="dashboard.php">
                        <?php if($_SESSION["user"]["headshots"]==NULL):?>
                        <img class="cover-fit" src="./upload/user.png" alt="user.png">
                        <?php else:?>
                        <img class="cover-fit" src="./upload/<?= $_SESSION["user"]["headshots"] ?>"
                             alt="<?= $_SESSION["user"]["headshots"] ?>">
                        <?php endif; ?>
                    </a>
                    <p class="mb-0 ms-3 text-secondary"><?= $_SESSION["user"]["account"] ?></p>
                </figure>
                <ul class="p-0 mt-4">
                    <li class="myList"><a href="./dashboard.php">修改個人資訊</a></li>
                    <li class="myList"><a href="./user-order-list.php">我的訂單</a></li>
                    <li class="myList"><a href="./user-coupon-list.php">我的優惠券</a></li>
                </ul>
            </div>
        </div>
        <!--左邊選單-->
        <!--右邊內容欄位-->
        <div class="col-md-9">
            <div class="p-5 bg-light menu">
                修改個人資訊
                <hr>
                <?php if ($userExist === 0): ?>
                    使用者不存在
                <?php else:
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <form action="doUpdate.php" method="post" class="mt-3" enctype="multipart/form-data">
                        <div class="row gt-3">
                            <div class="col-lg-7 pe-5 mt-3">
                                <input type="hidden" name="id" value="<?= $row["id"] ?>"> <!--隱藏-->
<!--                                <div class="mb-3 d-flex align-items-center text-nowrap">-->
<!--                                    <label for="account" class="me-4 col-sm-2">使用者帳號</label>-->
<!--                                    <input id="account" type="text" name="account" class="form-control-plaintext"-->
<!--                                           value="   --><?//= $row["account"] ?><!--" readonly>-->
<!--                                </div>-->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center text-nowrap">
                                        <label for="name" class="me-4 col-sm-2">姓名</label>
                                        <input id="name" type="text" name="name" class="form-control"
                                               value="<?= $row["name"] ?>" placeholder="中文 / 英文姓名">
                                    </div>
                                    <div class="error text-danger text-end"></div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex align-items-center text-nowrap">
                                        <label for="email" class="me-4 col-sm-2">Email</label>
                                        <input id="email" type="text" name="email" class="form-control"
                                               value="<?= $row["email"] ?>" placeholder="name@example.com">
                                    </div>
                                    <div class="error text-danger text-end"></div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex align-items-center text-nowrap">
                                        <label for="phone" class="me-4 col-sm-2">手機號碼</label>
                                        <input id="phone" type="text" name="phone" class="form-control"
                                               value="<?= $row["phone"] ?>" placeholder="09xxxxxxxx">
                                    </div>
                                    <div class="error text-danger text-end"></div>
                                </div>
                                <div class="mb-4 d-flex align-items-center text-nowrap">
                                    <label for="password" class="me-4 col-sm-2">密碼</label>
                                    <input id="password" type="password" name="password" class="form-control ps-3"
                                           value="<?= $_SESSION["user"]["password"] ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center text-nowrap">
                                        <label for="newPassword" class="me-4 col-sm-2">更改密碼</label>
                                        <input id="newPassword" type="password" name="newPassword" class="form-control ps-3"
                                               placeholder="至少5字，需有大小寫字母和數字，可以有特殊符號">
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between text-nowrap ms-5">
                                        <div class="d-flex align-items-center p-1 ms-5">
                                            <input type="checkbox" id="showPassword"><span class="show-password ms-2">顯示密碼</span>
                                        </div>
                                        <div id="passwordError" class="error text-danger text-end d-float"></div>
                                    </div>
                                </div>
                                <div class="mb-3 d-flex align-items-center text-nowrap">
                                    <label for="address" class="me-4 col-sm-2">地址</label>
                                    <input id="address" type="text" name="address" class="form-control"
                                           value="<?= $row["address"] ?>">
                                </div>
                                <button class="btn btn-secondary" type="submit">儲存</button>
                            </div>
                            <div class="col-lg-5 px-5 mt-4 border-left">
                                <div class="headshot-big d-block">
                                    <?php if($row["headshots"]==NULL):?>
                                    <img class="cover-fit" src="./upload/user.png" alt="user.png">
                                    <?php else: ?>
                                    <img class="cover-fit" src="./upload/<?= $row["headshots"] ?>" alt="<?= $row["headshots"] ?>">
                                    <?php endif; ?>
                                </div>
                                <input class="mt-3 form-control form-control-sm" type="file" name="myFile" accept=".jpg,.jpeg,.png">
                                <div class="text-muted mt-3">檔案大小: 最大 1 MB</div>
                                <div class="text-muted">檔案限制: .JPG .JPEG, .PNG</div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!--右邊內容欄位-->
    </div>
</div>


<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script>
    //預覽上傳的圖片
    // $('input[type="file"]').prop('myFile',e.originalEvent.dataTransfer.files);


    // var reader = new FileReader();
    // reader.readAsDataURL(fileData);
    //
    // $("#upload").change(function(e){
    //     var fileData = e.target.files[0]
    //     //讀取檔案內容
    //     var reader = new FileReader();
    //     reader.readAsDataURL(fileData);
    //     reader.addEventListener("load",function(event){
    //         $("#show").append(`<img class="thumb" src="${event.target.result}">`);
    //     });
    // });

    //顯示密碼
    $(":checkbox").click(function(){
        if($(this).is(":checked")==true){
            $("#newPassword").attr("type", "text");
        }else{
            $("#newPassword").attr("type", "password");
        }
    });


    //姓名驗證: 只能全中文/英文
    const reName = /^[\u4e00-\u9fa5]+$|^[a-zA-Z\s]+$/;
    $("#name").blur(function () {
        if (reName.test($("#name").val())) {
            $(this).parent().next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            $(this).parent().next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });


    //電子信箱格式檢查
    // const reEmail = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    const reEmail = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
    $("#email").blur(function () {
        if (reEmail.test($("#email").val())) {
            $(this).parent().next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            $(this).parent().next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });


    //手機號碼格式檢查
    const rePhone = /^09\d{8}$/;  //09開頭，數字{8次}，$代表字元結尾
    $("#phone").blur(function () {
        if (rePhone.test($("#phone").val())) {
            // alert("符合規則");
            $(this).parent().next(".error").text("");
            $(this).removeClass("border-danger");
        } else {
            // alert("不符合規則");
            $(this).parent().next(".error").text("輸入格式有誤");
            $(this).addClass("border-danger");
        }
    });


    // 密碼檢查
    // 5位數以上，並且至少包含 大寫字母、小寫字母、數字 各一，可以有特殊符號
    const rePassword=/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{5,}$/;
    $("#newPassword").blur(function () {
        if($("#newPassword").val()==""){
            $("#passwordError").text("");
            $(this).removeClass("border-danger");
        }else {
            if (rePassword.test($("#newPassword").val())) {
                $("#passwordError").text("");
                $(this).removeClass("border-danger");
            } else {
                $("#passwordError").text("輸入格式有誤");
                $(this).addClass("border-danger");
            }
        }
    });



    //資料輸入格式有誤，不能送出修改
    $("button[type='submit']").click(function () {
        if ($("#name").hasClass("border-danger") || $("#account").hasClass("border-danger") || $("#email").hasClass("border-danger") || $("#newPassword").hasClass("border-danger") || $("#phone").hasClass("border-danger")) {
            alert("輸入格式有誤，無法儲存資料");
            return false;
        }else if ($("#name").val()=="" || $("#account").val()=="" || $("#email").val()=="" || $("#password").val()=="" || $("#phone").val()=="" ){
            alert("輸入內容不完整，無法儲存資料");
            return false;
        }else{
            alert("修改個人資訊成功");
        }

        // console.log("click");
        // console.log($("#name").hasClass("border-danger") || $("#account").hasClass("border-danger") || $("#email").hasClass("border-danger") || $("#password").hasClass("border-danger") || $("#phone").hasClass("border-danger"));
    });




</script>


</body>
</html>