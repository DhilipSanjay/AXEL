<?php

include("dbconnect.php");

$participantid = $_POST["pid"];
$contestid = $_POST["cid"];
$hostid = $_POST["hid"];

$query = "INSERT INTO participant VALUES ($participantid, $contestid, $hostid)";
$result = mysqli_query($conn, $query);

if($result)
{
    echo "Success";
}
else
{
    echo "Error"; //error
}

?>