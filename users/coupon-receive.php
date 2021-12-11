<?php

require_once("../pdo-connect.php");

if (!isset($_SESSION["user"])) { 
    header("location: users-login.php");
}
//取優惠券內容
$sqlcoupon = "SELECT * FROM coupon WHERE  valid=1 ";
$stmtcoupon = $db_host->prepare($sqlcoupon);
try {
    $stmtcoupon->execute();

    $userExist = $stmtcoupon->rowCount();

} catch (PDOException $e) {
    echo $e->getMessage();
}
//取使用者優惠券欄位
$sql = "SELECT * FROM users WHERE id=?  AND valid=1 ";
$stmt = $db_host->prepare($sql);
try {
    $stmt->execute([$_SESSION["user"]["id"]]);
    $usersCount=$stmt->fetch();
    $userExist = $stmt->rowCount();
   
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>優惠券領取</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<style>
    :root {
  --green: #66806A;
  --lightgreen: #7baa81;
  --yellow: #ffc107;
}
    .top{
        box-shadow: 0rem 0.1rem 0.2rem #ddd;
    }
    .coupon-card{
        border-radius: 1.5rem;
    }
    .coupon{
        background-color:var(--lightgreen);
        text-align: center;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
    }
    .coupon-top-text{
        color: white;
    }
    .coupon-title{
        color: white;
        font-weight: 900;
        font-size: 3rem;
    
    }
    .coupon-down-text{
        color: #4d6d52;
        border-top:1.5px solid #4d6d52;
        border-bottom:1.5px solid #4d6d52;
        width: 40%;
    }
    .coupon-main-center{
        color: rgb(46, 46, 46);
        font-weight: bold;
    }
    .coupon-BTN{
        background-color: #7baa81;
        border: none;
    }
    .coupon-BTN:hover{
        background-color: #66806A;
        border: none;
    }
    .coupon-BTN-close{
        background-color: #ccc;
        border: none;
        color:rgb(46, 46, 46);
        font-weight: bold;
    }
</style>
<body>
<header class="bg-light top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="./index.php">team01</a>
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
                            <a class="nav-link " href="#" tabindex="-1" aria-disabled="true">優惠券領取</a></a>
                        </li>
                    </ul>
                    <form class="d-flex">
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
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="container pt-5">
        <div class="row">
            <?php while($couponCount=$stmtcoupon->fetch()):?>
            <div class="col-12 col-md-6 col-lg-3 mx-auto pt-5">
                <div class="card  coupon-card" >
                    <div class="coupon m-0 ">
                        <p class="coupon-top-text m-0 pt-4">OFF COUPON</p>
                        <p class="coupon-title m-0">$<?=$couponCount['amount']?></p>
                        <div class="pb-4 pt-1">
                            <p class="coupon-down-text mx-auto m-0 ">
                                Coupon
                                <br>
                                Dicsount
                            </p>
                        </div>
                    </div>
                    <form action="./couponUserAdd.php" method="POST">
                    <div class="card-body text-center  py-3">
                      <h5 class="card-title text-start coupon-main-center"  >NT$<?=$couponCount['amount']?>優惠券</h5>
                      <p class="card-text text-start coupon-main-center"><?=$couponCount['text']?></p>
                      <p class="card-text text-start coupon-main-center" >剩餘數量:<?=$couponCount['quantity']?></p>

                      <input type="hidden" name="couponid" value=<?php echo $couponCount['id'] ?>>
                      <input type="hidden" name="amount" value=<?php echo $couponCount['amount'] ?>>
                      <input type="hidden" name="quantity" value=<?php echo $couponCount['quantity'] ?>>
                      
                     
                      <?php if( $couponCount['quantity'] <=0):?>
                      <p  class="btn  text-center px-5 coupon-BTN-close">已兌換完畢</p>
                      <?php elseif(empty($usersCount['coupon_id'])):?>
                        <button  type="submit" class="btn btn-primary text-center px-5 coupon-BTN">領取</button>
                      <?php else: ?>
                        <p  class="btn  text-center px-5 coupon-BTN-close">只能領取一張呦</p>
                      <?php endif ;?>
                    </div>
                    </form>
                  </div>
            </div>
            <?php endwhile ?>
    
        

        
    </div>
</main>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>