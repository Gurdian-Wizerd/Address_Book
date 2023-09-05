<?php
$server="localhost";
$username="sam_cab";
$password="sam@123";
$db="sam_cab";
$conn=mysqli_connect($server, $username,$password,$db);
if(!$conn){
    die("connection faild".mysqli_connect_errno());
}
?>