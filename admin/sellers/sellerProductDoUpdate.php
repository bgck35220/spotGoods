<?php
//使用mysql增加欄位
require_once("../../pdo-connect.php");

if(isset($_POST['id'])
   ||isset($_POST['name'])
   ||isset($_POST['price'])
   ||isset($_POST['valid'])
   ||isset($_POST['text'])
){
    $name=$_POST['name'];
    $price=$_POST['price'];
    $id=$_POST['id'];
    $valid=$_POST['valid'];
    $text=$_POST['text'];
}else {
    die("資料錯誤");
};


$sql = "UPDATE products SET name=?, price=? ,text=?,valid=? WHERE id=?";
$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$name, $price, $text, $valid, $id ]);
    $userExist=$stmt->rowCount();
    $_SESSION['update_msg']="編輯資料成功";
    header("location: seller-product.php?id=$id");
 
}catch(PDOException $e){
    echo $e->getMessage();
}