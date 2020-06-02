<?php
session_start();

include("dbconnect.php");

$userid=$_SESSION["userid"]; //this is the userid of the user currently logged in

$logoutquery = "update users set lastloggedtime=CURRENT_TIMESTAMP() where userid=$userid";
$result=mysqli_query($conn,$logoutquery);

if($result)
{
if(session_destroy()) {
        header("Location: index.php");
}
}
?>

<!-- 
    Include this button in place of logout
    Note: Modify the action properly

<form id="logout" action="Login/logout.php" method ="post">
    <button type="submit" name="logout" class="btn btn-primary">Logout</button>
</form> 

-->