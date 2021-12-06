<?php

require_once("../../pdo-connect.php");

if(isset($_GET['id'])&&isset($_GET['userid'])){
    $id=$_GET['id'];
    $userid=$_GET['userid'];    
}else {
    die("資料錯誤");
};



$sql = "UPDATE products SET valid=0 WHERE id=?";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$id]);
    $userExist=$stmt->rowCount();
   
    if(isset($_GET['search'])){
        $search=$_GET['search'];
        header("location: seller-product-list.php?userid=$userid&search=$search");
    }else if((isset($_GET['p']))) {
        $p=$_GET['p'];
        header("location: seller-product-list.php?userid=$userid&p=$p");
    }else{
        header("location: seller-product-list.php?userid=$userid");
    }

 
}catch(PDOException $e){
    echo $e->getMessage();
}