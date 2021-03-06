<?php
require_once("pdo-connect.php");
//一定要使用者頁面登入才能用的話，加入此判斷有沒有權限，沒登入成功就無法使用功能
if (!isset($_SESSION["user"])) {  //導進來頁面 先檢查存不存在
    header("location: users-login.php");
}

//失敗的，不是用 GROUP BY
//$sql="SELECT user_order.*, order_status.status, COUNT(user_order_detail.order_id), user_order_detail.product_id, user_order_detail.amount
//FROM user_order
//JOIN order_status ON user_order.status_id = order_status.id
//JOIN user_order_detail ON user_order.id = user_order_detail.order_id
//GROUP BY user_order_detail.order_id
//ORDER BY user_order.id DESC
//";

//失敗的，這裡會將每筆買的數量一起列出 一筆訂單可能不只一項 這樣列出的數量不是要的資料
//$sql="SELECT user_order.*, order_status.status, user_order_detail.order_id, user_order_detail.product_id, user_order_detail.amount, products.name AS product_name, products.img, products.price, products.store_id, stores.name AS store_name
//FROM user_order
//JOIN order_status ON user_order.status_id = order_status.id
//JOIN user_order_detail ON user_order.id = user_order_detail.order_id
//JOIN products ON user_order_detail.product_id = products.id
//JOIN stores ON products.store_id = stores.id
//WHERE user_order.user_id=?
//ORDER BY user_order.id DESC
//";

//PHP 組合不特定條件的 PDO 查詢語法   //失敗，不會用
//$conditions = [];
//$parameters = [];
//if (!empty($_GET["status"])) {
//    $conditions[] = "order_status.id=?";
//    $parameters[] = $_SESSION["user"]["id"];
//    $parameters[] = $_GET["status"];
//}
//// the main query
//$sql = "SELECT user_order.*, order_status.*, stores.name AS store_name
//    FROM user_order
//    JOIN order_status ON user_order.status_id = order_status.id
//    JOIN stores ON user_order.store_id = stores.id
//    ORDER BY user_order.id DESC
//    WHERE user_order.user_id=?";
//// 把條件組合成 query 語法
//if ($conditions) {
//    $sql .= implode(" AND ", $conditions);
//}

if(isset($_GET["status"])){

    //篩選訂單狀態
    $sql="SELECT user_order.*, order_status.id AS order_status_id, order_status.status, stores.name AS store_name
    FROM user_order
    JOIN order_status ON user_order.status_id = order_status.id
    JOIN stores ON user_order.store_id = stores.id
    WHERE user_order.user_id=? AND order_status.id=? ORDER BY user_order.id DESC
    ";

    //多層 query要用的
    $sqlUserOrder = "SELECT user_order.*, order_status.*
    FROM user_order
    JOIN order_status ON user_order.status_id = order_status.id
    WHERE user_order.user_id=? AND order_status.id=?
    ";

    //篩選條件的值，存入陣列，後面$stmt->execute用
    $parameters = [$_SESSION["user"]["id"], $_GET["status"]];

}else if(isset($_GET["search"])){

    $search=$_GET["search"];
    //搜尋有符合的字串
    $sql="SELECT user_order.*, order_status.id AS order_status_id, order_status.status, stores.name AS store_name
    FROM user_order
    JOIN order_status ON user_order.status_id = order_status.id
    JOIN stores ON user_order.store_id = stores.id
    WHERE user_order.user_id=? AND stores.name LIKE ?;
    ";

    //多層 query要用的
    $sqlUserOrder = "SELECT user_order.*, order_status.status, stores.name AS store_name
    FROM user_order
    JOIN order_status ON user_order.status_id = order_status.id
    JOIN stores ON user_order.store_id = stores.id
    WHERE user_order.user_id=? AND stores.name LIKE ?;
    ";

    //篩選條件的值，存入陣列，後面$stmt->execute用
    $parameters = [$_SESSION["user"]["id"], '%'.$search.'%'];

}else{

    //預設
    $sql="SELECT user_order.*, order_status.id AS order_status_id, order_status.status, stores.name AS store_name
    FROM user_order
    JOIN order_status ON user_order.status_id = order_status.id
    JOIN stores ON user_order.store_id = stores.id
    WHERE user_order.user_id=? ORDER BY user_order.id DESC
    ";

    //多層 query要用的
    $sqlUserOrder = "SELECT * FROM user_order WHERE user_id=?";

    //篩選條件的值，存入陣列，後面$stmt->execute用
    $parameters = [$_SESSION["user"]["id"]];

}



//要撈使用者全部訂單有幾筆 並把同層附加資訊JOIN在裡面一起呈現，此時只能列出 我的訂單、商店名稱、訂單狀態
//挪去上面if判斷篩選
//$sql="SELECT user_order.*, order_status.status, stores.name AS store_name
//    FROM user_order
//    JOIN order_status ON user_order.status_id = order_status.id
//    JOIN stores ON user_order.store_id = stores.id
//    WHERE user_order.user_id=? ORDER BY user_order.id DESC
//    ";
$stmt = $db_host->prepare($sql);

