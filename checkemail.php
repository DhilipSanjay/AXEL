<?php 

include("dbconnect.php");

$email = $_GET["email"];

$query="select email from users where email='$email'";
$ex = mysqli_query($conn,$query);

if($ex)
{

if(mysqli_num_rows($ex)===0)
{
    echo "success";
}

else
{
    echo "failure";
}
}

else
{
    echo "Error!";
}
?>