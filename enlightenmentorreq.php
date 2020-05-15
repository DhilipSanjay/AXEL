<?php

include("dbconnect.php");

$reqtype = $_POST["reqtype"];


if($reqtype==="enlighten")
{
    
    $reqid = $_POST["reqid"];
    $accid = $_POST["accid"];

    $checkquery = "select status from enlighten where requestorid=$reqid and acceptorid=$accid";
    $ex1 = mysqli_query($conn,$checkquery);
    $res1 = mysqli_fetch_assoc($ex1);

    if(mysqli_num_rows($ex1)===0&&$res1["status"]!=="accepted") //there is no request already given
    {
        $insertq = "insert into enlighten(requestorid,acceptorid,status) values ($reqid,$accid,'pending')";
        $exec = mysqli_query($conn,$insertq);

        if($exec)
        {
            echo "Request sent!";
        }

        else
        {
            echo "Error occured!";
        }
    }

    else
    {
        echo "Request already sent!";
    }
}

else
{
    $sid = $_POST["sid"];
    $mid = $_POST["mid"];

    $checkquery = "select status from mentorship where mentorid=$mid and startupid=$sid";
    $ex1 = mysqli_query($conn,$checkquery);
    $res1 = mysqli_fetch_assoc($ex1);

    if(mysqli_num_rows($ex1)===0&&$res1["status"]!=="accepted") //there is no request already given
    {
        $insertq = "insert into mentorship(mentorid,startupid,status) values ($mid,$sid,'pending')";
        $exec = mysqli_query($conn,$insertq);

        if($exec)
        {
            echo "Mentor Request sent!";
        }

        else
        {
            echo "Error occured!";
        }
    }

    else
    {
        echo "Request already sent!";
    }
}


?>