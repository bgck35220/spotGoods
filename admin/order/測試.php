<?php 
require_once("../../pdo-connect.php");


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


$sqlOrder="SELECT a.* ,b.id as users_id,
b.account as user_account,
b.name as user_name,
b.email as user_email,
b.address as user_address,
b.created_at as user_created_at,
b.valid as user_valid,
c.id as sellers_id,
c.account as seller_account,
c.email as seller_email,
c.name as seller_name,
c.created_at as seller_created_at,
d.name as products_name,
d.valid as products_valid,
d.created_at as products_created_at
FROM order_all AS a
JOIN users as b on a.id = b.id
JOIN sellers as c on a.id = c.id
JOIN products as d on a.id = d.id
WHERE a.id = 1";

// $sqlOrder="SELECT * FROM order_all";
$stmtOrder= $db_host->prepare($sqlOrder);
try{ 
    $stmtOrder->execute();
    $rowOrder=$stmtOrder->fetch();
    print_r($rowOrder);
}catch(PDOException $e){
    echo $e->getMessage();
}


?>