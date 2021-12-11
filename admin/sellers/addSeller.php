<?php



require_once("../../pdo-connect.php");

//待資料庫結構確認補上完整判斷
if(isset($_POST['contactperson'])||
isset($_POST['name'])||
isset($_POST['email'])||
isset($_POST['account'])||
isset($_POST['password'])||
isset($_POST['phone'])||
isset($_POST['address'])){
    $bossname=$_POST['bossname'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $account=$_POST['account'];
    $password=password_hash($_POST["password"],PASSWORD_DEFAULT);
    $phone=$_POST['name'];
    $address=$_POST['address'];
    $now =date("Y-m-d H:i:s");
    $valid=1;
    if($_FILES["myFile"]["error"]===0){
        if(move_uploaded_file($_FILES["myFile"]["tmp_name"], "../../sellers/sellersimg/sellersimg".$_FILES["myFile"]["name"] )){
            $file_name=$_FILES["myFile"]["name"];
        }
    }
}else{
    die("資料錯誤");
};
$input = array(
':bossname' => $bossname,
':name' => $name,
':email' => $email , 
':account' => $account,
':password' => $password,
':phone' => $phone,
':address'=>$address,
':cimg' =>$file_name,
':created_at' => $now,
 ':valid' => $valid);

$sql="INSERT INTO sellers(bossname,name,email,account,password,phone,address,certification_imgname,created_at,valid) 
VALUES(:bossname,:name,:email,:account,:password,:phone,:address,:cimg,:created_at,:valid)";

$stmt= $db_host->prepare($sql);
try{
    $stmt->execute($input);
    $userExist=$stmt->rowCount();
    header("location: sellers.php");

}catch(PDOException $e){
    echo $e->getMessage();
}
?>
