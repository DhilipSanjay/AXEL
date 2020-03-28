<?php 

include("dbconnect.php");

$acceptorid=$_POST["acceptorid"];
$requestorid=$_POST["requestid"];

$query="update enlighten set status='accepted',statuschangetime=NOW() where requestorid=$requestorid and acceptorid=$acceptorid";
mysqli_query($conn,$query);
?>