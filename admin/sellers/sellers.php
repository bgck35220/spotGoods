<?php
require_once("../../pdo-connect.php");
if (!isset($_SESSION["user"])) {
    header("location:admin-Login.php");
};

//總筆數
$sqlTotal = "SELECT * FROM sellers WHERE valid = 1 OR valid = 0";
$stmtTotal = $db_host->prepare($sqlTotal);

try {
    $stmtTotal->execute();
    $totalUsersCount = $stmtTotal->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}
//店家資料彈跳式窗
if (isset($_GET['sellertable'])) {
    $id = $_GET['sellertable'];
    $sqlUsreTable = "SELECT * FROM sellers WHERE id = ?";
    $stmtUserTable = $db_host->prepare($sqlUsreTable);

    try {
        $stmtUserTable->execute([$id]);
        $rowUserUserTable = $stmtUserTable->fetch();
        $userExistUserTable = $stmtUserTable->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
};


if (isset($_GET['search'])) {
    //搜尋店家帳號和電子信箱功能
    $search = $_GET['search'];
    $sqlUser = "SELECT * FROM sellers WHERE bossname like '%$search%' AND valid <= 1 OR account LIKE '%$search%' AND valid <= 1 OR  name LIKE '%$search%' AND valid <= 1";
} else {
    //分頁功能
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
    } else {
        $p = 1;
    }

    $pageItems = 10; //一頁10個
    $startItem = ($p - 1) * $pageItems; //求出LIMIT第一個數字
    $pageConet = $totalUsersCount / $pageItems; //總筆數除一頁10個 = 總頁數
    $pageR = $totalUsersCount % $pageItems; // 總筆數除一頁顯示數量 如果有餘數代表他是下一頁
    $starNo = ($p) * $pageItems - 9;
    $starEnd = $pageItems * ($p);
    if ($pageR !== 0) {
        $pageConet = ceil($pageConet); //總頁數餘數不為0 讓他無條件進位

        if ($pageConet == $p) {
            $starEnd = $starEnd - ($pageItems - $pageR);
        }
    }
    $sqlUser = "SELECT * FROM sellers WHERE valid=1 or valid = 0 ORDER BY id LIMIT $startItem,$pageItems";

    $stmtUser = $db_host->prepare($sqlUser);
}


$stmtUser = $db_host->prepare($sqlUser);
try {
    $stmtUser->execute();
    // $rowUser=$stmtUser->fetch();
    $totalUsersCounta = $stmtUser->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}





?>
<!doctype html>
<html lang="en">

<head>
    <title>管理員後台-店家總覽</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style1.css">
</head>

