<?php
session_start();
unset($_SESSION["user"]);
header("location: admin-Login.php");