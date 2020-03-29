<?php 

include("dbconnect.php");

$accept=$_POST["accept"];
$acceptorid=$_POST["acceptorid"];

if($accept=="enlightenment")
{
$requestorid=$_POST["requestid"];

$query="update enlighten set status='accepted',statuschangetime=NOW() where requestorid=$requestorid and acceptorid=$acceptorid";
mysqli_query($conn,$query);
}

else
{
$mentorid=$_POST["mentorid"];

$query="update mentorship set status='accepted',statuschangetime=NOW() where mentorid=$mentorid and startupid=$acceptorid";
mysqli_query($conn,$query);
}

?>