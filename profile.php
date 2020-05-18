<?php 

if(!isset($_SESSION))
{
  session_start();
}

include("dbconnect.php");
include("session_check.php");
$userid=$_REQUEST["userid"]; //this is the userid of the user currently logged in | use request here

$query="select Name,usertype from users where userid=$userid";
$result=mysqli_query($conn,$query);
$resultforusername=mysqli_fetch_assoc($result);

$name = $resultforusername["Name"];
$usertype = $resultforusername["usertype"];

$sessionuserid = $_SESSION["userid"];
$sessionusertype = $_SESSION["usertype"];


//if user type is a startup then show mentor request accepted notifications in notifications box
if($sessionusertype==="startup")
{
$mentornotiquery="select mentorid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from mentorship inner join users where mentorid=userid and startupid=$sessionuserid and status='accepted' order by timeelapsed limit 50";
$mentornotiresult=mysqli_query($conn,$mentornotiquery);
$mentornoticount=mysqli_num_rows($mentornotiresult);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title><?php echo $name."'s " ?>Profile - Axel</title>
<link rel="stylesheet" href="profile.css"> 
<link rel="stylesheet" href="common.css"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- jQuery UI library -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href = "search.css"> 
<script src="search.js" type="text/javascript"></script>
<script src="profile.js" type="text/javascript"></script>
</head>

<style>
html
{
  overflow-y: scroll;
}

#logout
{
    cursor:pointer;
    background-color:#35A18C;
    color:white;
    border:none;
    font-size:1.2rem;
    text-align:center;
    position:fixed;
    bottom:0;
    width:22.5%;
    padding:10px 0;
}

</style>

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
  if(reqboxopen==1)
  {
    openclosereqbox();
  }
  
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

<body>

<div id="overlay" onclick="closesearch()"></div>
<div id="overlay" class="fortopbuttons"></div>

<div id="notiholder">

<?php 

$query="select userid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from enlighten inner join users where acceptorid=userid and requestorid=$sessionuserid and status='accepted' order by timeelapsed limit 50";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);


if( ($sessionusertype==="mentor"&&$count===0) || ($count===0&&$sessionusertype==="startup"&&$mentornoticount===0) )
{
?>
<div id="nonoti" style="margin-top:20px">No notifications!</div>
<?php
}

else
{

if($sessionusertype==="startup")
{

while($row=mysqli_fetch_assoc($mentornotiresult))
{?>

<div class="notibox">
<?php echo $row["Name"]?> accepted to be your mentor!
<div class="notitime"><?php echo $row["time"] ?></div>
</div>

<?php
}

if($mentornoticount!==0)
{
?>

<div style="border:none;border-bottom:0.5px solid #c0c0c0;width:90%;margin:10px 0"></div>

<?php
}

}

if($count===0)
{
?>

<div id="nonoti" style="margin-top:20px">No enlighten notifications!</div>

<?php
}

while($row=mysqli_fetch_assoc($result))
{ ?>

<div class="notibox">

You were enlightened by <?php echo $row["Name"]."!" ?>
<div class="notitime"><?php echo $row["time"] ?></div>

</div>

<?php 
}
?>
<div style="border:none;border-bottom:0.5px solid #f2f3f4;width:90%;margin:10px 0"></div>

<?php
} 
?>

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
           <!--img id="searchicon" src="search.png" alt="defaultimgholder.png">-->
           <svg class="bi bi-search" id="searchicon" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="black" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 011.415 0l3.85 3.85a1 1 0 01-1.414 1.415l-3.85-3.85a1 1 0 010-1.415z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 100-11 5.5 5.5 0 000 11zM13 6.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" clip-rule="evenodd"/>
            </svg></a>
            <div class="searchlist">  
            </div>
</div>

<div id="userdetails">

  <svg  id="noti" onclick="opennotiholder()" class="bi bi-bell" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="#76D7C4" xmlns="http://www.w3.org/2000/svg">
  <path d="M8 16a2 2 0 002-2H6a2 2 0 002 2z"/>
  <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 004 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 00-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 111.99 0A5.002 5.002 0 0113 6c0 .88.32 4.2 1.22 6z" clip-rule="evenodd"/>
  </svg>

  <img id="userdp" src="avatar.png">
</div>

</div>

</div>

<div id="dashboard">

