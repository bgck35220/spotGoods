<?php
require_once("../../pdo-connect.php");
if (!isset($_SESSION["user"])) {
    header("location:admin-Login.php");
};


$sqlTotal = 
"SELECT a.* ,b.id as users_id,
b.account as user_account,
b.name as user_name,
b.email as user_email,
b.address as user_address,
b.created_at as user_created_at,
b.valid as user_valid,
c.id as seller_id,
c.account as seller_account,
c.email as seller_email,
c.name as seller_name,
c.created_at as seller_created_at,
d.name as products_name,
d.valid as products_valid,
d.created_at as products_created_at
FROM order_all AS a
JOIN users as b on a.users_id = b.id
JOIN sellers as c on a.sellers_id = c.id
JOIN products as d on a.products_id = d.id
";
$stmtTotal = $db_host->prepare($sqlTotal);
try {
    $stmtTotal->execute();
    $totalUsersCount = $stmtTotal->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// 會員資料彈跳式窗
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlUsreTable = "SELECT a.* ,b.id as users_id,
    b.account as user_account,
    b.name as user_name,
    b.email as user_email,
    b.address as user_address,
    b.created_at as user_created_at,
    b.valid as user_valid,
    c.id as seller_id,
    c.account as seller_account,
    c.email as seller_email,
    c.name as seller_name,
    c.created_at as seller_created_at,
    d.name as products_name,
    d.valid as products_valid,
    d.created_at as products_created_at
    FROM order_all AS a
    JOIN users as b on a.users_id = b.id
    JOIN sellers as c on a.sellers_id = c.id
    JOIN products as d on a.products_id = d.id
    WHERE a.id = ?";
    $stmtUserTable = $db_host->prepare($sqlUsreTable);

    try {
        $stmtUserTable->execute([$id]);
        $rowUserUserTable = $stmtUserTable->fetch();
      
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


}



if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sqlOrder = "SELECT a.* ,b.id as users_id,
    b.account as user_account,
    b.name as user_name,
    b.email as user_email,
    b.address as user_address,
    b.created_at as user_created_at,
    b.valid as user_valid,
    c.id as seller_id,
    c.account as seller_account,
    c.email as seller_email,
    c.name as seller_name,
    c.created_at as seller_created_at,
    d.name as products_name,
    d.valid as products_valid,
    d.created_at as products_created_at
    FROM order_all AS a
    JOIN users as b on a.users_id = b.id
    JOIN sellers as c on a.sellers_id = c.id
    JOIN products as d on a.products_id = d.id
    WHERE a.id like '%$search%' OR b.name like '%$search%' OR c.name like '%$search%' ";
} else{
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
        $sqlOrder="SELECT a.* ,b.id as users_id,
        b.account as user_account,
        b.name as user_name,
        b.email as user_email,
        b.address as user_address,
        b.created_at as user_created_at,
        b.valid as user_valid,
        c.id as seller_id,
        c.account as seller_account,
        c.email as seller_email,
        c.name as seller_name,
        c.created_at as seller_created_at,
        d.name as products_name,
        d.valid as products_valid,
        d.created_at as products_created_at
        FROM order_all AS a
        JOIN users as b on a.users_id = b.id
        JOIN sellers as c on a.sellers_id = c.id
        JOIN products as d on a.products_id = d.id
        ORDER BY id LIMIT $startItem,$pageItems";



}

$stmtOrder= $db_host->prepare($sqlOrder);
try{ 
    $stmtOrder->execute();
    $totalUsersCount = $stmtOrder->rowCount();
}catch(PDOException $e){
    echo $e->getMessage();
}




// $sqlOrder = "SELECT a.id , 
// b.name as 'users_id', 
// c.id as 'sellers_id' ,
// c.name as'sellers_name',
// d.id as 'products_id' , 
// d.price as 'order_price' ,
// d.name as 'products_name', 
// a.order_time , a.status FROM 
// `order_all` a , `users` b , `sellers` c , `products` d 
// where a.id = b.id and a.sellers_id = c.id and a.products_id = d.id; ";





?>
<!doctype html>
<html lang="en">

