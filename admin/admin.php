<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location:adminLogin.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <title>管理員後台</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<style>
    :root {
        --green: #66806A;
        --lightgreen: #7baa81;
        --yellow: #ffc107;
    }

    .nav-bar-title {
        background-color: var(--green);
        box-shadow: 0rem .1rem .5rem #aaa;
    }

    .nav-text {
        /* font-size: 1.1rem; */
        font-weight: 450;
        margin: 0 10px;
    }

    .title-regis {
        /* font-size: 1.1rem; */
        padding: 8px;
    }

    .customer-message {
        position: fixed;
        bottom: 25px;
        right: 5px;
        width: 120px;
        background-color: white;
    }

    .customer-message-span {
        background-color: var(--lightgreen);
        color: white;
    }

    /* .dropdown-item:focus {
        background-color: #66806A;
        color: white;
    } */
    .dropdown-item {
        font-size: .9rem;
    }
</style>

<body>



    <header class="container-fluid nav-bar-title py-2 sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand fs-5 text-light ms-3 me-5" href="#">TEAM 1 管理員後台</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    會員管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item " href="#">會員總覽</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    店家管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">店家申請</a></li>
                                    <li><a class="dropdown-item" href="./login.php">店家總覽</a></li>
                                    <li><a class="dropdown-item" href="#">新增店家資料</a></li>

                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    訂單管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="./login.php">訂單總覽</a></li>

                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    兌換券管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="./login.php">新增兌換券</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div>

                <div class="title-regis">
                    <ul class="navbar-nav">
                        <li class="nav-item d-flex align-items-center">
                            <p class="nav-link m-0 me-4 text-light d-block" aria-current="page" href="#">管理員:<?= $_SESSION['user']['name'] ?></p>
                            <a href="./logOut.php" type="button" class="btn btn-warning">登出</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </header>


    <!-- 主要內容 -->
    <main>
        <div class="container pt-5 ">
            <div>
            <h2 class="fs-3">會員管理</h2>
    
            </div>
       
            <table class="table  table-striped ">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>姓名</th>
                        <th>帳號</th>
                        <th>信箱</th>
                        <th>註冊時間</th>
                        <th>狀態</th>
                        <th></th>
                    </tr>
               
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>123456789abcdefg</td>
                        <td>123456789</td>
                        <td>12345678789@11234.123</td>
                        <td>2021/12/03 00:00:00</td>
                        <td>啟用中</td>
                        <td class="">
                        <a href="" class="btn btn-outline-success">詳細資訊</a>
                            <a href="" class="btn btn-outline-secondary">編輯資訊</a>
                            <button class="btn btn-outline-danger">停用</button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>1</td>
                        <td>123456789</td>
                        <td>12389</td>
                        <td>12345678789@11234.123</td>
                        <td>2021/12/03 00:00:00</td>
                        <td>停用中</td>
                        <td class="">
                        <a href="" class="btn btn-outline-success">詳細資訊</a>
                            <a href="" class="btn btn-outline-secondary">編輯資訊</a>
                            <button class="btn btn-outline-primary">啟用</button>
                        </td>
                    </tr>
                </tbody>
                </thead>
            </table>
        </div>
    </main>




    <!-- 即時客服 -->
    <div class="customer-message">
        <button type="button" class="btn btn-success position-relative">
            客戶訊息
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill customer-message-span">
                99+
                <span class="visually-hidden">unread messages</span>
            </span>
        </button>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>