<?php
if(!isset($_SESSION))
{
session_start();
}
if(!isset($_SESSION['logged_in']))
{
    header("location: login.php?type=any");
}
?>