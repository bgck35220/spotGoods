<?php

require_once("../../pdo-connect.php");

if(isset($_GET['id'])){
    $id=$_GET['id'];
}else {
    die("資料錯誤");
};

echo $id;

$sql = "UPDATE coupon SET valid=0 WHERE id=?";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$id]);
    $userExist=$stmt->rowCount();
   
    if(isset($_GET['search'])){
        $search=$_GET['search'];
        header("location: coupon.php?search=$search");
    }else if((isset($_GET['p']))) {
        $p=$_GET['p'];
        header("location: coupon.php?p=$p");
    }else{
        header("location: coupon.php");
    }
 
}catch(PDOException $e){
    echo $e->getMessage();
}


