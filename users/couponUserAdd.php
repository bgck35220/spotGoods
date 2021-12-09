<?php
require_once("pdo-connect.php");


if(isset($_POST['amount'])
   ||isset($_POST['quantity'])
   ||isset($_POST['couponid'])
){
    $amount=$_POST['amount'];
    $quantity=$_POST['quantity'];
    $couponid=$_POST['couponid'];
    $now = date("Y-m-d H:i:s");
    // $quantity=$_POST['quantity'];
    // $now =date("Y-m-d H:i:s");
    // $valid=1;
}else {
    die("資料錯誤");
};

//取使用者優惠券欄位
// $sql = "SELECT * FROM users WHERE id=?  AND valid=1 ";
// $stmt = $db_host->prepare($sql);
// try {
//     $stmt->execute([$_SESSION["user"]["id"]]);
//     $usersCount=$stmt->fetch();
//     $userExist = $stmt->rowCount();
//     var_dump($usersCount);
// } catch (PDOException $e) {
//     echo $e->getMessage();
// }

$sqlcoupon = "UPDATE coupon SET quantity=$quantity-1 WHERE id=?";

$stmtcoupon= $db_host->prepare($sqlcoupon);
try{
    $stmtcoupon->execute([$couponid]);
    $userExist=$stmtcoupon->rowCount();
    print_r($quantity);
}catch(PDOException $e){
    echo $e->getMessage();
}

$input = array(':couponid' => $couponid,':couponTakeTime' => $now ,':id' => $_SESSION["user"]["id"]);
$sql = "UPDATE users SET coupon_id = :couponid, coupon_taketime = :couponTakeTime WHERE id = :id";
$stmt= $db_host->prepare($sql);
try{
    $stmt->execute($input);
    $userExist=$stmt->rowCount();
   
    header("location: coupon-receive.php");
    // $_SESSION['update_msg']="帳號已啟用";
}catch(PDOException $e){
    echo $e->getMessage();
}
// if(isset($_POST['id'])
//    ||isset($_POST['text'])
//    ||isset($_POST['amount'])
//    ||isset($_POST['quantity'])
// ){
//     $id=$_POST['id'];
//     $text=$_POST['text'];
//     $amount=$_POST['amount'];
//     $quantity=$_POST['quantity'];
//     $now =date("Y-m-d H:i:s");
//     $valid=1;
// }else {
//     die("資料錯誤");
// };


// $input = array(':text' => $text,':amount' => $amount,':quantity' => $quantity,':coupon_time' => $now,':valid' => $valid);
// $sql="INSERT INTO coupon (text,amount,quantity,coupon_time,valid) VALUES(:text,:amount,:quantity,:coupon_time,:valid)";

// $stmt= $db_host->prepare($sql);
// try{
//     $stmt->execute($input);
//     $userExist=$stmt->rowCount();
 
// }catch(PDOException $e){
//     echo $e->getMessage();
// }


?>