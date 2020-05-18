<?php 

include("dbconnect.php");

$userid = $_POST["userid"];

$ann = mysqli_real_escape_string($conn,$_POST["ann"]);

$query="insert into post(Puserid,Announcement) values ($userid,'$ann')";


if(!mysqli_query($conn,$query))
{
    echo "error";
}

else
{
    echo "success";
}

?>