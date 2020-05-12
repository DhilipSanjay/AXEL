<?php 

include("dbconnect.php");

$accept=$_GET["accept"];
$acceptorid=$_GET["acceptorid"];

if($accept=="enlightenment")
{
$requestorid=$_GET["requestid"];

$query="update enlighten set status='accepted',statuschangetime=NOW() where requestorid=$requestorid and acceptorid=$acceptorid";
mysqli_query($conn,$query);
}

else
{
$startupid=$_GET["startupid"];

$query="update mentorship set status='accepted',statuschangetime=NOW() where startupid=$startupid and mentorid=$acceptorid";
mysqli_query($conn,$query);
}

?>