<div id="sidenavbar">
    <!--<div id="dummy"></div>-->
    <a href="dashboard.php">
    <svg class="bi bi-columns-gap" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M6 1H1v3h5V1zM1 0a1 1 0 00-1 1v3a1 1 0 001 1h5a1 1 0 001-1V1a1 1 0 00-1-1H1zm14 12h-5v3h5v-3zm-5-1a1 1 0 00-1 1v3a1 1 0 001 1h5a1 1 0 001-1v-3a1 1 0 00-1-1h-5zM6 8H1v7h5V8zM1 7a1 1 0 00-1 1v7a1 1 0 001 1h5a1 1 0 001-1V8a1 1 0 00-1-1H1zm14-6h-5v7h5V1zm-5-1a1 1 0 00-1 1v7a1 1 0 001 1h5a1 1 0 001-1V1a1 1 0 00-1-1h-5z" clip-rule="evenodd"/>
    </svg>Dashboard</a>



    
<?php if($userid===$_SESSION["userid"]) //profile of logged in user
{
?>
 <a id="active">
    <svg class="bi bi-person-square" style="margin-right:15px"  width="1em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
    <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
    </svg>My Profile</a>

<?php
}

else
{
?>

<a href="<?php echo "profile.php?userid=".$_SESSION["userid"] ?>">
    <svg class="bi bi-person-square" style="margin-right:15px"  width="1em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
    <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
    </svg>My Profile</a>


<?php } ?>

    <a href="explore.php">
    <svg class="bi bi-book-half" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 018.5 2.5v11a.5.5 0 01-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 010 13.5v-11a.5.5 0 01.276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 01.22-.103 12.958 12.958 0 012.7-.869zM1 2.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V2.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 001 2.82z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 007.5 2.5v11a.5.5 0 00.854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0016 13.5v-11a.5.5 0 00-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 00-.799-.34 12.96 12.96 0 00-2.073-.609z" clip-rule="evenodd"/>
</svg>Explore</a>
    <a href="#">
    <svg class="bi bi-chat-dots" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 01.287.801 10.97 10.97 0 01-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 01.71-.074A8.06 8.06 0 008 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 01-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 00.244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 01-2.347-.306c-.52.263-1.639.742-3.468 1.105z" clip-rule="evenodd"/>
  <path d="M5 8a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0z"/>
</svg>Connect</a>
    <a href="news.php">
    <svg class="bi bi-newspaper" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M0 2A1.5 1.5 0 011.5.5h11A1.5 1.5 0 0114 2v12a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 010 14V2zm1.5-.5A.5.5 0 001 2v12a.5.5 0 00.5.5h11a.5.5 0 00.5-.5V2a.5.5 0 00-.5-.5h-11z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M15.5 3a.5.5 0 01.5.5V14a1.5 1.5 0 01-1.5 1.5h-3v-1h3a.5.5 0 00.5-.5V3.5a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
  <path d="M2 3h10v2H2V3zm0 3h4v3H2V6zm0 4h4v1H2v-1zm0 2h4v1H2v-1zm5-6h2v1H7V6zm3 0h2v1h-2V6zM7 8h2v1H7V8zm3 0h2v1h-2V8zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1zm-3 2h2v1H7v-1zm3 0h2v1h-2v-1z"/>
</svg>News</a>
    <a href="polls.php">
    <svg class="bi bi-clipboard-data" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 00-2 2V14a2 2 0 002 2h10a2 2 0 002-2V3.5a2 2 0 00-2-2h-1v1h1a1 1 0 011 1V14a1 1 0 01-1 1H3a1 1 0 01-1-1V3.5a1 1 0 011-1h1v-1z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h3a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5zm-3-1A1.5 1.5 0 005 1.5v1A1.5 1.5 0 006.5 4h3A1.5 1.5 0 0011 2.5v-1A1.5 1.5 0 009.5 0h-3z" clip-rule="evenodd"/>
  <path d="M4 11a1 1 0 112 0v1a1 1 0 11-2 0v-1zm6-4a1 1 0 112 0v5a1 1 0 11-2 0V7zM7 9a1 1 0 012 0v3a1 1 0 11-2 0V9z"/>
</svg>Polls</a>
    <a href="contests.php">
    <svg class="bi bi-award" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M9.669.864L8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193l-1.51-.229L8 1.126l-1.355.702-1.51.229-.684 1.365-1.086 1.072L3.614 6l-.25 1.506 1.087 1.072.684 1.365 1.51.229L8 10.874l1.356-.702 1.509-.229.684-1.365 1.086-1.072L12.387 6l.248-1.506-1.086-1.072-.684-1.365z" clip-rule="evenodd"/>
  <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