<body>



    <header class="container-fluid nav-bar-title py-2 sticky-top header-nav">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand fs-5 text-light ms-3 me-5" href="../admin.php">TEAM 1 管理員後台</a>
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
                                    <li><a class="dropdown-item " href="../admin.php">會員總覽</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    店家管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="./sellers-check.php">店家申請</a></li>
                                    <li><a class="dropdown-item" href="./sellers.php">店家總覽</a></li>
                                    <li><a class="dropdown-item" href="./seller-add.php">新增店家資料</a></li>

                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    訂單管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="../order/orders-list.php">訂單總覽</a></li>

                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                優惠券管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="../coupon/coupon.php">優惠券總覽</a></li>
                                </ul>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="./login.php">新增優惠券</a></li>

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
                            <a href="logOut.php" type="button" class="btn btn-warning">登出</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </header>


    <!-- 主要內容 -->

    <main>
        <?php $validone = 0; ?>
        <div class="container pt-5 ">

            <table class="table  table-striped ttbb">
                                  
                <thead>
              
                     <div>
                        <h2 class="subtitle">店家總覽</h2>
                    </div>
                    <?php if (isset($p)) : ?>
                        <div class="py-2">共<?= $totalUsersCount ?>位店家
                        <br>
                        <br>
                        此頁顯示第<?= $starNo ?>~<?= $starEnd ?>筆 </div>
                    <?php else : ?>
                        <div class="py-2">
                            共<?= $totalUsersCounta ?>筆資料
                        </div>
                    <?php endif; ?>

                    <tr class="">
                        <th>id</th>
                        <th>店家聯絡人</th>
                        <th>店家名稱</th>
                        <th>帳號</th>
                        <th>註冊時間</th>
                        <th>帳號狀態</th>
                        <th>
                            <form action="./sellers.php" method="GET">
                                <div class="input-group  search-user">
                                    <input type="search" class="form-control" placeholder="搜尋聯絡人、店家名稱、帳號" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" value=<?php if (isset($search)) echo $search ?>>
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">搜尋</button>
                                </div>
                            </form>
                        </th>
                    </tr>

                <tbody class="">
                    <?php while ($rowUser = $stmtUser->fetch()) :
                    ?>


                        <tr class="table-text-all">
                            <td>
                            <a class="text-decoration-none text-dark d-flex" href="./sellers.php?sellertable=<?= $rowUser['id'] ?><?php
                                if (isset($p)) echo "&p=$p";
                                if (isset($search)) echo "&search=$search";
                                ?>" type="submit">
                                <?= $rowUser['id'] ?>
                                <img class="magnifier-img" src="../img/search-solid.svg" alt="">
                                </a>
                            </td>
                            <td><?= $rowUser['bossname'] ?></td>
                            <td class="">
                               
                                    <?= $rowUser['name'] ?>
                                   
                            </td>
                            <td><?= $rowUser['account'] ?></td>
                            <td><?= $rowUser['created_at'] ?></td>
                            <td>
                                <?php if ($rowUser['valid'] == 1) : ?>
                                    <p class="m-0 text-primary">啟用</p>
                                <?php endif; ?>
                                <?php if ($rowUser['valid'] == 0) : ?>
                                    <p class="m-0 text-danger">停用</p>
                                <?php endif; ?>
                            </td>
                            <td class="">
                                <a href="seller.php?id=<?= $rowUser['id'] ?>" class="btn btn-outline-secondary" type="submit">詳細資訊</a>
                                <a href="./seller-update.php?id=<?= $rowUser['id'] ?>" class="btn btn-outline-secondary">編輯</a>


                                <?php if ($rowUser['valid'] == 1) :
                                    $validone += 1;
                                ?>
                                    <?php if (isset($search)) : ?>
                                        <a class="btn btn-outline-danger" href="sellers.php?id=<?= $rowUser['id'] ?>&valid=<?= $rowUser['valid']; ?>&search=<?= $search ?>" id="user-close"> 停用</a>
                                    <?php elseif (isset($p)) : ?>
                                        <a class="btn btn-outline-danger" id="user-open" href="sellers.php?id=<?= $rowUser['id'] ?>&valid=<?= $rowUser['valid']; ?>&p=<?= $p ?>">停用</a>
                                    <?php else : ?>
                                        <a class="btn btn-outline-danger" href="sellers.php?id=<?= $rowUser['id'] ?>&valid=<?= $rowUser['valid']; ?>" id="user-close"> 停用</a>
                                    <?php endif; ?>

                                <?php elseif (($rowUser['valid'] == 0)) : ?>

                                    <?php if (isset($search)) : ?>
                                        <a class="btn btn-outline-primary" id="user-open" href="sellers.php?id=<?= $rowUser['id'] ?>&valid<?= $rowUser['valid']; ?>&search=<?= $search ?>">啟用</a>
                                    <?php elseif (isset($p)) : ?>
                                        <a class="btn btn-outline-primary" id="user-open" href="sellers.php?id=<?= $rowUser['id'] ?>&p=<?= $p ?>">啟用</a>
                                    <?php else : ?>
                                        <a class="btn btn-outline-primary" id="user-open" href="sellers.php?id=<?= $rowUser['id'] ?>&valid<?= $rowUser['valid']; ?>">啟用</a>
                                    <?php endif; ?>
        </div>
    <?php endif; ?>
    </td>
    </tr>

<?php endwhile; ?>


