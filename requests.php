<?php

include("dbconnect.php");
$userid=$_POST["userid"];
$reqtype=$_POST["reqtype"];


if($reqtype=="enlightenreq")
{
$query="select requestorid,Name,statuschangetime from enlighten inner join users where userID=requestorID and acceptorid=$userid and status='pending' order by statuschangetime desc limit 40"; //a limit has been set as to how many requests has to be shown (40 requests only)
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);
$output='';

if($count==0)
{

$output .= '<div id="noreq" style="margin-top:20px">No requests!</div>';

}

else
{
/*$output .= '<span id="label">REQUESTS</span>';*/

while($row=mysqli_fetch_assoc($result))
{ 

$output .= '<div class="reqbox"><div class="content"><a href="#">'.'Request from '.$row["Name"]."</a>".$row["Name"].' wants to be enlightened by you!</div><div class="acceptbutton"'."onclick='accept(".$row["requestorid"].",".$userid.",event)'>Accept</div></div>";

}

$output .= "</div>";

}

echo $output;
}

else
{
$query="select mentorid,Name,statuschangetime from mentorship inner join users where userID=mentorID and startupid=$userid and status='pending' order by statuschangetime desc limit 40"; //a limit has been set as to how many requests has to be shown (40 requests only)
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);
$output='';
    
if($count==0)
{
    
$output .= '<div id="noreq" style="margin-top:20px">No requests from mentors!</div>';
    
}

else
{
/*$output .= '<span id="label">REQUESTS</span>';*/

while($row=mysqli_fetch_assoc($result))
{ 

$output .= '<div class="reqbox"><div class="content"><a href="#">'.'Request from '.$row["Name"]."</a>".$row["Name"].' wants to be your mentor!</div><div class="acceptbutton"'."onclick='acceptasmentor(".$row["mentorid"].",".$userid.",event)'>Accept as Mentor</div></div>";

}

$output .= "</div>";

}

echo $output;



}


?>