try {
    $stmt->execute($parameters);
    $userOrderNum = $stmt->rowCount();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//    測試看資料  fetch用while 等同 fetchAll用foreach
//        foreach ($rows as $row){
//        print_r($row);
//        echo "<br>";
//        echo "<br>";
//    }
//    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
//        print_r($rows);
//        echo "<br>";
//        echo "<br>";
//    }
//    exit(); //測試

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    $db_host = NULL;
    exit;
}


//要撈每筆訂單內的詳細內容(每筆訂單訂的數量不同 第1單2筆、第2單4筆...等): 商品名稱、價錢、購買數量
//利用多層 query 資料組成關聯式陣列的應用
//第一層，使用者有幾筆訂單
//$sqlUserOrder = "SELECT * FROM user_order WHERE user_id=?";  //挪去上面if判斷篩選
$stmtUserOrder = $db_host->prepare($sqlUserOrder);
try {
    $stmtUserOrder->execute($parameters);
    $rowsUserOrder = $stmtUserOrder->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($rowsUserOrder); $i++) {
//        $rows[$i]["product_id"]="product_id"; //要撈的是user_order_detail.product_id

        //第二層，利用迴圈，第[i]單時撈出n筆購買項目，n= 當第[i]單，( order_id=[i] )的數量
//        $sqlOrderDetail = "SELECT * FROM user_order_detail WHERE order_id=?";
        $sqlOrderDetail = "SELECT user_order_detail.*, products.name AS product_name, products.img, products.price
        FROM user_order_detail
        JOIN products ON user_order_detail.product_id = products.id
        WHERE order_id=?";
        //將同層附加資訊JOIN在裡面一起呈現
        $stmtOrderDetail = $db_host->prepare($sqlOrderDetail);
        $stmtOrderDetail->execute([$rows[$i]["id"]]);  //利用第一層撈到的 user_id 筆數列出幾筆訂單，且 user_order.id 對應 order_id 每筆有買了幾項
        //當 user_order_detail.order_id = user_order.user_id例如有8筆 的訂單號碼(id)
        $rowsOrderDetail = $stmtOrderDetail->fetchAll(PDO::FETCH_ASSOC);
        //將陣列簡化 剩下想要的陣列value值
        $orderProductName = array_column($rowsOrderDetail, "product_name");
        $orderProductNum = array_column($rowsOrderDetail, "amount");
        $orderProductPrice = array_column($rowsOrderDetail, "price");
        $orderProductImg = array_column($rowsOrderDetail, "img");
        //將要的值塞進$rows陣列，自己給key值(命名 details/product_name/amount...)
        //因為同一層有不同種類的東西要呈現，所以用成二維陣列(?)
        $rows[$i]["details"]["product_name"] = $orderProductName;
        $rows[$i]["details"]["amount"] = $orderProductNum;
        $rows[$i]["details"]["price"] = $orderProductPrice;
        $rows[$i]["details"]["img"] = $orderProductImg;
    }

    //測試看資料
//    foreach ($rows as $row){
////        print_r($row["details"]);
////        print_r($row["details"]["product_name"]);
////        echo "<br>";
//        for($j=0; $j<count($row["details"]["product_name"]); $j++){
//            print_r($row["details"]["product_name"][$j]);
//            print_r($row["details"]["amount"][$j]);  //foreach會直接給index(?)
//            echo "<br>";
//        }
//        echo "<br>";
//    }
//    exit(); //測試

} catch (PDOException $e) {
    echo "預處理陳述式執行失敗<br>";
    echo "Error: " . $e->getMessage() . "<br>";
    $db_host = NULL;
    exit;
}






//待領取顯示幾筆未領
$sqlStatus="SELECT user_order.*, order_status.id AS order_status_id, order_status.status
    FROM user_order
    JOIN order_status ON user_order.status_id = order_status.id
    WHERE user_order.user_id=? AND order_status.id=1
    ";

$stmtStatus = $db_host->prepare($sqlStatus);

