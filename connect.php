<?php 

if(!isset($_SESSION))
{
  session_start();
}

include("dbconnect.php");
include("session_check.php");
$userid=$_SESSION["userid"]; //this is the userid of the user currently logged in
$name = $_SESSION['name'];
$usertype = $_SESSION['usertype'];
$dp = $_SESSION['dp'];


$timequery = "select lastloggedtime from users where userid=$userid";
$result=mysqli_query($conn,$timequery);
$timeres=mysqli_fetch_assoc($result);

$lastloggedtime=$timeres["lastloggedtime"];

//if user type is a startup then show mentor request accepted notifications in notifications box
if($usertype==="startup")
{
$mentornotiquery="select statuschangetime,mentorid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from mentorship inner join users where mentorid=userid and startupid=$userid and status='accepted' order by timeelapsed limit 50";
$mentornotiresult=mysqli_query($conn,$mentornotiquery);
$mentornoticount=mysqli_num_rows($mentornotiresult);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>Connect - Axel</title>
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="explore.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="polls.css">
<link rel="stylesheet" href = "search.css"> 
<script src="search.js" type="text/javascript"></script>

<style>

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

#dashboard #maindash .label 
{
  font-size:1.5rem;
  font-weight:300;
  align-self:flex-start;
  margin-top:15px;
  border-bottom:1px solid #76D7C4;
  padding-bottom:8px;
}


.holder
{
    font-size:1.2rem;
    min-width:100% !important;
    height:fit-content;
    margin:20px 0;
}

.queryitem
{
width:100%;
box-sizing:border-box;
}


.queryitem2
{
  box-sizing:border-box;
  width:100%;
  padding:10px;
  cursor:default;
  border:none;
  -webkit-box-shadow: 0 3px 8px -2px #c0c0c0;
    -moz-box-shadow: 0 3px 8px -2px #c0c0c0;
    box-shadow: 0 3px 8px -2px #c0c0c0;
    animation:slidein 0.5s forwards;
    opacity:0;
    transform:translateX(-100px);
    border-radius:8px;
  margin-bottom:8px;
}

.queryitem2:hover{
    border: none;
}

.queryitem2 .profile
{
  cursor:pointer;
}


.queryitem2 .chat
{
  position:absolute;
  top:25px;
  right:35px;
  cursor:pointer;
}

.linkholder
{
  margin:0 auto;
  width:90%;
  font-family:'Roboto',sans-serif;
  font-size:1.1rem;
}

.linkholder .contact
{
  background-color:#76D7C4;
  padding:15px 0;
  border-radius:5px;
  color:white;
  text-align:center;
  margin:10px 0;
}

.linkholder .item
{
  cursor:pointer;
  display:block;
  padding:15px 0;
  margin:10px 0;
  text-align:center;
  text-decoration:none;
  color:black;
  border-radius:5px;
  border:1px solid #76D7C4;
}

.DP
{
    width: 40px;
    border-radius:50%;
}

.linkholder .item:hover
{
  background-color:#76D7C4;
  color:white;
}

</style>

<script type="text/javascript">

var reqboxopen=0;
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
    if(window.innerWidth<=769)
    {
      document.getElementById("notiholder").style.height="100%";
    }
    else
    { 
      document.getElementById("notiholder").style.height="400px";
    }
    document.getElementById("notiholder").style.opacity="1";
    document.getElementById("roundnoti").style.visibility="hidden";

    localStorage.setItem("notistatus","seen"); //user has seen the notification

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

function gotodash()
{
    window.location.href="dashboard.php";
}

</script>
</head>

<body onload="fillrequests(<?php echo $userid.',\''.$usertype.'\''?>)">

<div id="overlay" onclick="closesearch()"></div>

<div id="header"> <!--fixed header-->


<div id="logoholder">
<svg class="bi bi-list" id="list" onclick="openlist()" width="2rem" height="2rem" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
</svg>
<img id="logo" src="logo.png" onclick="gotodash()" height="42px" width="41px" alt="logo">
<div id="title" style="cursor:pointer" onclick="gotodash()">AXEL</div>
</div>

<div id="otherholder">

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

  <?php if($usertype!=="general")
    {
  ?>
  <svg onclick="openclosereqbox()" style="cursor:pointer" class="bi bi-person-plus" width="1.7em" height="1.7em" viewBox="0 0 16 16" fill="#76D7C4" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 00.014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 00.022.004zm9.974.056v-.002.002zM6 7a2 2 0 100-4 2 2 0 000 4zm3-2a3 3 0 11-6 0 3 3 0 016 0zm4.5 0a.5.5 0 01.5.5v2a.5.5 0 01-.5.5h-2a.5.5 0 010-1H13V5.5a.5.5 0 01.5-.5z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M13 7.5a.5.5 0 01.5-.5h2a.5.5 0 010 1H14v1.5a.5.5 0 01-1 0v-2z" clip-rule="evenodd"/>
  </svg>

    <?php } ?>

    <div id="round"></div>
  <svg  id="noti" onclick="opennotiholder()" class="bi bi-bell" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="#76D7C4" xmlns="http://www.w3.org/2000/svg">
  <path d="M8 16a2 2 0 002-2H6a2 2 0 002 2z"/>
  <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 004 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 00-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 111.99 0A5.002 5.002 0 0113 6c0 .88.32 4.2 1.22 6z" clip-rule="evenodd"/>
  </svg>
  <div id="roundnoti"></div>

  <img id="userdp" src="<?php echo $dp ?>" alt="avatar.png">
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
    <a href="profile.php?userid=<?php echo $userid?>">
    <svg class="bi bi-person-square" style="margin-right:15px"  width="1em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
    <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
    </svg>My Profile</a>
    <a href="explore.php">
    <svg class="bi bi-book-half" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 018.5 2.5v11a.5.5 0 01-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 010 13.5v-11a.5.5 0 01.276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 01.22-.103 12.958 12.958 0 012.7-.869zM1 2.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V2.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 001 2.82z" clip-rule="evenodd"/>
  <path fill-rule="evenodd" d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 007.5 2.5v11a.5.5 0 00.854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0016 13.5v-11a.5.5 0 00-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 00-.799-.34 12.96 12.96 0 00-2.073-.609z" clip-rule="evenodd"/>
</svg>Explore</a>
<a id="active">
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
</div>


<div id="maindash">


<?php if($usertype!=="general")
{

if($usertype==="startup")
{
?>


<div class="label">Your Mentors</div>

<?php
$query = "select location,phoneno,mentorship.mentorid as mentorid,name,field,dp from mentorship inner join users inner join mentor where mentorship.mentorid=mentor.mentorid and userid=mentor.mentorid and startupid=$userid
and status='accepted'";
$ex = mysqli_query($conn,$query);
?>

<?php if(mysqli_num_rows($ex)===0)
{
?>
<div style="font-size:1.2rem;margin-top:35px">No mentors have been assigned yet! <a href="explore.php">Click here</a>&nbspto explore startups and mentors!</div>
<?php
}
?>


<div class="holder">


<?php while($res = mysqli_fetch_assoc($ex))
{
  
$querylink ="select links from userlinks where userid=".$res['mentorid'];
$exlink = mysqli_query($conn,$querylink);
?>




<div class="queryitem2">
<img class="DP" src= "<?php echo $res['dp'] ?>" alt="profile picture">

<span class="profile" onclick= "selectuser(<?php echo $res['mentorid'] ?>)">
  <div class = "username"><?php echo $res['name'] ?></div>
  <div class="loc"><?php echo $res['field'] ?></div>
</span>

<span class="chat">

<svg class="bi bi-chat-dots" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
  <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>

</span>

<div class="linkholder">

<div class="contact">Location - <?php echo $res["location"] ?> | Contact - <?php echo $res["phoneno"] ?></div>

<?php while($res2 = mysqli_fetch_assoc($exlink))
{
?>
<span class="item" onclick="goto(<?php echo '\''.$res2['links'].'\'' ?>)"><?php echo $res2["links"] ?></span>
<?php } ?>
</div>
</div>




<?php 
} 
?>

</div>



<?php
}

else
{
?>










<div class="label">Startups mentoring</div>

<?php
$query = "select location,phoneno,mentorship.startupid as startupid,name,field,dp from mentorship inner join users inner join startup where mentorship.startupid=startup.startupid and userid=startup.startupid and mentorid=$userid
and status='accepted'";
$ex = mysqli_query($conn,$query);
?>

<?php if(mysqli_num_rows($ex)===0)
{
?>
<div style="font-size:1.2rem;margin-top:35px">No startups mentoring yet! <a href="explore.php">Click here</a>&nbspto explore startups and mentors!</div>
<?php
}
?>


<div class="holder">


<?php while($res = mysqli_fetch_assoc($ex))
{
  
$querylink ="select links from userlinks where userid=".$res['startupid'];
$exlink = mysqli_query($conn,$querylink);
?>




<div class="queryitem2">
<img class="DP" src= "<?php echo $res['dp'] ?>" alt="profile picture">
<span class="profile" onclick= "selectuser(<?php echo $res['startupid'] ?>)">
  <div class = "username"><?php echo $res['name'] ?></div>
  <div class="loc"><?php echo $res['field'] ?></div>
</span>


<span class="chat">

<svg class="bi bi-chat-dots" width="1.2em" height="1.2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
  <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>

</span>

<div class="linkholder">

<div class="contact">Location - <?php echo $res["location"] ?> | Contact - <?php echo $res["phoneno"] ?></div>

<?php while($res2 = mysqli_fetch_assoc($exlink))
{
?>
<span class="item" onclick="goto(<?php echo '\''.$res2['links'].'\'' ?>)"><?php echo $res2["links"] ?></span>
<?php } ?>
</div>
</div>




<?php 
} 
?>

</div>













<?php
} 
}
?>









<div class="label">Startups enlightening you</div>

<?php 

$startupquery = "select dp,location,acceptorid,name,field from enlighten inner join users inner join startup where startupid=userid and
userid=acceptorid and usertype='startup' and status='accepted' and requestorid=$userid order by statuschangetime desc limit 25";
$startupexec = mysqli_query($conn,$startupquery);

?>

<?php if(mysqli_num_rows($startupexec)===0)
{
?>
<div style="font-size:1.2rem;margin-top:35px">No startups enlightening you! <a href="explore.php">Click here</a>&nbspto explore startups and mentors!</div>
<?php
}
?>


<div class="holder">


<?php while($res = mysqli_fetch_assoc($startupexec))
{
?>

<div class="queryitem" onclick= "selectuser(<?php echo $res['acceptorid'] ?>)">
<img class="DP" style="width:65px" src= "<?php echo $res['dp'] ?>" alt="profile picture">
<span class="profile">
  <div class = "username"><?php echo $res['name'] ?></div>
  <div class="usertype"><?php echo $res['field'] ?></div>
  <div class="loc"><?php echo $res['location'] ?></div>
</span>
</div> 

<?php
}
?>

</div>









<div class="label">Mentors enlightening you</div>

<?php 

$mentorquery = "select dp,location,acceptorid,name,field from enlighten inner join users inner join mentor where mentorid=userid and
userid=acceptorid and usertype='mentor' and status='accepted' and requestorid=$userid order by statuschangetime desc limit 25";
$mentorexec = mysqli_query($conn,$mentorquery);

?>

<?php if(mysqli_num_rows($mentorexec)===0)
{
?>
<div style="font-size:1.2rem;margin-top:35px">No mentors enlightening you! <a href="explore.php">Click here</a>&nbspto explore startups and mentors!</div>
<?php
}
?>


<div class="holder">


<?php while($res = mysqli_fetch_assoc($mentorexec))
{
?>

<div class="queryitem" onclick= "selectuser(<?php echo $res['acceptorid'] ?>)">
<img class="DP" style="width:65px" src= "<?php echo $res['dp'] ?>" alt="profile picture">
<span class="profile">
  <div class = "username"><?php echo $res['name'] ?></div>
  <div class="usertype"><?php echo $res['field'] ?></div>
  <div class="loc"><?php echo $res['location'] ?></div>
</span>
</div> 

<?php
}
?>

</div>









</div>

<div id="otherarea">

<span id="label">REQUESTS</span>

<div id="enlightenormentor">

<?php if($usertype==="mentor")
{
?>
<div id="enlightenbox">Enlighten</div>
<div id="mentorbox">Startups</div>

<?php
}
?>

</div>

<div id="enlightenholder">
</div>

<div id="mentorreqholder">
</div>

</div>


</div>

<div id="notiholder">

<?php 

$query="select statuschangetime,userid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from enlighten inner join users where acceptorid=userid and requestorid=$userid and status='accepted' order by timeelapsed limit 50";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);


