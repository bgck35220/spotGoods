<?php
require_once("../pdo-connect.php");

if (!isset($_SESSION["user"])) {
    header("location:adminLogin.php");
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    header("location:admin.php");
}

$sqlUser = "SELECT * FROM users WHERE id = ?";
$stmtUser = $db_host->prepare($sqlUser);

try {
    $stmtUser->execute([$id]);
    $rowUser=$stmtUser->fetch();
    $userExist = $stmtUser->rowCount();

} catch (PDOException $e) {
    echo $e->getMessage();
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
    <link rel="stylesheet" href="./css/style.css" >
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
/* 
    .dropdown-item:focus {
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
                    <a class="navbar-brand fs-5 text-light ms-3 me-5" href="./admin.php">TEAM 1 管理員後台</a>
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
                                    <li><a class="dropdown-item " href="./admin.php">會員總覽</a></li>
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
                            <a href="logout.php" type="button" class="btn btn-warning">登出</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </header>


    <!-- 主要內容 -->
    <main>
        <div class="container pt-5 col-4">
            <div class="d-flex justify-content-between">
                <div>
                    <h2 class="fs-3">會員資料編輯</h2>
                </div>
                <div class="d-flex ">
                    <div class="me-2">
                        <a href="./user.php?id=<?=$rowUser['id']?>" class="btn btn btn-secondary" type="submit">
                            詳細資訊
                        </a>
                    </div>
                    <div>
                    <a href="./admin.php" class="btn btn-light" type="submit">
                        首頁
                    </a>
                    </div>
                </div>
            </div>

            <?php if($userExist>0):?>
            <form action="doUpdate.php" method="POST">
            <table class="table table-bordered  updateTable ">
                <tr class="">
                    <th>id</th>
                    <td class="p-1"> <input type="text" value="<?=$rowUser['id']?>" class="form-control p-2 m-0"  placeholder="id" name="id" disabled ></td>
                </tr>
                <tr>
                    <th>姓名</th>
                    <td class="p-1"> <input type="text" value="<?=$rowUser['name']?>" class="form-control p-2 m-0"  placeholder="name" name="name"  ></td>
                </tr>
                <tr>
                    <th>帳號</th>
                    <td class="p-1"> <input type="text" value="<?=$rowUser['account']?>" class="form-control p-2 m-0"  placeholder="account" name="account"  disabled></td>
                </tr>
                <tr>
                    <th>信箱</th>
                    <td class="p-1"> <input type="text" value="<?=$rowUser['email']?>" class="form-control p-2 m-0"  placeholder="email" name="email"  ></td>
                </tr>
                <tr>
                    <th>地址</th>
                    <td class="p-1"> <input type="text" value="<?=$rowUser['address']?>" class="form-control p-2 m-0"  placeholder="address" name="address"  ></td>
                </tr>
                <tr>
                    <th>手機號碼</th>
                    <td>待新增</td>
                </tr>
                <tr>
                    <th>註冊時間</th>
                    <td class="p-1"> <input type="text" value="<?=$rowUser['created_at']?>" class="form-control p-2 m-0"  placeholder="created_at" name="created_at"  disabled></td>
                </tr>
                <tr>
                    <th>帳號狀態</th>
                    <td class="user-switch"><?php if($rowUser['valid'] == 1){?>
                        啟用
                        <a class="btn btn-outline-danger " type="submit">停用</a>
                        
                        <?php }else if($rowUser['valid'] == 0){ ?>
                        停用
                        <a class="btn btn-outline-primary" type="submit">啟用</a>
                        <?php }; ?>
                    </td>

                </tr>
         
                   <?php endif; ?>

            </table>
            <a type="submit" href="./"class="btn btn-outline-dark w-100">送出</a>
            </form>
        </div>
    </main>




    <!-- 即時客服 -->
    <!-- <div class="customer-message">
        <button type="button" class="btn btn-success position-relative">
            客戶訊息
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill customer-message-span">
                99+
                <span class="visually-hidden">unread messages</span>
            </span>
        </button>
    </div> -->

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>