<head>
    <title>管理員後台-訂單總覽</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
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
                                    <li><a class="dropdown-item" href="../sellers/sellers-check.php">店家申請</a></li>
                                    <li><a class="dropdown-item" href="../sellers/sellers.php">店家總覽</a></li>
                                    <li><a class="dropdown-item" href="../sellers/seller-add.php">新增店家資料</a></li>

                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle nav-text text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    訂單管理
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="./orders-list.php">訂單總覽</a></li>

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
                            <a href="../logOut.php" type="button" class="btn btn-warning">登出</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </header>


    <!-- 主要內容 -->

    <main>
        <div class="container pt-5 "> 
                <h2>訂單總覽</h2>
                <table class="table  table-striped ttbb">
                <?php if (isset($p)) : ?>
                        <div class="py-2">   共<?= $totalUsersCount ?>筆訂單 
                        <br>
                        <br>
                        此頁顯示第<?= $starNo ?>~<?= $starEnd ?>筆</div>
                    <?php else : ?>
                        <div class="py-2">
                            共<?= $totalUsersCount ?>筆訂單
                        </div>
                    <?php endif; ?>
                    <thead>
                        
                            <tr class="">
                                <th>訂單編號</th>
                                <th>會員</th>
                                <th>商家</th>
                                <th>商品</th>
                                <th>價錢</th>
                                <th>成立時間</th>
                                <th>訂單狀態</th>
                                <th>
                                    <form action="./orders-list.php" method="GET">
                                        <div class="input-group  search-user">
                                             <input type="search" class="form-control" placeholder="搜尋訂單編號、會員姓名、商家店名" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" value=<?php if (isset($search)) echo $search ?>>
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">搜尋</button>
                                        </div>
                                    </form>
                                </th>
                            </tr>
                        <tbody class="">
                        <?php while($rowOrder=$stmtOrder->fetch()):?>
                            <tr class="table-text-all">
                                <td><?=$rowOrder['id']?></td>
                                <td>
                                <a class="text-decoration-none text-dark d-flex" href="../user.php?id=<?=$rowOrder['users_id']?>
                                <?php
                                if (isset($p)) echo "&p=$p";
                                if (isset($search)) echo "&search=$search" ?>
                                "type="submit">
                                     <?=$rowOrder['user_name']?>
                                    <img class="magnifier-img" src="../img/search-solid.svg" alt="">
                                </a>
                                </td>
                                <td>
                                <a class="text-decoration-none text-dark d-flex" href="../sellers/seller.php?id=<?= $rowOrder['seller_id']?>
                                <?php
                                if (isset($p)) echo "&p=$p";
                                if (isset($search)) echo "&search=$search" ?>" type="submit">
                                  <?=$rowOrder['seller_name']?>
                                    <img class="magnifier-img" src="../img/search-solid.svg" alt="">
                                </a>
                                </td>
                                   
                                <td><?=$rowOrder['products_name']?></td>
                                <td>$<?=$rowOrder['order_price']?></td>
                                <td><?=$rowOrder['order_time']?></td>
                                <td>
                                    <?php if ($rowOrder['status'] == 1):?> 
                                        <p class="text-primary">已成立</p>
                                    <?php else:?>
                                        <p class="text-text-danger">已成立</p>
                                    <?php endif?>
                                </td>
                                <td> 
                                    <a href="orders-list.php?id=<?= $rowOrder['id'] ?><?php if (isset($p)) echo "&p=$p";if (isset($search)) echo "&search=$search";?>
                                    "class="btn btn-outline-secondary" type="submit">詳細資訊</a>
                                </td>
                            </tr>
                            <?php endwhile;?>
                        </tbody>
                    </thead>
                </table>
        </div>

         <!-- 點帳號直接顯示詳細資訊                   -->
    <?php if (isset($_GET['id']) ) : ?>
        <div class="col-3 user-table ">
            <table class="table table-bordered  m-auto user-table-text  ">
                <tr>
                    <th>訂單編號</th>
                    <td><?= $rowUserUserTable['id'] ?>
                        <a class="user-table-btn-close" 
                        href="./orders-list.php?<?php
                        if (isset($p)) echo "&p=$p";
                        if (isset($search)) echo "&search=$search";
                        ?>">X
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>會員ID</th>
                    <td><?= $rowUserUserTable['users_id'] ?></td>
                </tr>
                <tr>
                    <th>會員</th>
                    <td><?= $rowUserUserTable['user_name'] ?></td>
                </tr>
                <tr>
                    <th>會員信箱</th>
                    <td><?= $rowUserUserTable['user_email'] ?></td>
                </tr>
                <tr>
                    <th>會員手機號碼</th>
                    <td><?= $rowUserUserTable['user_email'] ?></td>
                </tr>
               
                <tr>
                    <th>商家ID</th>
                    <td><?= $rowUserUserTable['seller_id'] ?></td>
                </tr>
                <tr>
                    <th>商家</th>
                    <td><?= $rowUserUserTable['seller_name'] ?></td>
                </tr>
                <tr>
                    <th>商家地址</th>
                    <td><?= $rowUserUserTable['seller_name'] ?></td>
                </tr>
                <tr>
                    <th>商家信箱</th>
                    <td><?= $rowUserUserTable['seller_email'] ?></td>
                </tr>
                <tr>
                    <th>商家手機號碼</th>
                    <td><?= $rowUserUserTable['seller_email'] ?></td>
                </tr>
                <tr>
                    <th>訂單商品</th>
                    <td><?= $rowUserUserTable['products_name'] ?></td>
                </tr>
                <tr>
                    <th>訂單價錢</th>
                    <td>$<?= $rowUserUserTable['order_price'] ?></td>
                </tr>
                <tr>
                    <th>訂單成立時間</th>
                    <td><?= $rowUserUserTable['order_time'] ?></td>
                </tr>
                <tr>
                    <th>訂單狀態</th>
                    <td><?php if ($rowUserUserTable['status'] == 1):?> 
                            <p class="text-primary">已成立</p>
                        <?php else:?>
                            <p class="text-text-danger">已成立</p>
                        <?php endif?>
                        </td>

                </tr>

            </table>
        </div>
    <?php endif ?>


    <?php if (isset($p)) : ?>
        <nav aria-label="Page navigation example ">
            <ul class="pagination  justify-content-center">
                <?php for ($i = 1; $i <= $pageConet; $i++) : ?>
                    <li class="page-item page-nav <?php if ($p == $i) echo 'active' ?>">
                        <a class="page-link" href="http://localhost/spotGoods/admin/order/orders-list.php?p=<?= $i ?>"><?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
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
</body>
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