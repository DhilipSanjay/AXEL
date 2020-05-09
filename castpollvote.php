<?php

include("dbconnect.php");

$optionid = $_POST["optionid"];
$userid = $_POST["userid"];
$pollid = $_POST["pollid"];
$pollhostid = $_POST["pollhostid"];

$query = "insert into vote(pollid,choiceid,voterid,pollhostid) values ($pollid,$optionid,$userid,$pollhostid)";
$result  = mysqli_query($conn,$query);

if(!$result)
{
    echo "Error";
}

else
{
    echo "Success";  
}

?>