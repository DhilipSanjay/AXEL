<?php

include("dbconnect.php");

$userid=$_GET["userid"];
$postid=$_GET["postid"];
$postuserid=$_GET["postuserid"];

$query="select * from applaud where applauderid=$userid and postid=$postid and puserid=$postuserid";
$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)==1)
{
    echo "Already applauded";
}

else
{
    echo "Not applauded";
}

?>