<?php
require_once("../../pdo-connect.php");
if (!isset($_SESSION["user"])) {
    header("location:admin-Login.php");
};

// $sqlSellers="SELECT * FROM
//  ((order_all AS orderA INNER JOIN users AS usersB ON orderA.users_id=usersB.id) 
//  INNER JOIN products AS productsC ON orderA.products_id=productsC.id) 
//  INNER JOIN sellers AS sellersD ON orderA.sellers_id=sellersD.id 
//  WHERE orderA.id = 1" ;

// $sqlSellers="SELECT producs.name,sellers.name,users.name ,FROM oreder_all.id , sellers.id , WHERE order_all.id = sellers.id";

// $sqlSellers="SELECT 訂單.name,商家.name,客戶.name ,FROM 訂單.id , 客戶.id WHERE 訂單.id = 客戶.id";

//會員資料彈跳式窗
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlUsreTable = "SELECT a.id , 
    b.name as 'users_id', 
    c.id as 'sellers_id' ,
    c.name as'sellers_name',
    d.id as 'products_id' , 
    d.price as 'order_price' ,
    d.name as 'products_name', 
    a.order_time , a.status FROM 
    `order_all` a , `users` b , `sellers` c , `products` d 
    where a.id = b.id and a.sellers_id = c.id and a.products_id = d.id AND a.id=?";
    $stmtUserTable = $db_host->prepare($sqlUsreTable);

    try {
        $stmtUserTable->execute([$id]);
        $rowUserUserTable = $stmtUserTable->fetch();
        $userExistUserTable = $stmtUserTable->rowCount();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
};



$sqlOrder = "SELECT a.id , 
b.name as 'users_id', 
c.id as 'sellers_id' ,
c.name as'sellers_name',
d.id as 'products_id' , 
d.price as 'order_price' ,
d.name as 'products_name', 
a.order_time , a.status FROM 
`order_all` a , `users` b , `sellers` c , `products` d 
where a.id = b.id and a.sellers_id = c.id and a.products_id = d.id; ";

// $sqlOrder="SELECT * FROM order_all";
$stmtOrder= $db_host->prepare($sqlOrder);
try{ 
    $stmtOrder->execute();

}catch(PDOException $e){
    echo $e->getMessage();
}

// $sqlUser="SELECT * FROM users ";
// $stmtUser= $db_host->prepare($sqlUser);
// try{ 
//     $stmtUser->execute();
  
// }catch(PDOException $e){
//     echo $e->getMessage();
// }

// $sqlProducts="SELECT * FROM products ";
// $stmtProducts= $db_host->prepare($sqlUser);
// try{ 
//     $stmtUser->execute();
  
// }catch(PDOException $e){
//     echo $e->getMessage();
// }

// $sqlUser="SELECT * FROM users ";
// $stmtUser= $db_host->prepare($sqlUser);
// try{ 
//     $stmtUser->execute();
  
// }catch(PDOException $e){
//     echo $e->getMessage();
// }



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
                <h1>訂單總覽</h1>
                <table class="table  table-striped ttbb">
                    
                    <thead>
                            <tr class="">
                                <th>訂單編號</th>
                                <th>訂單會員</th>
                                <th>訂單商家</th>
                                <th>訂單商品</th>
                                <th>訂單價錢</th>
                                <th>成立時間</th>
                                <th>訂單狀態</th>
                                <th></th>
                            </tr>
                        <tbody class="">
                        <?php while($rowOrder=$stmtOrder->fetch()):?>
                            <tr class="table-text-all">
                                <td><?=$rowOrder['id']?></td>
                                <td><?=$rowOrder['users_id']?></td>
                                <td><?=$rowOrder['sellers_name']?></td>
                                <td><?=$rowOrder['products_name']?></td>
                                <td>$<?=$rowOrder['order_price']?></td>
                                <td><?=$rowOrder['order_time']?></td>
                                <td>
                                    <?php if($rowOrder['status'] === "1"){
                                        echo "已成立";
                                    }else{
                                        echo "未成立";}?>
                                    </td>
                                <td> 
                                    <a href="orders-list.php?id=<?= $rowOrder['id'] ?>" class="btn btn-outline-secondary" type="submit">詳細資訊</a>
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
                    <th>訂單會員</th>
                    <td><?= $rowUserUserTable['users_id'] ?></td>
                </tr>
                <tr>
                    <th>會員id</th>
                    <td><?= $rowUserUserTable['users_id'] ?></td>
                </tr>
                <tr>
                    <th>訂單商家</th>
                    <td><?= $rowUserUserTable['sellers_name'] ?></td>
                </tr>
                <tr>
                    <th>訂單商品</th>
                    <td><?= $rowUserUserTable['products_name'] ?></td>
                </tr>
                <tr>
                    <th>訂單價錢</th>
                    <td><?= $rowUserUserTable['order_price'] ?></td>
                </tr>
                <tr>
                    <th>成立時間</th>
                    <td><?= $rowUserUserTable['order_time'] ?></td>
                </tr>
                <tr>
                    <th>訂單狀態</th>
                    <td><?php if ($rowUserUserTable['status'] == 1) {
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