<?php
require_once("../pdo-connect.php");

//總筆數
$sqlTotal = "SELECT * FROM users";
$stmtTotal =$db_host->prepare($sqlTotal);

try {
    $stmtTotal->execute();
    $totalUsersCount = $stmtTotal->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}



if (!isset($_SESSION["user"])) {
    header("location:adminLogin.php");
} else if (isset($_GET['search'])) {
    //搜尋會員帳號和電子信箱功能
    $search = $_GET['search'];
    $sqlUser = "SELECT * FROM users WHERE account and email LIKE '%$search%'";
} else {
    //分頁功能
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
    } else {
        $p = 1;
    }

    $pageItems = 10; //一頁6個
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
    $sqlUser = "SELECT * FROM users  ORDER BY id LIMIT $startItem,$pageItems";
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
    <title>管理員後台</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>



    <header class="container-fluid nav-bar-title py-2 sticky-top header-nav">
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
                    <tr class="">
                        <th>id</th>
                        <th>姓名</th>
                        <th>帳號</th>
                        <th>信箱</th>
                        <th>註冊時間</th>
                        <th>狀態</th>
                        <th>
                            <form action="./admin.php" method="GET">
                                <div class="input-group  search-user">
                                    <input type="search" class="form-control" placeholder="搜尋會員帳號或信箱" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" value>
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">搜尋</button>
                                </div>
                            </form>
                        </th>
                    </tr>

                <tbody class="">
                    <?php while ($rowUser = $stmtUser->fetch()) :
                    ?>


                        <tr class="table-text-all">
                            <td><?= $rowUser['id'] ?></td>
                            <td><?= $rowUser['name'] ?></td>
                            <td><?= $rowUser['account'] ?></td>
                            <td><?= $rowUser['email'] ?></td>
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
                                <a href="user.php?id=<?= $rowUser['id'] ?>" class="btn btn-outline-success" type="submit">詳細資訊</a>
                                <a href="./user-update.php?id=<?= $rowUser['id'] ?>" class="btn btn-outline-secondary">編輯資訊</a>


                                <?php if ($rowUser['valid'] == 1) :
                                    $validone += 1;
                                ?>
                                    <?php if (isset($search)) : ?>
                                        <a class="btn btn-outline-danger" href="admin.php?id=<?= $rowUser['id'] ?>&valid=<?= $rowUser['valid']; ?>&search=<?= $search ?>" id="user-close"> 停用</a>
                                        <?php elseif(isset($p)) : ?>
                                        <a class="btn btn-outline-danger" id="user-open" href="admin.php?id=<?= $rowUser['id'] ?>&valid=<?= $rowUser['valid']; ?>&p=<?= $p?>">停用</a>
                                    <?php else : ?>
                                        <a class="btn btn-outline-danger" href="admin.php?id=<?= $rowUser['id'] ?>&valid=<?= $rowUser['valid']; ?>" id="user-close"> 停用</a>
                                    <?php endif; ?>




                                <?php elseif (($rowUser['valid'] == 0)) : ?>

                                    <?php if (isset($search)) : ?>

                                        <a class="btn btn-outline-primary" id="user-open" href="admin.php?id=<?= $rowUser['id'] ?>&valid<?= $rowUser['valid']; ?>&search=<?= $search ?>">啟用</a>
                                    <?php elseif(isset($p)) : ?>
                                        <a class="btn btn-outline-primary" id="user-open" href="admin.php?id=<?= $rowUser['id'] ?>&p=<?= $p?>">啟用</a>
                                    <?php else : ?>
                                        <a class="btn btn-outline-primary" id="user-open" href="admin.php?id=<?= $rowUser['id'] ?>&valid<?= $rowUser['valid']; ?>">啟用</a>
                                    <?php endif; ?>
        </div>
    <?php endif; ?>
    </td>
    </tr>

<?php endwhile; ?>


<!-- 跳出視窗區塊 -->
<?php if (isset($_GET['id']) && (isset($_GET['valid'])) == "1") : ?>
    <div class="colseblcok  ">

        <div class="full-screen full-close">
            <div class="close">
                <div class="d-flex justify-content-end">
                    <a class=" btn closeX" id="closeX" href="admin.php<?php 
                    if (isset($search)) echo "?search=$search";
                    if (isset($p)) echo "?p=$p";?>">X</a>
                </div>
                <div class="closeText ">確定要停用帳號嗎?</div>
                <div class="d-flex justify-content-center">
                    <a type="submit" href="userDelete.php?id=<?= $_GET['id'] ?>" class="btn btn-danger closeCheck">確定</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['id']) && (isset($_GET['valid'])) == "0") : ?>
    <div class="openblcok">

        <div class="full-screen openFullScreen ">
            <div class="close">
                <div class="d-flex justify-content-end ">
                    <a class=" btn closeX" id="closeX" href="admin.php<?php 
                    if (isset($search)) echo "?search=$search";
                    if (isset($p)) echo "?p=$p";?>">X</a>
                </div>
                <div class="closeText">確定要啟用帳號嗎?</div>
                <div class="d-flex justify-content-center">
                    <a href="userOpen.php?id=<?= $_GET['id'] ?>" type="submit" class="btn btn-primary closeCheck">確定</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div>
                <h2 class="fs-3">會員管理</h2>
            </div>
            <div class="d-flex">
                <p>共 <?= $totalUsersCount ?> 位會員,<?= $validone ?> 位有效會員</p>
            </div>
    <?php if (isset($p)) : ?>
        <div class="py-2">此頁顯示第<?= $starNo ?>~<?= $starEnd ?>筆
     <?php endif; ?> 
    </div>
    </tbody>
    </thead>
    </table>

    <?php if (isset($p)) : ?>
        <nav aria-label="Page navigation example ">
            <ul class="pagination  justify-content-center">
                <?php for ($i = 1; $i <= $pageConet; $i++) : ?>
                        <li class="page-item <?php if ($p == $i) echo 'active' ?>">
                            <a class="page-link" href="http://localhost/spotGoods/admin/admin.php?p=<?= $i ?>"><?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
            </ul>
        </nav>
    <?php endif ?>
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
  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

    </script>

</html>