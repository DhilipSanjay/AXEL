<?php
if(!isset($_SESSION))
{
  session_start();
}

include("dbconnect.php");
include("session_check.php");

$userid=$_SESSION["userid"];
$desc = mysqli_real_escape_string($conn,$_POST["desc"]);

?>