<?php
if(!isset($_SESSION))
{
  session_start();
}

include("dbconnect.php");
include("session_check.php");

$userid=$_SESSION["userid"];
$desc = mysqli_real_escape_string($conn,$_POST["desc"]);

$poll_query = "INSERT into poll (pollhostid, description, heldon) VALUES ($userid, '$desc', curdate())";
if(mysqli_query($conn, $poll_query))
{
    echo "Poll inserted successfully";
}
else
{
    echo "Error: Could not execute the query: " . mysqli_error($conn);
}
// query to fetch the pollid
$query = "SELECT max(pollid) AS max FROM poll";
$result = mysqli_query($conn,$query);
$row = mysqli_fetch_array($result);
$pollid = $row['max'];

$poll_count = 1;
$polloption = "";
if(isset($_POST['option'.$poll_count.'']))
{
    $polloption = mysqli_real_escape_string($conn,$_POST['option'.$poll_count.'']);
}
$polloption_insert = "INSERT INTO polloption(pollid, pollhostid, choiceid, choice) VALUES (?,?,?,?)";
if($stmt = mysqli_prepare($conn, $polloption_insert))
{
    while($polloption !== '')
    {
        mysqli_stmt_bind_param($stmt,"iiis", $pollid, $userid, $poll_count, $polloption);
        if(mysqli_stmt_execute($stmt))
        {
            echo "Poll option $poll_count Inserted successfully";
            $poll_count++;
            $polloption = "";
            if(isset($_POST['option'.$poll_count.'']))
            {
                $polloption = mysqli_real_escape_string($conn,$_POST['option'.$poll_count.'']);
            }
            if($polloption === '')
            {
                $poll_count--;
            }
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($conn);
        }
    }
}
else
{
    echo "Error: Could not prepare the query: " . mysqli_error($conn);
}  
?>