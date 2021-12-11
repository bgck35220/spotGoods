<?php
require_once("pdo-connect.php");


?>
<!doctype html>
<html lang="en">
<head>
    <title>Team 01</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--將css獨立用php連結-->
    <?php require_once("css.php") ?>
    <style>
        .box{
            height: 550px;
        }
        .text{
            color: rgba(203, 203, 203, 0.4);
            font-size: 50px;
        }
    </style>

</head>
<body>
<header class="bg-light top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="#">team01</a>
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
                    <form class="d-flex align-items-center">
                        <?php if(isset($_SESSION["user"])): ?>
                        <a class="headshot-sm me-2" href="dashboard.php">
                            <?php if($_SESSION["user"]["headshots"]==NULL):?>
                                <img class="cover-fit" src="./upload/user.png" alt="user.png">
                            <?php else:?>
                                <img class="cover-fit" src="./upload/<?= $_SESSION["user"]["headshots"] ?>"
                                     alt="<?= $_SESSION["user"]["headshots"] ?>">
                            <?php endif; ?>
                        </a>
                        <a class="mb-0 text-secondary text-decoration-none" href="dashboard.php"><?= $_SESSION["user"]["account"] ?></a>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link ms-3" aria-current="page" href="./logOutToIndex.php">登出</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="../sellers/sellersApply.php">店家申請</a>
                            </li>
                        </ul>
                        <?php else: ?>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="users-login.php">會員登入</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="../sellers/sellersApply.php">店家申請</a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>

<div class="container">
    <div class="d-flex justify-content-center align-items-center p-5 box">
        <h1 class="text">TEAM 01</h1>
    </div>
</div>

<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>