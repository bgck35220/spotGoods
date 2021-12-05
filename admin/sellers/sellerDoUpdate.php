<?php
//使用mysql增加欄位
require_once("../../pdo-connect.php");

if(isset($_POST['id'])
   ||isset($_POST['name'])
   ||isset($_POST['email'])
   ||isset($_POST['valid'])
   ||isset($_POST['Logo'])
){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $id=$_POST['id'];
    $valid=$_POST['valid'];
    $Logo=$_POST['Logo'];
}else {
    die("資料錯誤");
};


$sql = "UPDATE sellers SET Logo=? , name=?, email=? ,valid=? WHERE id=?";
$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$Logo,$name, $email, $valid, $id ]);
    $userExist=$stmt->rowCount();
    $_SESSION['update_msg']="編輯資料成功";
    header("location: seller.php?id=$id");
 
}catch(PDOException $e){
    echo $e->getMessage();
}