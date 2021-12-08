<?php
require_once("pdo-connect.php");

$name = $_POST["name"];
$account = $_POST["account"];
$email = $_POST["email"];
$password = $_POST["password"];
//$repassword = $_POST["repassword"];
$phone=$_POST["phone"];
$address=$_POST["address"];

//if ($password !== $repassword) {  //檢查輸入密碼
//    echo "密碼不一致";
//    exit();
//}
$crPassword = md5($password);  //密碼加密，加密完約32個字元大小
//echo "$crPassword<br>";


$sqlCheck = "SELECT * FROM users WHERE account=?";
$checkResult = $db_host->prepare($sqlCheck);

$checkResult->execute([$account]);
$userExist = $checkResult->rowCount();
//echo $userExist."<br>";
if ($userExist > 0) {
    header("location: sign-up.php?error=1&name=$name&account=$account&email=$email&password=$password&phone=$phone&$address=$address");
    exit();
//$userExist=$checkResult->fetch(PDO::FETCH_ASSOC);
//print_r($checkResult); echo '<br>';
//print_r($userExist); echo '<br>';
//print_r($userExist["account"]);
//exit();
//if($userExist["account"]===$account){
//    echo "帳號已存在";
//    exit();
}

$now = date("Y-m-d H:i:s");
$sql = "INSERT INTO users(account, name, email, password, phone, address, created_at, valid) VALUES(?, ?, ?, ?, ?, ?, ?, 1)";
$stmt= $db_host->prepare($sql);
try {
    $stmt->execute([$account, $name, $email, $crPassword, $phone, $address, $now]);
    echo "新增資料完成";
//    $id = $db_host->lastInsertId();  //取得新增的資料id
//    echo "id: $id";
    header("location: users-login.php");

} catch (PDOException $e) {
    echo "新增資料錯誤";
    echo $e->getMessage();
}

$db_host = NULL; //關閉資料庫連結(?)