<?php
//使用mysql增加欄位
require_once("../../pdo-connect.php");

if(isset($_POST['id'])
   ||isset($_POST['text'])
   ||isset($_POST['amount'])
   ||isset($_POST['quantity'])
){
    $id=$_POST['id'];
    $text=$_POST['text'];
    $amount=$_POST['amount'];
    $quantity=$_POST['quantity'];
    $now =date("Y-m-d H:i:s");
    $valid=1;
}else {
    die("資料錯誤");
};


$input = array(':text' => $text,':amount' => $amount,':quantity' => $quantity,':coupon_time' => $now,':valid' => $valid);
$sql="INSERT INTO coupon (text,amount,quantity,coupon_time,valid) VALUES(:text,:amount,:quantity,:coupon_time,:valid)";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute($input);
    $userExist=$stmt->rowCount();
    header("location: coupon.php");

}catch(PDOException $e){
    echo $e->getMessage();
}


?>