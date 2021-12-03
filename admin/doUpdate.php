<?php
//使用mysql增加欄位
require_once("../pdo-connect.php");

if(isset($_POST['id'])
   ||isset($_POST['name'])
   ||isset($_POST['email'])
   ||isset($_POST['address'])
){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $id=$_POST['id'];
}else {
    die("資料錯誤");
};

echo $id;

$sql = "UPDATE users SET name=?, email=?, address=? WHERE id=?";
$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$name, $email, $address, $id]);
    $userExist=$stmt->rowCount();
    $_SESSION['update_msg']="編輯資料成功";
    header("location: user.php?id=$id");
 
}catch(PDOException $e){
    echo $e->getMessage();
}