<?php 

include("dbconnect.php");

$userid=$_REQUEST["userid"]; //this is the userid of the user currently logged in
$username="Username"; //$_REQUEST["username"] - this is the username of the user currently logged in

/*$query="select Name from users where userid=$userid";
$result=mysqli_query($conn,$query);
$resultforusername=mysqli_fetch_assoc($result);*/

$query="select userid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from enlighten inner join users where acceptorid=userid and requestorid=$userid and status='accepted' order by timeelapsed limit 50";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);
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
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- jQuery UI library 
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->

<link rel="stylesheet" href = "search.css"> 
<script src="search.js" type="text/javascript"></script>

<script type="text/javascript">

var isopen=0;

function createreqobj() {
    var xhttp;
    if (window.XMLHttpRequest) {
      // code for modern browsers
      xhttp = new XMLHttpRequest();
      } else {
      // code for IE6, IE5
      xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    return xhttp;
}

function opennotiholder()
{
  if(isopen==0)
  {
    document.getElementById("notiholder").style.visibility="visible";
    document.getElementById("notiholder").style.height="400px";
    document.getElementById("notiholder").style.opacity="1";
    /*document.getElementById("round").style.visibility="hidden";*/
    isopen=1;
  }

  else
  {
    document.getElementById("notiholder").style.visibility="hidden";
    document.getElementById("notiholder").style.height="0";
    document.getElementById("notiholder").style.opacity="0.5";
    isopen=0;
  }
}

function checkifapplauded(userid,postid,postuserid,count)
{  
  var checkapplaudobj=createreqobj(); //ajax object to check whether an announcement has been applauded or not

  checkapplaudobj.onreadystatechange = function() {

  if (this.readyState == 4 && this.status == 200 && this.responseText==="Already applauded") {
     document.getElementsByClassName("clap")[count].src="clapping_enabled.svg";
  }
  };

  var url="checkifapplauded.php?userid="+userid+"&postid="+postid+"&postuserid="+postuserid;
  checkapplaudobj.open("GET", url, true);
  checkapplaudobj.send();

  checkapplaudcount(postid,count);
}

function checkapplaudcount(postid,count)
{
  var checkapplaudcount=createreqobj();
  
  checkapplaudcount.onreadystatechange = function() {

  if (this.readyState == 4 && this.status == 200) {
     document.getElementsByClassName("countbox")[count].innerHTML=this.responseText;
  }
  };

  var url="checkapplaudcount.php?postid="+postid+"&datetime="+Date();

  checkapplaudcount.open("GET", url, true);
  checkapplaudcount.send();
}

</script>
</head>


<body onload=fillrequests(<?php echo $userid?>)>

<div id="overlay" onclick="closesearch()"></div>

<div id="notiholder">

<?php 
if($count==0)
{
?>
<div id="nonoti" style="margin-top:20px">No notifications!</div>
<?php
}
else
{
while($row=mysqli_fetch_assoc($result))
{ ?>

<div class="notibox">

You were enlightened by <?php echo $row["Name"]."!" ?>
<div class="notitime"><?php echo $row["time"] ?></div>

</div>

<?php 
}
} ?>

</div>


<div id="header"> <!--fixed header-->

<div id="logoholder">
<img id="logo" src="logo.png" height="42px" width="41px" alt="logo">
<div id="title">AXEL</div>
</div>

<div id="otherholder">

<!--<input id="searchbar" type="text" placeholder="Search for startups,mentors and people" spellcheck="false">
<img src="search.png" id="searchicon" alt="search">-->

<div class="searchbox">
            <input id="searchtext" type="text" autocomplete="off" spellCheck="false" placeholder="Search for startups,mentors and people">
            <a class="searchbtn" href="#">
            <img id="searchicon" src="search.png" alt="defaultimgholder.png"></a>
            <div class="searchlist">  
            </div>
</div>

<div id="userdetails">
    <img id="noti" src="notification.png" onclick="opennotiholder()"> <!--<div id="round"></div>-->
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
$query="select puserid,postid,Name, DATE_FORMAT(createdtime,'%d %M %Y | %h:%i %p') as createdtime, Announcement FROM post inner join users WHERE users.userID=post.PuserID and PuserID in (select AcceptorID from enlighten where requestorid=$userid and status='accepted') order by createdtime desc";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);
$temp=0;
?>

<div id="maindash">

    <div id="welcomeuser">Welcome <?php echo $username ?></div>
    <!--No posts to show-->

    <div class="label">Announcements</div>
    <hr width="95%">

    <?php 
    if($count==0)
    {
    ?>

        <div id="noposts">No announcements to show!&nbsp<a href="#">Click here</a>&nbspto explore startups and mentors!</div>

    <?php
    }
    ?>

    <div class="announcementsholder">

    <?php
    while($row=mysqli_fetch_assoc($result))
    { ?>
    

    <div class="announcementsinfo">

    <span id="idname">
    <div class="imgholder"><img src="avatar.png"></div>
    <?php echo $row['Name']; ?>
    <div class="countbox"></div>
    <img class="clap" src="clapping.svg" onclick="applaud(<?php echo $userid.','.$row['postid'].','.$row['puserid'].','.$temp ?>,event)"  height="25px" width="25px">
    </span>

    <?php echo '<script type="text/javascript">checkifapplauded('.$userid.','.$row['postid'].','.$row['puserid'].','.$temp.')</script>';?>

    <span id="createdtime"><?php echo $row['createdtime']; ?></span>
    <p><?php echo $row['Announcement']; ?></p>
    </div>

    <?php
    $temp++; 
    } ?>

  </div>

</div>


<div id="otherarea">

<span id="label">REQUESTS</span>

<div id="enlightenormentor">
<div id="enlightenbox">Enlighten</div>
<div id="mentorbox">Mentor</div>
</div>

<div id="enlightenholder">
</div>

<div id="mentorreqholder">
</div>

</div>

</div>

<script type="text/javascript">

function closesearch()
{
    document.getElementById("overlay").style.opacity="0";
    document.getElementById("overlay").style.zIndex="-1"; 
    $('.searchlist').fadeOut();  
}

</script>


<script src="dashboard.js" type="text/javascript"></script>

</body>
</html>