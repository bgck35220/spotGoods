<?php
require_once ("pdo-connect.php");  //裡面已經有session start

//先確保存取得到值
if(isset($_POST["account"])){
    $account=$_POST["account"];
    $password=$_POST["password"];
//    echo $email."<br>";
//    echo $password."<br>";
}else{
    exit();
    //看要不要再添加合法進入訊息
}

$password=md5($password); //資料庫裡存的是加密過後的

$sql="SELECT * FROM users WHERE account=? AND password=? AND valid=1";
$stmt=$db_host->prepare($sql);
try{
    $stmt->execute([$account, $password]);
    $userExist=$stmt->rowCount();
//    echo $userExist;  //0沒有資料 1一筆資料
    if($userExist>0){
        $row=$stmt->fetch();
        $user=[
            "id"=>$row["id"],
            "account"=>$row["account"],
            "name"=>$row["name"],
            "email"=>$row["email"],
            "headshots"=>$row["headshots"]
        ];
        //$_SESSION["cart"];  //定義新的key存session 較好管理要使用的資料 比如購物車
        $_SESSION["user"]=$user;
//        var_dump($_SESSION["user"]);
        unset($_SESSION["error_times"]); //登入成功，清除錯誤紀錄
        unset($_SESSION["error_msg"]);

        header("location: dashboard.php");  //登入完後紀錄完session導到頁面
    }else{
        $_SESSION["error_msg"]="帳號或密碼輸入錯誤";

        if(isset($_SESSION["error_times"])){
            $_SESSION["error_times"]=$_SESSION["error_times"]+1;
        }else{
            $_SESSION["error_times"]=1;
        }

        header("location: users-login.php");  //登不進去的話，停留在sign-in
    }
}catch (PDOException $e){
    echo $e->getMessage();
}