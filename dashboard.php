<?php 

include("dbconnect.php");

$userid=3; //this is the userid of the user currently logged in
$query="select Name from users where userid=$userid";
$result=mysqli_query($conn,$query);
$resultforusername=mysqli_fetch_assoc($result);
?>

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

<div id="logoholder">
<img id="logo" src="logo.png" height="42px" width="41px" alt="logo">
<div id="title">AXEL</div>
</div>

<div id="otherholder">
<input id="searchbar" type="text" placeholder="Search for startups,mentors and people" spellcheck="false">
<img src="search.png" id="searchicon" alt="search">

<div id="userdetails">
    <img id="noti" src="notification.png">
    <img id="userdp" src="avatar.png">
</div>

</div>

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

<?php
$query="select Name, DATE_FORMAT(createdtime,'%d %M %Y') as createdtime, Announcement FROM post inner join users WHERE users.userID=post.PuserID and PuserID in (select AcceptorID from enlighten where requestorid=$userid and status='accepted') order by createdtime desc";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);
?>

<div id="maindash">

    <div id="welcomeuser">Welcome <?php echo $resultforusername["Name"] ?></div>
    <!--No posts to show-->

    <div class="label">Announcements</div>
    <hr width="95%">

    <?php 
    if($count==0)
    {
    ?>

        <div id="noposts">No posts to show!&nbsp<a href="#">Click here</a>&nbspto explore startups and mentors!</div>

    <?php
    }
    while($row=mysqli_fetch_assoc($result))
    { ?>

    <div class="announcementsholder">

    <div class="announcementsinfo">
    <span id="idname"><div class="imgholder"><img src="avatar.png"></div><?php echo $row['Name']; ?></span>
    <span id="createdtime"><?php echo $row['createdtime']; ?></span>
    <p><?php echo $row['Announcement']; ?></p>
    </div>

    </div>

    <?php } ?>

</div>

<?php
$query="select requestorid,Name from enlighten inner join users where userID=requestorID and acceptorid=$userid and status='pending'";
$result=mysqli_query($conn,$query);
?>

<div id="otherarea">

<span id="label">REQUESTS</span>

<?php
while($row=mysqli_fetch_assoc($result))
{ ?>

<div class="reqbox">
<div class="content"><a href="#"><?php echo $row["Name"] ?></a> <?php echo $row["Name"] ?> wants to be enlightened by you</div>
<div class="acceptbutton" onclick='accept(<?php echo $row["requestorid"].",".$userid ?>,event)'>Accept</div>
</div>

<div class="reqbox">
<div class="content"><a href="#"><?php echo $row["Name"] ?></a> <?php echo $row["Name"] ?> wants to be enlightened by you</div>
<div class="acceptbutton" onclick='accept(<?php echo $row["requestorid"].",".$userid ?>,event)'>Accept</div>
</div>

<?php } ?>

</div>


</div>



</body>

<script src="dashboard.js" type="text/javascript"></script>
</html>