</svg>Contests</a>
    <!--<div id="dummy"></div>-->
    <div id="logout" onclick="logout()">Logout</div>
</form>
</div>






<div id="maindash">

<!-- Announcements box -->





<?php if($usertype==="startup")
{
    
$query1 = "select dp,name,location,founder,field,phoneno from users inner join startup where userid=startupid and userid=$userid";
$ex1 = mysqli_query($conn,$query1);
$res1 = mysqli_fetch_assoc($ex1);


$isenlightenedquery = "select count(acceptorid) as count from enlighten where requestorid=$sessionuserid and acceptorid=$userid and status='accepted'";
$exquery = mysqli_query($conn,$isenlightenedquery);
$exres = mysqli_fetch_assoc($exquery);

$isenlightened=$exres["count"];
?>


<div id=topinfo>

<div id="dp">
<img src="<?php echo $res1["dp"] ?>" style="object-fit:cover">
</div>


<div id="maindetails">
<p><span class="value" style="font-size:2em"><?php echo $res1["name"] ?></span></p>
<p style="color:#ccc;font-style:italic;margin-bottom:30px">Startup</p>
<p>Founder - <span class="value"><?php echo $res1["founder"] ?></span></p>
<p>Location - <span class="value"><?php echo $res1["location"] ?></span></p>
<p>Field - <span class="value"><?php echo $res1["field"] ?></span></p>
</div>

<?php if($userid!==$_SESSION["userid"]&&$isenlightened!=1) //not profile of logged in user and not already enlightened
{?>
<div id="enlightenbut">
<div style="display:flex;flex-direction:column;align-items:center;cursor:pointer" onclick="enlreq(<?php echo $sessionuserid.','.$userid ?>)">
    <img src="eng.png" height="35px" alt="enlighten">
    <p>Enlighten</p>
      </div>
</div>

<?php } ?>
</div>

<?php if($userid===$_SESSION["userid"]) //profile of logged in user
{?>
<div id="select">
<div id="s1" onclick="toggle(1)">Profile</div>
<div id="s2" onclick="toggle(2)">My Announcements</div>
</div>

<?php } ?>


<div id="otherinfo">

<?php
$query ="select membername,designation from members where startupid=$userid";
$ex = mysqli_query($conn,$query);
?>

<div class="contents">
<p style="font-size:1.5rem;color:#76D7C4">Team Members</p>
<hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

<div id="membergrid">

<?php while($res = mysqli_fetch_assoc($ex))
{?>

<div class="member">
<p>Name - <span class="value"><?php echo $res["membername"] ?></span></p>
<p>Designation - <span class="value"><?php echo $res["designation"] ?></span></p>
</div>

<?php } ?>

</div>

</div>


<?php
$query ="select links from userlinks where userid=$userid";
$ex = mysqli_query($conn,$query);
?>


<div class="contents">
<p style="font-size:1.5rem;color:#76D7C4">Connect</p>
<hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

<div id="contactgrid">

<div class="contact">
<p>Phone number - <span class="value"><?php echo $res1["phoneno"] ?></span></p>
</div>

<?php

while($res = mysqli_fetch_assoc($ex))
{
?>

<div class="contact">
<p><a href="<?php echo $res["links"] ?>" style="color: #76D7C4"><?php echo $res["links"] ?></a></p>
</div>

<?php } ?>

</div>

</div>


<?php
$query = "select name,field from mentorship inner join users inner join mentor where mentorship.mentorid=mentor.mentorid and userid=mentor.mentorid and startupid=$userid and status='accepted'";
$ex = mysqli_query($conn,$query);
?>

<div class="contents">
<p style="font-size:1.5rem;color:#76D7C4">Mentors</p>
<hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

  <?php if(mysqli_num_rows($ex)===0)
    {
    ?>
    No mentors have been assigned yet!
    <?php
    }
    ?>


<div id="membergrid">

<?php while($res = mysqli_fetch_assoc($ex))
{?>

<div class="member">
<p>Name - <span class="value"><?php echo $res["name"] ?></span></p>
<p>Field - <span class="value"><?php echo $res["field"] ?></span></p>
</div>

<?php } ?>

</div>

</div>





</div>


<?php
}