<!-- 跳出視窗區塊 -->
<?php if (isset($_GET['id']) && (isset($_GET['valid'])) == "1") : ?>
    <div class="colseblcok  ">

        <!-- 停用確認 -->
        <div class="full-screen full-close " id="user-switch">
            <div class="close">
                <div class="d-flex justify-content-end">
                    <a class=" btn closeX" id="closeX" href="sellers.php
                    <?php
                    if (isset($search)) echo "?search=$search";
                    if (isset($p)) echo "?p=$p"; ?>">X
                    </a>
                </div>
                <div class="closeText ">確定要停用帳號嗎?</div>
                <div class="d-flex justify-content-center">
                    <a type="submit" href="sellerDelete.php?id=<?= $_GET['id'] ?><?php
                    if (isset($p)) {
                    echo "&p=$p";
                    } else if (isset($search)) {
                    echo "&search=$search";
                    };
                    ?>" class="btn btn-danger closeCheck">確定</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- 啟用確認 -->
<?php if (isset($_GET['id']) && (isset($_GET['valid'])) == "0") : ?>
    <div class="openblcok">
        <div class="full-screen openFullScreen" id="user-switch">
            <div class="close">
                <div class="d-flex justify-content-end ">
                    <a class=" btn closeX" id="closeX" href="sellers.php
                    <?php if (isset($search)) echo "?search=$search";
                    if (isset($p)) echo "?p=$p"; ?>">X</a>
                </div>
                <div class="closeText">確定要啟用帳號嗎?</div>
                <div class="d-flex justify-content-center">
                    <a href="sellerOpen.php?id=<?= $_GET['id'] ?><?php
                                                                if (isset($p)) {
                                                                    echo "&p=$p";
                                                                } else if (isset($search)) {
                                                                    echo "&search=$search";
                                                                };  ?>
                    " type="submit" class="btn btn-primary closeCheck">確定</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>



    </tbody>
    </thead>
    </table>
    <!-- 頁數 -->
     <?php if (isset($p)) : ?>
        <nav aria-label="Page navigation example p" class="">
            <ul class="pagination  justify-content-center">
                <?php for ($i = 1; $i <= $pageConet; $i++) : ?>
                    <li class="page-item page-nav <?php if ($p == $i) echo 'active' ?>">
                        <a class="page-link" href="http://localhost/spotGoods/admin/sellers/sellers.php?p=<?= $i ?>"><?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif ?>
    </div> 

    <!-- 點帳號直接顯示詳細資訊                   -->
    <?php if (isset($_GET['sellertable']) && $userExistUserTable > 0) : ?>
        <div class="col-3 user-table ">
            <table class="table table-bordered  m-auto user-table-text  ">
                <tr>
                    <th>id</th>
                    <td><?= $rowUserUserTable['id'] ?>
                        <a class="user-table-btn-close" href="./sellers.php?<?php
                        if (isset($p)) echo "&p=$p";
                        if (isset($search)) echo "&search=$search";
                        ?>">X
                        </a>
                    </td>
                </tr>

                <tr>
                    <th>店家聯絡人</th>
                    <td><?= $rowUserUserTable['bossname'] ?></td>
                </tr>
                <tr>
                    <th>信箱</th>
                    <td><?=$rowUserUserTable['email']?></td>
                </tr>
                <tr>
                    <th>帳號</th>
                    <td><?=$rowUserUserTable['account']?></td>
                </tr>
           
       
                <tr>
                    <th>手機號碼</th>
                    <td><?=$rowUserUserTable['phone']?></td>
                </tr>
                <tr>
                    <th>地址</th>
                    <td><?=$rowUserUserTable['address']?></td>
                </tr>
                <tr>
                    <th>營業登記證</th>
                    <td><a class="text-decoration-none"href="../../sellers/sellersimg/sellersimg<?=$rowUserUserTable['certification_imgname']?>">營業登記證</td>
                </tr>
              
                <tr>
                    <th>註冊時間</th>
                    <td><?= $rowUserUserTable['created_at'] ?></td>
                </tr>
                <tr>
                    <th>帳號狀態</th>
                    <td><?php if ($rowUserUserTable['valid'] == 1) {
                            echo "啟用";
                        } else {
                            echo "停用";
                        }

                        ?></td>

                </tr>

            </table>
        </div>
    <?php endif ?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let userTable = document.querySelector(".user-table")
        userTable.addEventListener("click", (e) => {
            if (e.target.nodeName === "DIV") {
                userTable.classList.toggle("d-none")
            }
        })
    </script>

</html>