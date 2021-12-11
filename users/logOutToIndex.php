<?php
session_start(); //使用session前，一定要加這行，存、取都要加
unset($_SESSION["user"]);
header("location: index.php");
