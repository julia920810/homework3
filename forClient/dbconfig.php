<?php
/*
連線資料庫用的副程式
*/
$host = 'localhost'; //執行DB Server 的主機
$user = 'root'; //登入DB用的DB 帳號
$pass = ''; //登入DB用的DB 密碼
$dbName = 'commodity'; //使用的商品資料庫名稱

/* $db 即為未來執行商品相關SQL指令所使用的物件 */
$db = mysqli_connect($host, $user, $pass, $dbName) or die('Error with MySQL connection for commodity');
mysqli_query($db, "SET NAMES utf8"); //設定商品資料庫編碼為 unicode utf8
?>
