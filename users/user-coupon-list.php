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
    echo "預處理陳述式執行失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    $db_host = NULL;
    exit;
}


$sqlCoupon = "SELECT coupon.*, users.id AS users_id
FROM coupon
JOIN users ON users.id = coupon.user_id
WHERE coupon.user_id=? AND coupon.valid=1";
$stmtCoupon = $db_host->prepare($sqlCoupon);
try{
    $stmtCoupon->execute([$_SESSION["user"]["id"]]);


} catch (PDOException $e) {
    echo "預處理陳述式執行失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    $db_host = NULL;
    exit;
}


?>

<!doctype html>
<html lang="en">
<head>
    <title>我的優惠券</title>
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
            --green: #66806A;
            --lightgreen: #7baa81;
            --yellow: #ffc107;
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
        .couponCard{
            width: 50%;
        }
        .coupon-card{
            border-radius: 0.5rem;
            overflow: hidden;
            background: white;
            box-shadow: 0rem 0.1rem 0.2rem #ddd;
        }
        .coupon{
            background-color:var(--lightgreen);
            text-align: center;
            width: 50%;
        }
        .coupon-top-text{
            color: white;
        }
        .coupon-title{
            color: white;
            font-weight: 900;
            font-size: 3rem;

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
                我的優惠券
                <hr>
                <div class="container">
                    <div class="row">
                        <?php while($couponCount=$stmtCoupon->fetch()):?>
                            <div class="col-3 couponCard mt-3">
                                <div class="coupon-card d-flex">
                                    <div class="coupon m-0 py-4 px-3">
                                        <p class="coupon-title m-0">$<?=$couponCount['amount']?></p>
                                        <p class="coupon-top-text m-0">OFF COUPON</p>
                                    </div>
                                    <div class="py-4 px-3">
                                        <h5 class="card-title text-start">NT$ <?=$couponCount['amount']?> 優惠券</h5>
                                        <p class="card-text text-start text-secondary"><?=$couponCount['text']?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
            </div>
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

</script>


</body>
</html>