else if($usertype==="mentor")
{
    $query1 = "select dp,name,location,field,phoneno from users inner join mentor where userid=mentorid and userid=$userid";
    $ex1 = mysqli_query($conn,$query1);
    $res1 = mysqli_fetch_assoc($ex1);

    $isenlightenedquery = "select count(acceptorid) as count from enlighten where requestorid=$sessionuserid and acceptorid=$userid and status='accepted'";
    $exquery = mysqli_query($conn,$isenlightenedquery);
    $exres = mysqli_fetch_assoc($exquery);

    $isenlightened=$exres["count"];
    
    $ismentorquery = "select count(mentorid) as count from mentorship where startupid=$sessionuserid and mentorid=$userid and status='accepted'";
    $menquery = mysqli_query($conn,$ismentorquery);
    $menres = mysqli_fetch_assoc($menquery);

    $ismentor=$menres["count"];
?>
    
    
    <div id=topinfo>
    
    <div id="dp">
    <img src="<?php echo $res1["dp"] ?>" style="object-fit:cover">
    </div>
    
    
    <div id="maindetails">
    <p><span class="value" style="font-size:2em"><?php echo $res1["name"] ?></span></p>
    <p style="color:#ccc;font-style:italic;margin-bottom:30px">Mentor</p>
    <p>Location - <span class="value"><?php echo $res1["location"] ?></span></p>
    <p>Field - <span class="value"><?php echo $res1["field"] ?></span></p>
    </div>

    <?php if($userid!==$_SESSION["userid"]) //not profile of logged in user
    {
    ?>

    <div id="enlightenbut">
    <?php if($isenlightened!=1){?>
      <div style="display:flex;flex-direction:column;align-items:center;cursor:pointer" onclick="enlreq(<?php echo $sessionuserid.','.$userid ?>)">
    <img src="eng.png" height="35px" alt="enlighten">
    <p>Enlighten</p>
      </div>

    <?php } 
    
    if($ismentor!=1&&$_SESSION["usertype"]!=="general"&&$_SESSION["usertype"]!=="mentor"){
    ?>

    <div style="display:flex;flex-direction:column;align-items:center;cursor:pointer;margin-top:5px" onclick="mentorreq(<?php echo $sessionuserid.','.$userid ?>)">
    <svg class="bi bi-person-plus-fill" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 100-6 3 3 0 000 6zm7.5-3a.5.5 0 01.5.5v2a.5.5 0 01-.5.5h-2a.5.5 0 010-1H13V5.5a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
     <path fill-rule="evenodd" d="M13 7.5a.5.5 0 01.5-.5h2a.5.5 0 010 1H14v1.5a.5.5 0 01-1 0v-2z" clip-rule="evenodd"/>
    </svg>
    <p>Request</p>
    </div>

    <?php }?>
    </div>
    <?php
    } 
    ?>

    </div>
    
    
    <?php if($userid===$_SESSION["userid"]) //profile of logged in user
    {?>
    <div id="select">
    <div id="s1" onclick="toggle(1)">Profile</div>
    <div id="s2" onclick="toggle(2)">My Announcements</div>
    </div>
    
    <?php } ?>
    
    
    <div id="otherinfo">
    
    <?php
    $query ="select qualification from mentorqual where mentorid=$userid";
    $ex = mysqli_query($conn,$query);
    ?>
    
    <div class="contents">
    <p style="font-size:1.5rem;color:#76D7C4">Qualification</p>
    <hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">
    
    <div id="membergrid">
    
    <?php while($res = mysqli_fetch_assoc($ex))
    {?>
    
    <div class="member">
    <p><span class="value" style="color:black"><?php echo $res["qualification"] ?></span></p>
    </div>
    
    <?php } ?>
    
    </div>
    
    </div>
    
    
    <?php
    $query ="select links from userlinks where userid=$userid";
    $ex = mysqli_query($conn,$query);
    ?>
    
    
    <div class="contents">
    <p style="font-size:1.5rem;color:#76D7C4">Connect</p>
    <hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">
    
    <div id="contactgrid">
    
    <div class="contact">
    <p>Phone number - <span class="value"><?php echo $res1["phoneno"] ?></span></p>
    </div>
    
    <?php
    
    while($res = mysqli_fetch_assoc($ex))
    {
    ?>
    
    <div class="contact">
    <p><a href="<?php echo $res["links"] ?>" style="color: #76D7C4"><?php echo $res["links"] ?></a></p>
    </div>
    
    <?php } ?>
    
    </div>
    
    </div>
    
    
    <?php
    $query = "select name,field from mentorship inner join users inner join startup where startup.startupid=mentorship.startupid and userid=startup.startupid and mentorid=$userid and status='accepted'";
    $ex = mysqli_query($conn,$query);
    ?>
    
    <div class="contents">
    <p style="font-size:1.5rem;color:#76D7C4">Startups mentoring</p>
    <hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

    <?php if(mysqli_num_rows($ex)===0)
    {
    ?>
    No startups being mentored yet!
    <?php
    }
    ?>

    <div id="membergrid">
    
    <?php while($res = mysqli_fetch_assoc($ex))
    {?>
    
    <div class="member">
    <p>Name - <span class="value"><?php echo $res["name"] ?></span></p>
    <p>Field - <span class="value"><?php echo $res["field"] ?></span></p>
    </div>
    
    <?php } ?>
    
    </div>
    
    </div>
    
    
    
    
    
    </div>




































<?php
}

