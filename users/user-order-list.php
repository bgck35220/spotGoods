<?php
require_once("pdo-connect.php");
//一定要使用者頁面登入才能用的話，加入此判斷有沒有權限，沒登入成功就無法使用功能
if (!isset($_SESSION["user"])) {  //導進來頁面 先檢查存不存在
    header("location: sign-in.php");
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
    <title>user order</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--將css獨立用php連結-->
    <?php require_once("css.php") ?>

</head>
<body>

<!--header-->
<header class="bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="index.php">team01</a>
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
                    <li class="myList"><a href="dashboard.php">修改個人資訊</a></li>
                    <li class="myList"><a href="user-order-list.php">我的訂單</a></li>
                    <li class="myList"><a href="">兌換券</a></li>
                </ul>
            </div>
        </div>
        <!--左邊選單-->
        <!--右邊內容欄位-->
        <div class="col-md-9">
            <div class="bg-light status d-flex justify-content-between">
                <a href="user-order-list.php?status=1" class="active">全部</a>
                <a href="">待付款</a>
                <a href="">待出貨</a>
                <a href="">完成</a>
                <a href="">已取消</a>
            </div>
            <!--搜尋-->
            <div class="my-3">
                <form action="user-order-list.php" method="get">
                    <div class="d-flex align-items-center">
                        <input type="search" class="form-control me-2" placeholder="您可以透過...進行搜尋" name="s" value="<?php if (isset($search))echo $search; ?>">
                        <button type="submit" class="btn btn-outline-secondary text-nowrap">搜尋</button>
                    </div>
                </form>
            </div><!--搜尋-->
            <div class="card my-3">
                <div>賣家名稱</div>

            </div>
        </div><!--右邊內容欄位-->
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
</script>


</body>
</html>