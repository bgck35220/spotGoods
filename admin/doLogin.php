<?php

require("../pdo-connect.php");

if(isset($_POST['account'])||isset($_POST['password'])){
    $account=$_POST['account'];
    $password=$_POST['password'];
   
  
}else{
    header("location:admin-Login.php");
    exit();
}

$sqlAdmin="SELECT * FROM admin WHERE account=? ";
$stmtAdmin=$db_host->prepare($sqlAdmin);

try{
    $stmtAdmin->execute([$account]);
    $userExist=$stmtAdmin->rowCount();
  
    if($userExist>0){
        $rowAdmin=$stmtAdmin->fetch();
        if(password_verify($password,$rowAdmin['password'])){
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
           }else{
            $_SESSION['error_msg']="帳號或密碼輸入錯誤";
            if(isset($_SESSION["error_times"])){
                $_SESSION["error_times"]=$_SESSION["error_times"]+1;
            }else{
                $_SESSION["error_times"]=1;
            }
            header("location: admin-Login.php");
            };
     
    }
    else{
        $_SESSION['error_msg']="帳號或密碼輸入錯誤";
        if(isset($_SESSION["error_times"])){
            $_SESSION["error_times"]=$_SESSION["error_times"]+1;
        }else{
            $_SESSION["error_times"]=1;
        }
        header("location: admin-Login.php");
    }

}catch(PDOException $e){
    echo $e->getMessage();
}

?>