else
{

    $query1 = "select dp,name,designation,location,phoneno from users inner join generaluser where userid=generaluserid and userid=$userid";
    $ex1 = mysqli_query($conn,$query1);
    $res1 = mysqli_fetch_assoc($ex1);
    
?>
    
    
    <div id=topinfo>
    
    <div id="dp">
    <img src="<?php echo $res1["dp"] ?>" style="object-fit:cover">
    </div>
    
    
    <div id="maindetails">
    <p><span class="value" style="font-size:2em"><?php echo $res1["name"] ?></span></p>
    <p style="color:#ccc;font-style:italic;margin-bottom:30px">General User</p>
    <p>Location - <span class="value"><?php echo $res1["location"] ?></span></p>
    <p>Designation - <span class="value"><?php echo $res1["designation"] ?></span></p>
    </div>
    
    </div>
    
    
    <div id="otherinfo">
    
    <?php
    $query ="select links from userlinks where userid=$userid";
    $ex = mysqli_query($conn,$query);
    ?>
    
    
    <div class="contents">
    <p style="font-size:1.5rem;color:#76D7C4">Connect</p>
    <hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">
    
    <div id="contactgrid">
    
    <div class="contact">
    <p>Phone number - <span class="value"><?php echo $res1["phoneno"] ?></span></p>
    </div>
    
    <?php
    
    while($res = mysqli_fetch_assoc($ex))
    {
    ?>
    
    <div class="contact">
    <p><a href="<?php echo $res["links"] ?>" style="color: #76D7C4"><?php echo $res["links"] ?></a></p>
    </div>
    
    <?php } ?>
    
    </div>
    
    </div>
    
    
    </div>
    
    </div>
    
    
    
    
    
    </div>















<?php
}
?>



<div id="holder">
<?php 

$anquery ="select puserid,postid,Name, DATE_FORMAT(createdtime,'%d %M %Y | %h:%i %p') as createdtime,
 Announcement FROM post inner join users WHERE users.userID=post.puserid and userid=$userid order by createdtime desc";

$anex = mysqli_query($conn,$anquery);
$temp=0;
$count = mysqli_num_rows($anex);

if($count===0)
{
?>

    <div style="text-align:center;width:100%;font-size:1.2rem;margin-top:15px">No announcements made yet!</div>

<?php
}
?>

<div class="announcementsholder" style="width:100%">

<?php
while($row=mysqli_fetch_assoc($anex))
{ ?>
 

<div class="announcementsinfo">

<span id="idname">
<div class="imgholder"><img src="avatar.png"></div>
<?php echo $row['Name']; ?>
<div class="countbox"></div>
<img class="clap" src="clapping.svg" height="25px" width="25px" style="cursor:default">
</span>

<?php echo '<script type="text/javascript">checkapplaudcount('.$row['postid'].",".$temp.')</script>';?>

<span id="createdtime"><?php echo $row['createdtime']; ?></span>
<p><?php echo $row['Announcement']; ?></p>
</div>

<?php
$temp++; 
} ?>

</div>

</div>
























</div>



































<script type="text/javascript">

var searchlistwidth = document.getElementsByClassName("searchbox")[0].clientWidth-20;
document.getElementsByClassName("searchlist")[0].style.width=searchlistwidth+"px";

var reqboxopen=0;

function closesearch()
{
    document.getElementById("overlay").style.opacity="0";
    document.getElementById("overlay").style.zIndex="-1"; 
    document.getElementById("otherarea").style.width="0";
    reqboxopen=0;
    /*$('.searchlist').fadeOut();*/
    $('.searchlist').css("visibility","hidden"); 
}

function logout() {

  window.location.href="logout.php";
}

</script>

</body>
</html>