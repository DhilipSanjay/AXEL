<?php 

include("dbconnect.php");

$acceptorid=$_POST["acceptorid"];
$requestorid=$_POST["requestid"];

$query="update enlighten set status='accepted' where requestorid=$requestorid and acceptorid=$acceptorid ";
$result=mysqli_query($conn,$query);
?>