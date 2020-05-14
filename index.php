<?php 

include("dbconnect.php"); 

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Home - Axel</title>
<link rel="stylesheet" href="home.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<script src="home.js" type="text/javascript"></script>
</head>
<body>
<div id="overlay" onclick="closesidebar()"></div>

<div id="menu">
<img id="close" src="close.png" onclick="closesidebar()">
    <a id="active">Home</a>
    <a href="about.php">What we do</a>
    <a href="contact.php">Get in touch</a>
    <a href="login.php">Login</a>
</div>

<div id="home">

<img id="logo" src="logo.png" height="47px" width="45px" alt="logo">
<div id="title">AXEL</div>
<img onclick="openlink('login.php')" id="user" src="user.png" alt="login">
<img id="listicon" onclick="opensidebar();" src="list.PNG" alt="picture">

<div id="maininfo">
    <div id="content">
     <div id="text">It's time to <p id="evolve">evolve.</p></div>
        <div id="info">
        Whether you are a budding startup looking for mentorship from the best experts or an experienced mentor with a 
        passion to guide startups, we are here to help you out.
        </div>

        <div id="buttonholder">
        <div class="button" onmouseover="highlightevolve()" onmouseout="dehighlightevolve()" onclick="openlink('login.php')">I am a startup</div>
        <div class="button" onmouseover="highlightevolve()" onmouseout="dehighlightevolve()" onclick="openlink('login.php')">I am a mentor</div>
        </div>

    </div>
</div>
</div>

<div id="others">

<?php

$query = "select Name as hostname,description,DATE_FORMAT(heldon,'%d %M %Y') as heldon,polloption.pollid,polloption.choiceid,choice,count(voterid) as votecount
from poll inner join users inner join polloption left join vote on polloption.choiceid=vote.choiceid and polloption.pollhostid=vote.pollhostid 
where poll.pollhostid=users.userid and poll.pollid=polloption.pollid group by polloption.pollid,polloption.choiceid having pollid=(select pollid from poll order by heldon desc limit 1)";

$total="select pollid,count(voterid) as totalcount from vote natural join poll group by pollid order by heldon desc limit 1"; //to get total no of votes for a poll to set percentage
$totalresult=mysqli_query($conn,$total);
$result=mysqli_query($conn,$query);

$totalnoofvotes=mysqli_fetch_assoc($totalresult);

$temp=1;
?>

<div class="label pollstitle">Poll of the day</div>

<div id="polls">

<?php
while($row=mysqli_fetch_assoc($result))
{

if($temp==1)
{
?>

<div class="createdby">
Poll hosted by <a href="#"><?php echo $row["hostname"]; ?></a>
</div>

<?php
echo $row["description"];
$temp++;
}
?>

<div class="polloption">

<?php echo $row["choice"]?>

<div class="countbox">
<?php echo floor(($row["votecount"]/$totalnoofvotes["totalcount"])*100)."%" ?>
</div>

</div>

<?php } ?>

<div id="signin">
Want to cast your opinion in the poll?&nbsp<a href="login.php">Sign in</a>&nbspnow!
</div>
</div>

<?php
$query="SELECT Name, DATE_FORMAT(createdtime,'%d %M %Y') as newcreatedtime, Announcement FROM post inner join users WHERE users.userID=post.PuserID ORDER BY createdtime DESC LIMIT 4";
$result=mysqli_query($conn,$query);
?>

<div class="label">Announcements</div>
<hr width="97.5%">
<div id="announcements">

<?php while($row=mysqli_fetch_assoc($result))
{ ?>

<div class="announcementsholder">
    <!--<div class="imgholder"></div>-->
<div class="announcementsinfo">
<span id="idname"><div class="imgholder"><img src="avatar.png"></div><?php echo $row['Name']; ?></span>
<span id="createdtime"><?php echo $row['newcreatedtime']; ?></span>
<p><?php echo $row['Announcement']; ?></p>
</div>
</div>

<?php } ?>

<div class="loadmore" onclick="openlink('announcements.php')">
Load More
</div>

</div>

<div class="label">News</div>

<?php
$query="SELECT title,minuteread,description,url FROM news ORDER BY createdtime desc LIMIT 4"; /*only first 4 rows will be selected*/
$result=mysqli_query($conn,$query);
?>

<div class="holder">

<div id="news">

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<div class="newsholder" onclick="gotourl('<?php echo $row['url']?>')">
<p class="newstitle"><?php echo $row['title']?></p>
<p class="minuteread"><?php echo $row['minuteread']?> minute read</p>
<hr class="line" width="90%">
<p class="description"><?php echo $row['description'].".."?></p>
</div>

<?php } ?>


<div class="loadmore new" onclick="openlink('news.php')">
Load More
</div>

</div>

</div>

<div class="holder contestsholder">

<div class="label contestlabel">Contests</div>
<hr width="97.5%" class="contestline">
<p id="desc">Check out some of the interesting contests hosted by enthusiastic startups!</p>

<?php
$query="SELECT Name,DATE_FORMAT(Heldon,'%d %M %Y') as HeldOn,Heldon as condate,Description FROM contest inner join users on contest.HostID=users.userID order by condate limit 4";
$result=mysqli_query($conn,$query);
$temp=1;
?>

<div id="contests">

<div class="box1">

<?php
while($row=mysqli_fetch_assoc($result)){
?>

<div class="cholder ch1">
<span class="label"><u>Hosted by:</u></span>
<p><?php echo $row['Name']; ?></p>
<span class="label"><u>Date:</u></span>
<p><?php echo $row['HeldOn']; ?></p>
<span class="label"><u>Description:</u></span>
<p><?php echo $row['Description']; ?></p>
</div>

<?php 
$temp++;

if($temp==3){
?>

</div>
<div class="box1 additional">

<?php
}
}
?>

</div>

<div id="loadmoreflex">
<div class="loadmore contestloadmore" onclick="openlink('contests.php')">
Load More
</div>
</div>

</div>


</div>

<div id="dummy"></div>


<div id="footer">
&#x00A9 Axel 2020 All copyrights reserved
</div>

</div>



<script type="text/javascript">

function opensidebar()
{ 
    if(document.body.offsetWidth<=798)
    {
    document.getElementById("menu").style.width="85%";
    }
    
    else{
    document.getElementById("menu").style.width="400px";
    }

    document.getElementById("overlay").style.opacity="0.5";
    document.getElementById("overlay").style.zIndex="2";  

}

function closesidebar()
{
    document.getElementById("menu").style.width="0";
    document.getElementById("overlay").style.opacity="0";
    document.getElementById("overlay").style.zIndex="-1";   
}

function gotourl(url)
{
    window.open(url, "_blank");
}
</script>
</body>
</html>