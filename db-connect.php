<?php
session_start();
$servername="localhost";
$username="team01";
$password="V6RdHh9YioVtZzO";
$dbname="project01";

$conn=new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("連線失敗: ".$conn->connect_error);
}else{
//    echo "資料庫連線成功";
}