if( ($usertype==="mentor"&&$count===0) || ($count===0&&$usertype==="startup"&&$mentornoticount===0) )
{
?>
<div id="nonoti" style="margin-top:20px">No notifications!</div>
<?php
}

else
{

if($usertype==="startup")
{

$firstitem=0;

while($row=mysqli_fetch_assoc($mentornotiresult))
{
  
if($firstitem===0)//this is the first item
{
  if($row["statuschangetime"]>=$lastloggedtime)
  {
?>
    <script>

var notistatus=localStorage.getItem("notistatus");

if(notistatus==="not seen")
{
  document.getElementById("roundnoti").style.visibility="visible";
}
 
 </script>
<?php
  }
  $firstitem=1;
}
?>

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

$firstitem=0;

while($row=mysqli_fetch_assoc($result))
{ 
  
  if($firstitem===0)//this is the first item
  {
    if($row["statuschangetime"]>=$lastloggedtime)
    {
?>
     <script>

var notistatus=localStorage.getItem("notistatus");

if(notistatus==="not seen")
{
  document.getElementById("roundnoti").style.visibility="visible";
}
 
 </script>
  
<?php
    }
    $firstitem=1;
  }
  
?>

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

/*$loginquery = "update users set lastloggedtime=CURRENT_TIMESTAMP() where userid=$userid";
$loginresult=mysqli_query($conn,$loginquery);*/

?>

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

function openclosereqbox() 
{

  if(isopen==1)
  {
    opennotiholder();
  }
 
  if(reqboxopen==0)
  {
    document.getElementById("overlay").style.opacity="0.5";
    document.getElementById("overlay").style.zIndex="1"; 
    if(window.innerWidth<=769)
    {
    document.getElementById("otherarea").style.width="100%";
    }
    else
    {
    document.getElementById("otherarea").style.width="450px";
    }
    reqboxopen=1;
  }

  else
  {
    closesearch();
    document.getElementById("overlay").style.opacity="0";
    document.getElementById("overlay").style.zIndex="-1"; 
    document.getElementById("otherarea").style.width="0";
    reqboxopen=0;
  }
}

function logout() {

window.location.href="logout.php";
}

function goto(url)
{
  window.open(url,'_blank');
}

function selectuser(userid)
{
    window.location.href="profile.php?userid="+userid;
}

</script>


<script src="dashboard.js" type="text/javascript"></script>
</body>
</html>