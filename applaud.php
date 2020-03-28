<?php 

include("dbconnect.php");

$userid=$_POST["userid"];
$postid=$_POST["postid"];
$postuserid=$_POST["postuserid"];
$todo=$_POST["todo"];

if($todo==="insertapplaud")
{
    $query="insert into applaud values ($userid,$postid,$postuserid)";
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