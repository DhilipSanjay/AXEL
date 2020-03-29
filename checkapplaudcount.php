<?php

include("dbconnect.php");

$postid=$_GET["postid"];

$query="select count(applauderid) as count from applaud where postid=$postid";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);

echo $row["count"];

?>