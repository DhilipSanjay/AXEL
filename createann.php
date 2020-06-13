<?php 

include("dbconnect.php");

$userid = $_POST["userid"];

$ann = mysqli_real_escape_string($conn,$_POST["ann"]); //escapes characters like ','',` etc...
$ann = htmlspecialchars($ann); //used to escape html characters like <,> etc...

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