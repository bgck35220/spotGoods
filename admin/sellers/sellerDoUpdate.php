<?php
//使用mysql增加欄位
require_once("../../pdo-connect.php");

if(isset($_POST['id'])
||isset($_POST['bossname'])
   ||isset($_POST['name'])
   ||isset($_POST['email'])
   ||isset($_POST['phone'])
   ||isset($_POST['address'])
   ||isset($_POST['valid'])
   
){
    $id=$_POST['id'];
    $bossname=$_POST['bossname'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $valid=$_POST['valid'];
  
}else {
    $_SESSION['update_msg']="編輯資料成功";
    header("location: seller.php?id=$id");
};


$sql = "UPDATE sellers SET bossname=?,name=?,email=?,phone=?,address=?,valid=? WHERE id=?";
$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$bossname,$name, $email,$phone,$address, $valid, $id ]);
    $userExist=$stmt->rowCount();
    $_SESSION['update_msg']="編輯資料成功";
    header("location: seller.php?id=$id");
 
}catch(PDOException $e){
    echo $e->getMessage();
}