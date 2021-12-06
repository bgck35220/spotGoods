<?php
require_once ("pdo-connect.php");

$name=$_POST["name"];
$email=$_POST["email"];
$id=$_POST["id"];
$phone=$_POST["phone"];
$file_name=$_SESSION["user"]["headshots"];
//echo $file_name."<br>";
//$file_name=$_FILES["myFile"]["name"];
//var_dump($file_name);
//exit();


if($_FILES["myFile"]["error"]===0 && !$_FILES["myFile"]["name"]==NULL){  //沒有錯誤，檔案上傳成功
    if(move_uploaded_file($_FILES["myFile"]["tmp_name"], "upload/".$_FILES["myFile"]["name"] )){  //且暫存檔案可以移動到上傳資料夾
        //組完要寫進資料庫的內容
        $file_name=$_FILES["myFile"]["name"];
        $_SESSION["user"]["headshots"]=$file_name;
    }else{
        echo "upload failed";
    }
}

$sql="UPDATE users SET email=?, name=?, phone=?, headshots=? WHERE id=?";
$stmt=$db_host->prepare($sql);

try{
    $stmt->execute([$email, $name, $phone, $file_name, $id]);
    header("location: dashboard.php");

}catch(PDOException $e){
    echo $e->getMessage();
}

$db_host=NULL;  //資料庫關閉連結
