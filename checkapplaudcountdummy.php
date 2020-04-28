<?php

$servername="192.168.137.1";
$database="axel";
$username="root";
$password="";

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn)
{
    /*die("Connection error: " . mysqli_connect_errno());*/
    header('location:error.php');
}

$postid=$_GET["postid"];

$query="select count(applauderid) as count from applaud where postid=$postid";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);

echo $row["count"];

?>