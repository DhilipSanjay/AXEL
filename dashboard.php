<?php include("dbconnect.php") ?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Axel - Dashboard</title>
<link rel="stylesheet" href="home.css">
<link rel="stylesheet" href="dashboard.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
</head>

<body>

<div id="header"> <!--fixed header-->
<img id="logo" src="logo.png" height="42px" width="41px" alt="logo">
<div id="title">AXEL</div>
</div>

<div id="dashboard">
<div id="sidenavbar">
    <!--<div id="dummy"></div>-->
    <a id="active">Dashboard</a>
    <a href="#">My Profile</a>
    <a href="#">Explore</a>
    <a href="#">Connect</a>
    <a href="#">News</a>
    <a href="#">Polls</a>
    <a href="#">Contests</a>
    <!--<div id="dummy"></div>-->
</div>

<div id="maindash">
    This is the main page
</div>

<div id="otherarea">
    This is the extra area
</div>


</div>



</body>

<script src="dashboard.js" type="text/javascript"></script>
</html>