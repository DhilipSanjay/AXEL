<?php 

include("dbconnect.php");

$hostid = $_POST["hostid"];
$link = $_POST["link"];
$date = $_POST["date"];

$desc = mysqli_real_escape_string($conn,$_POST["desc"]);

$query="insert into contest(Hostid,HeldOn,Description,ContestLink) values ($hostid,STR_TO_DATE('$date', '%d-%c-%Y'),'$desc','$link')";

if(!mysqli_query($conn,$query))
{
    echo "error";
}

else
{
    echo "success";
}
?>