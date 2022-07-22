<?php
$host = '35.201.173.214';
$user = 'vincent';
$password = 'vincent';
$database = 'vincent';
$link = mysqli_connect($host, $user, $password, $database);
if ($link) {
    mysqli_query($link, 'SET NAMES utf8');
    // echo '正確連接';
} else {
    echo '無法連接' . mysqli_connect_error();
}
?>