try {
    $stmtStatus->execute([$_SESSION["user"]["id"]]);
    $statusNum = $stmtStatus->rowCount();
//    echo $statusNum;
//    exit;
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
    <title>我的訂單</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/b8bae5c029.js" crossorigin="anonymous"></script>

    <!--將css獨立用php連結-->
    <?php require_once("css.php") ?>

</head>
<body>

<!--header-->
<header class="bg-light sticky-top top">
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
                            <?php if ($_SESSION["user"]["headshots"] == NULL): ?>
                                <img class="cover-fit" src="./upload/user.png" alt="user.png">
                            <?php else: ?>
                                <img class="cover-fit" src="./upload/<?= $_SESSION["user"]["headshots"] ?>"
                                     alt="<?= $_SESSION["user"]["headshots"] ?>">
                            <?php endif; ?>
                        </a>
                        <a class="mb-0 text-secondary text-decoration-none"
                           href="dashboard.php"><?= $_SESSION["user"]["account"] ?></a>
                        <a href="logOut.php" class="btn btn-info text-white ms-4">登出</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!--header-->


<div class="container px-4 mt-4">
    <div class="row g-3">
        <!--左邊選單-->
        <div class="col-md-3">
            <div class="p-5 bg-light menu">
                <figure class="d-flex align-items-center">
                    <a class="headshot" href="dashboard.php">
                        <?php if ($_SESSION["user"]["headshots"] == NULL): ?>
                            <img class="cover-fit" src="./upload/user.png" alt="user.png">
                        <?php else: ?>
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
            <div class="bg-light status d-flex justify-content-between">
                <a href="user-order-list.php" class=<?php if(!isset($_GET["status"]))echo "active"?>>全部</a>
                <a href="user-order-list.php?status=1" class="d-flex justify-content-center align-items-center <?php if(isset($_GET["status"]) && $_GET["status"]==1)echo 'active' ?>">待領取
                    <div class="badge rounded-pill bg-warning ms-2"><?php if(!$statusNum==0)echo $statusNum?></div></a>
                <a href="user-order-list.php?status=2" class=<?php if(isset($_GET["status"]) && $_GET["status"]==2)echo "active"?>>完成</a>
                <a href="user-order-list.php?status=3" class=<?php if(isset($_GET["status"]) && $_GET["status"]==3)echo "active"?>>已取消</a>
            </div>
            <!--搜尋-->
            <?php if(!isset($_GET["status"])): ?>
            <div class="my-3">
                <form action="user-order-list.php" method="get">
                    <div class="d-flex align-items-center">
                        <input type="search" class="form-control me-2" placeholder="您可以透過 <店家名稱> 進行搜尋" name="search"
                               value="<?php if (isset($search)) echo $search; ?>">
                        <button type="submit" class="btn btn-outline-success text-nowrap">搜尋</button>
                    </div>
                </form>
            </div><!--搜尋-->
            <?php endif; ?>
            <!--訂單內容-->
            <?php if ($userOrderNum > 0): ?>
                <?php foreach ($rows as $row): ?>
                    <div class="card my-3 p-4 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a class="text-decoration-none sellerName" href=""><i
                                        class="fas fa-store me-2"></i><?= $row["store_name"] ?></a>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="orderStatus"><?= $row["status"] ?></span>
                                <?php if($row["status_id"]==1): ?>
                                <form action="doUserOrderStatus.php" method="post">
                                    <input type="hidden" name="status" value="3">
                                    <input type="hidden" name="userOrderId" value="<?= $row["id"] ?>">
                                    <button type="submit" class="btn btn-sm btn-success text-nowrap ms-3">取消訂單</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!--購買商品資訊-->
                        <?php for ($j = 0; $j < count($row["details"]["product_name"]); $j++): ?>
                            <a href="" class="py-3 border-top text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="storePhoto" href="">
                                        <img class="cover-fit" src="images/<?= $row["details"]["img"][$j] ?>" alt="">
                                    </div>
                                    <div class="d-flex flex-fill flex-column ps-3">
                                        <div class="flex-fill pb-2 storeName"><?= $row["details"]["product_name"][$j] ?></div>
                                        <div class="storePrice">$ <?= $row["details"]["price"][$j] ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="buyNum">x <?= $row["details"]["amount"][$j] ?></span>
                                        <span class="buyNumPrice text-end">$ <?= $row["details"]["price"][$j] * $row["details"]["amount"][$j] ?></span>
                                    </div>
                                </div>
                            </a><!--購買商品資訊-->
                        <?php endfor; ?>
                        <div class="border-top d-flex justify-content-between align-items-center pt-3">
                            <span class="orderTime">訂單時間: <?= $row["order_time"] ?></span>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="orderPrice me-2">訂單金額:</span>
                                <span class="orderPriceNum text-end fs-4 text-nowrap">
                            $
                            <?php
                            for ($k = 0; $k < count($row["details"]["product_name"]); $k++) {
                                $Sum = $row["details"]["price"][$k] * $row["details"]["amount"][$k] + $Sum;
                            } ?>
                                    <?= $Sum ?> <!--訂單金額-->
                            <?php $Sum = 0; ?> <!--跑完一次就清0-->
                        </span>
                            </div>
                        </div>
                    </div><!--訂單內容-->
                <?php endforeach; ?>
            <?php else: ?>
                <?php if(isset($search)): ?>
                <div class="p-3 text-secondary">沒有符合的搜尋條件</div>
                <?php elseif(isset($_GET["status"])): ?>
                <div class="p-3 text-secondary">沒有符合的訂單</div>
                <?php else: ?>
                <div class="p-3 text-secondary">您尚未購買任何項目</div>
                <?php endif; ?>
            <?php endif; ?>
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>

<script>
    // 取消訂單提醒
    $(".btn-success").click(function () {
        let result = confirm("確認取消此訂單?");
        if (result) {
            return true;
        } else {
            return false;
        }
    });
</script>


</body>
</html>