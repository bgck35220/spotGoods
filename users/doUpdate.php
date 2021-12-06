<?php

$name=$_POST["name"];
$email=$_POST["email"];
$id=$_POST["id"];
$phone=$_POST["phone"];

require_once ("pdo-connect.php");

$sql="UPDATE users SET email=?, name=?, phone=? WHERE id=?";
$stmt=$db_host->prepare($sql);

try{
    $stmt->execute([$email, $name, $phone, $id]);
    header("location: dashboard.php");
}catch(PDOException $e){
    echo $e->getMessage();
}

$db_host=NULL;  //資料庫關閉連結
