<?php
require_once("../../pdo-connect.php");

if (!isset($_SESSION["user"])) {
    header("location:admin-Login.php");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$sqlProduct = "SELECT a.* ,
b.id as seller_id,
b.name as seller_name,
b.valid as seller_valid,
b.created_at as seller_created_at
FROM products AS a
JOIN sellers as b on a.sellers_id = b.id
WHERE a.id =?";
$stmProduct = $db_host->prepare($sqlProduct);

try {
    $stmProduct->execute([$id]);
    $rowUser = $stmProduct->fetch();
    $userExist = $stmProduct->rowCount();
} catch (PDOException $e) {
    echo $e->getMessage();
}



// $sqlSellers="SELECT * FROM sellers ";
// $stmtSellers= $db_host->prepare($sqlSellers);
// try{
//     $stmtSellers->execute();
  
//     $userExist=$stmtSellers->rowCount();
//     $sellersname="";
//     while(  $rowSellers = $stmtSellers->fetch()){
//         if($rowSellers['id']===$_GET['id']){
//             $selleraname=$rowSellers['name'];
//         }
//     }

// }catch(PDOException $e){
//     echo $e->getMessage();
// }
?>
<!doctype html>
<html lang="en">

<head>
    <title>管理員後台-商品編輯資料</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style1.css">
</head>
<style>

</style>

<body>



    <header class="container-fluid nav-bar-title py-2 sticky-top">
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
                    <h2 class="subtitle">商品資料編輯</h2>
                </div>
                <div class="d-flex ">
                    <div class="me-2">
                        <a href="./seller-product.php?id=<?= $rowUser['id'] ?>" class="btn btn btn-light" type="submit">
                            詳細資訊
                        </a>
                    </div>
                    <div>
                        <a href="seller-product-list.php?userid=<?=$rowUser['seller_id']?>" class="btn btn-light" type="submit">
                            回店家商品
                        </a>
                    </div>
                </div>
            </div>

            <?php if ($userExist > 0) : ?>
                <form action="sellerProductDoUpdate.php " method="POST" class="updateForm">
                    <table class="table table-bordered  updateTable ">
                        <tr class="">
                            <th>id</th>
                            <td class="p-1"> <input type="text" value="<?= $rowUser['id'] ?>" class="form-control p-2 m-0" placeholder="id" name="id" disabled></td>
                        </tr>
                        <tr>
                            <th class="">上架商家</th>
                            <td class="p-1 "> <input type="text" value="<?= $rowUser['seller_name'] ?>" class="form-control p-2 m-0" placeholder="name" name="sellername" disabled></td>
                        </tr>
                        <tr>
                            <th>商品名稱</th>
                            <td class="p-1"> <input type="text" value="<?= $rowUser['name'] ?>" class="form-control p-2 m-0" placeholder="name" name="name"></td>
                        </tr>
                        <tr>
                            <th>商品價格</th>
                         
                            <td class="p-1"><input type="text" value="<?= $rowUser['price'] ?>" class="form-control p-2 m-0" placeholder="price" name="price"></td>
                        </tr>
                        <tr>
                            <th>商品描述</th>
                            <td class="p-1"> <input type="text"  class="form-control p-2 m-0" placeholder="text" value="還沒有東西"name=""></td>
                        </tr>
                        <tr>
                      
                        <tr>
                            <th>註冊時間</th>
                            <td class="p-1"> <input type="text" value="<?= $rowUser['created_at'] ?>" class="form-control p-2 m-0" placeholder="created_at" name="created_at" disabled></td>
                        </tr>
                        <tr>
                            <th>商品狀態</th>
                            <td class="user-switch">

                                <?php if ($rowUser['valid'] == 1) { ?>
                                    <!-- <p class="m-0 text-primary">啟用</p> -->
                                    <a class="btn btn-outline-primary"  id="btn-open"  > 上架</a>
                                    <a class="btn btn-outline-danger d-none" id="btn-close"  > 下架</a>
                                    <input type="hidden" name="valid" id="validswich"value="">

                                <?php } else if ($rowUser['valid'] == 0) { ?>
                                    <a class="btn btn-outline-danger" id="btn-close"  > 下架</a>
                                    <a class="btn btn-outline-primary d-none"  id="btn-open"> 上架</a>
                                    <input type="hidden" name="valid" id="validswich"value="">    
                                <?php }; ?>
                            </td>
                        </tr>


                    </table>
                    <input type="hidden" name="id" value="<?= $rowUser['id'] ?>">
                    <button type="submit" class="btn btn-outline-dark w-100">送出</button>
                </form>

            <?php endif; ?>
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
    <script src="../app.js"></script>
</body>

</html>