<?php
require_once ("pdo-connect.php");

//取消訂單
$status=$_POST["status"];
$user_order_id=$_POST["userOrderId"];

$sql="UPDATE user_order SET status_id=? WHERE id=?";
$stmt=$db_host->prepare($sql);

try{
    $stmt->execute([$status, $user_order_id]);
    header("location: user-order-list.php?status=3");

}catch(PDOException $e){
    echo $e->getMessage();
}

$db_host=NULL;  //資料庫關閉連結
