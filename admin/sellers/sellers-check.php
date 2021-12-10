<?php
require_once("../../pdo-connect.php");
if (!isset($_SESSION["user"])) {
    header("location:admin-Login.php");
};

//總筆數
$sqlTotal = "SELECT * FROM sellers WHERE valid = 2 ";
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
    $sqlUsreTable = "SELECT * FROM sellers WHERE id = ?  ";
    $stmtUserTable = $db_host->prepare($sqlUsreTable);

    try {
        $stmtUserTable->execute([$id]);
        $rowUserUserTable = $stmtUserTable->fetch();
        $userExistUserTable = $stmtUserTable->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
};


if (!empty($_GET['search'])) {
    //搜尋店家帳號和電子信箱功能
    $search = $_GET['search'];
    $sqlUser = "SELECT * FROM sellers WHERE id like '%$search%' AND valid >= 2 OR account LIKE  ' %$search%' AND valid >= 2 OR  name LIKE '%$search%' AND valid >= 2";
}else if (isset($_GET['order'])) {
    //審查 駁回 篩選
    $order = $_GET['order'];
    if ($order === 'refuse') {
        $sqlUser = "SELECT * FROM sellers WHERE valid=3 ORDER BY id ";
    }
    if ($order === 'wait') {
        $sqlUser = "SELECT * FROM sellers WHERE valid=2  ORDER BY id";
    }
} else {
    //分頁功能
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
    } else {
        $p = 1;
    }

    $pageItems = 10;
    $startItem = ($p - 1) * $pageItems; 
    $pageConet = $totalUsersCount / $pageItems; 
    $pageR = $totalUsersCount % $pageItems; 
    $starNo = ($p) * $pageItems - 9;
    $starEnd = $pageItems * ($p);
    if ($pageR !== 0) {
        $pageConet = ceil($pageConet); 

        if ($pageConet == $p) {
            $starEnd = $starEnd - ($pageItems - $pageR);
        }
    }
    $sqlUser = "SELECT * FROM sellers WHERE valid= 2 ORDER BY id LIMIT $startItem,$pageItems";

    $stmtUser = $db_host->prepare($sqlUser);
}


$stmtUser = $db_host->prepare($sqlUser);
try {
    $stmtUser->execute();
    // $rowUser=$stmtUser->fetch();
    $userExist = $stmtUser->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}





?>
<!doctype html>
<html lang="en">

<head>
    <title>管理員後台-店家申請</title>
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
                                    兌換券管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="../coupon/coupon.php">兌換券總覽</a></li>
                                    <li><a class="dropdown-item" href="../coupon/coupon-add.php">新增兌換券</a></li>
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
                <!-- table 標題 -->
                <div>
                    <h2 class="subtitle">店家申請</h2>
                </div>
        
                <?php if (isset($p)) : ?>
                        <div class="py-2">
                            共<?= $totalUsersCount ?>筆
                        </div>
                        <div class="py-2">此頁顯示第<?= $starNo ?>~<?= $starEnd ?>筆
                    <?php else : ?>
                        <div class="py-2">
                            共<?= $userExist ?>筆
                        </div>
                    <?php endif; ?>


                </div>
                <div class="d-flex mt-3">
                        <a href="sellers-check.php?order=refuse" class="d-flex me-3 review">
                            <p class="<?php
                            if($order === 'refuse'){
                                echo "review-switch-active";
                            }else{
                                echo "review-switch";
                            }?>"></p>    
                            已駁回
                           
                        </a>
                        <a href="sellers-check.php?order=wait" class="d-flex review">
                            <p class="<?php
                            if($order === 'wait'){
                                echo "review-switch-active";
                            }else{
                                echo "review-switch";
                            }?>" ></p>
                            待審查
                        </a>
                 
                </div>
                    <tr class="">
                        <th>申請編號</th>
                        <th>店家名稱</th>
                        <th>電話號碼</th>
                        <th>信箱</th>
                        <th>申請時間</th>
                        <th>申請狀態</th>
                        <th>
                            <form action="./sellers-check.php" method="GET">
                                <div class="input-group  search-user">
                                    <input type="search" class="form-control" placeholder="搜尋店家名稱、帳號、ID" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" value=<?php if (isset($search)) echo $search ?>>
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
                                <a class="text-decoration-none text-dark d-flex" href="./sellers-check.php?sellertable=<?= $rowUser['id'] ?><?php
                                if (isset($p)) echo "&p=$p";
                                if (isset($search)) echo "&search=$search";
                                if (isset($order)) echo "&order=$order";
                                ?>" type="submit">
                               <?= $rowUser['id'] ?>
                                <img class="magnifier-img" src="../img/search-solid.svg" alt=""></td>
                                </a>
                            <td><?= $rowUser['name'] ?></td>
                            <td class=""><?= $rowUser['account'] ?></td>
                            <td><?= $rowUser['email'] ?></td>
                            <td><?= $rowUser['created_at'] ?></td>
                            <td>
                            <?php if ($rowUser['valid'] == 2) : ?>
                                    <p class="m-0 text-primary">待審核</p>
                                <?php endif; ?>
                                <?php if ($rowUser['valid'] == 3) : ?>
                                    <p class="m-0 text-danger">已駁回</p>
                                <?php endif; ?>
                                <!-- <?php if ($rowUser['valid'] == 0) : ?>
                                    <p class="m-0 text-danger">停用</p>
                                <?php endif; ?> -->
                              
                            </td>
                            <td class="">
                                <a href="sellers-check-seller.php?id=<?= $rowUser['id'] ?>" class="btn btn-outline-secondary" type="submit">詳細資訊</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </thead>
    </table>
    <!-- 頁數 -->
     <?php if (isset($p)) : ?>
        <nav aria-label="Page navigation example p">
            <ul class="pagination  justify-content-center">
                <?php for ($i = 1; $i <= $pageConet; $i++) : ?>
                    <li class="page-item page-nav <?php if ($p == $i) echo 'active' ?>">
                        <a class="page-link" href="http://localhost/spotGoods/admin/sellers/sellers-check.php?p=<?= $i ?>"><?= $i ?>
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
                    <th>姓名</th>
                    <td><?= $rowUserUserTable['name'] ?></td>
                </tr>
                <tr>
                    <th>帳號</th>
                    <td><?= $rowUserUserTable['account'] ?></td>
                </tr>
                <tr>
                    <th>信箱</th>
                    <td><?= $rowUserUserTable['email'] ?></td>
                </tr>
  
                <tr>
                    <th>手機號碼</th>
                    <td>還沒新增</td>
                </tr>
                <tr>
                    <th>註冊時間</th>
                    <td><?= $rowUserUserTable['created_at'] ?></td>
                </tr>
                <tr>
                    <th>帳號狀態</th>
                    <td><?php if ($rowUserUserTable['valid'] == 2) {
                            echo "待審核";
                        } else {
                            echo "已駁回";
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