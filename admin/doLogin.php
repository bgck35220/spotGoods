<?php

require("../pdo-connect.php");

if(isset($_POST['account'])||isset($_POST['password'])){
    $account=$_POST['account'];
    $password=$_POST['password'];
   
  
}else{
    header("location:adminLogin.php");
    exit();
}

$sqlAdmin="SELECT * FROM admin WHERE account=? AND password=?";
$stmtAdmin=$db_host->prepare($sqlAdmin);

try{
    $stmtAdmin->execute([$account,$password]);
    $userExist=$stmtAdmin->rowCount();
  
    if($userExist>0){
        $rowAdmin=$stmtAdmin->fetch();
        $user=[
            "id"=>$rowAdmin['id'],
            "name"=>$rowAdmin['name'],
            "account"=>$rowAdmin['account'],
            "password"=>$rowAdmin['email']
        ];
        $_SESSION["user"]=$user;
        header("location: admin.php");
        unset($_SESSION["error_times"]);
        unset($_SESSION["error_msg"]);
        echo $user;
    }
    else{
        $_SESSION['error_msg']="帳號或密碼輸入錯誤";
        if(isset($_SESSION["error_times"])){
            $_SESSION["error_times"]=$_SESSION["error_times"]+1;
        }else{
            $_SESSION["error_times"]=1;
        }
        header("location: adminLogin.php");
    }

}catch(PDOException $e){
    echo $e->getMessage();
}

?>