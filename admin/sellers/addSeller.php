<?php

require_once("../../pdo-connect.php");

//待資料庫結構確認補上完整判斷
if(isset($_POST['name'])){
    $account=$_POST['account'];
    $password=password_hash($_POST["password"],PASSWORD_DEFAULT);
    $name=$_POST['name'];
    $email=$_POST['email'];
    $now =date("Y-m-d H:i:s");
    $valid=1;
}else{
    die("資料錯誤");
};
$input = array(':name' => $name,':account' => $account,':password' => $password,':created_at' => $now, ':email' => $email , ':valid' => $valid);
$sql="INSERT INTO sellers(name,account,password,created_at,email,valid) VALUES(:name,:account,:password,:created_at,:email,:valid)";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute($input);
    $userExist=$stmt->rowCount();
    header("location: sellers.php");

}catch(PDOException $e){
    echo $e->getMessage();
}
?>