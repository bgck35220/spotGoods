<?php

require_once("../../pdo-connect.php");

if(isset($_GET['id'])){
    $id=$_GET['id'];
}else {
    die("資料錯誤");
};

$sql = "UPDATE sellers SET valid=3 WHERE id=?";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute([$id]);
    $userExist=$stmt->rowCount();
    header("location: sellers-check-seller.php");
   
 
}catch(PDOException $e){
    echo $e->getMessage();
}


