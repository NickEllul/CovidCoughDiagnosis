<!-----------------  Database Connection  ---------------->

<?php

$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'usersignup';

$con = mysqli_connect($server,$user,$pass,$db);

if (!$con) {

   die("<script>alert('Connection Failure')</script>");
}

?>


