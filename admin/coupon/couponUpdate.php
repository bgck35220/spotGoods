<?php
//使用mysql增加欄位
require_once("../../pdo-connect.php");

if(isset($_POST['id'])
   ||isset($_POST['text'])
   ||isset($_POST['amount'])
   ||isset($_POST['quantity'])
   ||isset($_POST['valid'])
){
    $id=$_POST['id'];
    $text=$_POST['text'];
    $amount=$_POST['amount'];
    $quantity=$_POST['quantity'];
    $valid=$_POST['valid'];
}else {
    die("資料錯誤");
};

echo $id;
echo $valid;
$sql = "UPDATE coupon SET text=?, amount=?, quantity=?,valid=? WHERE id=?";
$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$text, $amount, $quantity, $valid, $id ]);
    $userExist=$stmt->rowCount();
    $_SESSION['update_msg']="編輯資料成功";
    header("location: coupon-update.php?id=$id");
 
}catch(PDOException $e){
    echo $e->getMessage();
}