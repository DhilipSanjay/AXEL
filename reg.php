<?php
include("dbconnect.php");
if(isset($_POST['Submit']))
{
    $userid =34;
    $link_count = 1;
    $link_insert = "";
    $link = "";
    if(isset($_POST['link'.$link_count.'']))
    {
        $link = mysqli_real_escape_string($conn,$_POST['link'.$link_count.'']);
    }
    
    while($link !== '')
    {
        $link_insert .= "INSERT INTO userlinks VALUES ($userid, '$link');";
        $link_count++;
        $link = "";
        if(isset($_POST['link'.$link_count.'']))
        {
            $link = mysqli_real_escape_string($conn,$_POST['link'.$link_count.'']);
        }
        if($link === '')
        {
            $link_count--;
        }
    }
    
    if($link_count === 1)
    {
        if($link_insert !== '')
        {
            if(mysqli_query($conn, $link_insert))
            {
                echo "Link inserted successfully";
            }
            else
            {
                echo "Error: Could not execute the query: " . mysqli_error($conn);
            }
        }
    }
    else if($link_count > 1)
    {
        if(mysqli_multi_query($conn, $link_insert))
        {
            echo "Links inserted successfully";
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($conn);
        }
    }
        }
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Register - Axel</title>
    <link rel="stylesheet" href="home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="register.js" type="text/javascript"></script>
</head>
<body>

<form action="" method="post"> 
<div id = "link_details">
            <div class="form-group">
                <label for="link1">Link 1</label>
                <input type="text" class="form-control" id="link1" name="link1" placeholder="Link 1">
            </div>
        </div>
        <div style="text-align:center;"><a href="javascript:void(0);" onclick="addLinks();">+Add more Links</a></div>
        <div class = "footer"><button type="submit" name="Submit" class="btn btn-modify">Submit</button></div>

    </form>
</body>

</html>