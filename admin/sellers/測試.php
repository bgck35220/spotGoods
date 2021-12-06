<?php

require_once("../../pdo-connect.php");

// $sql="SELECT products.*, sellers.id
// FROM products
// INNER JOIN sellers
// ON products.sellers_id=1";

// $stmt= $db_host->prepare($sql);
// try{
//     $stmt->execute();
//     $rowUser = $stmt->fetch();
//     $userExist=$stmt->rowCount();
    

// }catch(PDOException $e){
//     echo $e->getMessage();


$sqlProducts="SELECT * FROM products ";

$stmtProducts= $db_host->prepare($sqlProducts);
try{
    $stmtProducts->execute();
    // $rowProducts = $stmtProducts->fetch();
    // var_dump($rowProducts);

}catch(PDOException $e){
    echo $e->getMessage();
}


$sqlSellers="SELECT * FROM sellers ";

$stmtSellers= $db_host->prepare($sqlSellers);
try{
    $stmtSellers->execute();
    $rowSellers = $stmtSellers->fetch();
    $userExist=$stmtSellers->rowCount();
   
}catch(PDOException $e){
    echo $e->getMessage();
}

while($rowProducts = $stmtProducts->fetch()){
    if($rowProducts['sellers_id'] === "1"){
        var_dump($rowProducts['name']);
    }
}
?>