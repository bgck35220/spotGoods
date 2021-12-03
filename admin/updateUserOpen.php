<?php

require_once("../pdo-connect.php");

if(isset($_GET['id'])){
    $id=$_GET['id'];
}else {
    die("資料錯誤");
};



$sql = "UPDATE users SET valid=1 WHERE id=?";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$id]);
    $userExist=$stmt->rowCount();
   
    header("location: user.php?id=$id");
    $_SESSION['update_msg']="帳號已啟用";
}catch(PDOException $e){
    echo $e->getMessage();
}