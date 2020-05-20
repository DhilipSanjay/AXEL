<?php 

include("dbconnect.php");

$userid=$_GET["userid"];
$postid=$_GET["postid"];
$postuserid=$_GET["postuserid"];
$todo=$_GET["todo"];

if($todo==="insertapplaud")
{
    $query="insert into applaud(applauderid,postid,puserid) values ($userid,$postid,$postuserid)";
    mysqli_query($conn,$query);
}

else if($todo==="deleteapplaud")
{
    $query="delete from applaud where applauderid=$userid and postid=$postid and puserid=$postuserid";
    mysqli_query($conn,$query);
}

else
{

}

?>