<?php

session_start();
include("dbconnect.php");

$userid=$_SESSION["userid"];
$usertype = $_SESSION['usertype'];

if($usertype==="startup")
{
    // $mentornotiquery="select notificationread from mentorship 
    // inner join users where mentorid=userid and startupid=$userid and status='accepted' and notificationread=0 order by statuschangetime desc limit 50";

    $mentornotiquery = "update mentorship set notificationread=1 where startupid=$userid and status='accepted' and notificationread=0";
    $mentornotiresult=mysqli_query($conn,$mentornotiquery);
}


$query="update enlighten set notificationread=1 where requestorid=$userid and status='accepted' and notificationread=0";
$result=mysqli_query($conn,$query);

if($usertype==="startup"&&$result&&$mentornotiresult)
{
    echo "success";
}

else if($usertype!=="startup"&&$result)
{
    echo "success";
}

else
{
    echo "error";
}


?>