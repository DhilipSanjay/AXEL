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

/*$query="select Name,usertype from users where userid=$userid";
$result=mysqli_query($conn,$query);
$resultforusername=mysqli_fetch_assoc($result);*/


//if user type is a startup then show mentor request accepted notifications in notifications box
if($usertype==="startup")
{
$mentornotiquery="select mentorid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from mentorship inner join users where mentorid=userid and startupid=$userid and status='accepted' order by timeelapsed limit 50";
$mentornotiresult=mysqli_query($conn,$mentornotiquery);
$mentornoticount=mysqli_num_rows($mentornotiresult);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>Contests - Axel</title>
<!--<link rel="stylesheet" href="home.css">-->
<link rel="stylesheet" href="common.css">
<link rel="stylesheet" href="contests.css">
<link rel="stylesheet" href = "search.css"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- jQuery UI library 
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->

<script src="search.js" type="text/javascript"></script>

<script type="text/javascript">

var reqboxopen=0;
var isopen=0;

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

function gotodash(userid)
{
    window.location.href="dashboard.php?userid="+userid;
}

</script>
</head>


<body>

<div id="overlay" onclick="closesearch()"></div>




<div id="notiholder">

<?php 

$query="select userid,Name,SYSDATE()-statuschangetime as timeelapsed,DATE_FORMAT(statuschangetime, '%d %M %Y | %h:%i %p') as time from enlighten inner join users where acceptorid=userid and requestorid=$userid and status='accepted' order by timeelapsed limit 50";
$result=mysqli_query($conn,$query);
$count=mysqli_num_rows($result);


//echo $usertype.",".$count.",".$mentornoticount;

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
<div id="title" style="cursor:pointer" onclick="gotodash(<?php echo $userid?>)">AXEL</div>
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
    <a id="active">
    <svg class="bi bi-award" style="margin-right:15px" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M9.669.864L8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193l-1.51-.229L8 1.126l-1.355.702-1.51.229-.684 1.365-1.086 1.072L3.614 6l-.25 1.506 1.087 1.072.684 1.365 1.51.229L8 10.874l1.356-.702 1.509-.229.684-1.365 1.086-1.072L12.387 6l.248-1.506-1.086-1.072-.684-1.365z" clip-rule="evenodd"/>
  <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
</svg>Contests</a>
    <!--<div id="dummy"></div>-->
</div>

<div id="maindash">
<div class="label contest_category">Active Contests</div>

<hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

<?php
$generaluser_query = "SELECT * FROM generaluser WHERE generaluserid = " . $userid;
$generaluser_result= mysqli_query($conn, $generaluser_query);

$active_query = "SELECT contestid, hostid, name, DATE_FORMAT(heldon,'%d %M %Y') as heldon, contestlink, description FROM contest join users where hostid=userid AND heldon = CURRENT_DATE()";
$active_result = mysqli_query($conn, $active_query);


if(mysqli_num_rows($active_result)===0)
{
?>

<div style="font-size:1.2rem;margin:15px">No Active Contests!</div>

<?php
}

else
{
while($row = mysqli_fetch_assoc($active_result))
{
  $contestid = $row['contestid'];
  $hostname = $row['name'];
  $hostid = $row['hostid'];
  $heldon = $row['heldon'];
  $contestlink = $row['contestlink'];
  $desc = $row['description'];
?>
<div class = "contest">

<div class="hostedby">
Contest hosted by <a href="#"><?php echo $hostname; ?></a>
</div>

<div class="description"> 
<?php echo $desc;?>  
</div>

<div class="contestfooter">
<div><b>Date : </b><?php echo $heldon;?> </div>
<div id="participation">
<?php
  if(mysqli_num_rows($generaluser_result) === 0)
  {
?>
<div style="text-align:center;color:red">Mentors/Startups can't participate!</div>
<?php
  }
  else
  {
  $participated_query= "SELECT * FROM participant WHERE participantID = ". $userid . " AND contestid = ". $contestid . " AND hostid = ". $hostid;
  $participated_result= mysqli_query($conn, $participated_query);
  if(mysqli_num_rows($participated_result) === 0)
  {
  ?>
  <div style="text-align:center">
<a href="<?php echo $contestlink?>" target="_blank" onclick="participate(<?php echo $userid. ",". $contestid. ",". $hostid?>)">Participate</a> 
  </div>
<?php
  }
  else
  {
?>
<div style="text-align:center">
Already Participated!
</div>
<?php
  }
}
?>
</div>
<div style="grid-area:viewdetails;text-align:right"><a href="<?php echo $contestlink?>" target="_blank">View Details</a></div>
</div>
</div>
<?php
}
}
?>

<div class="label contest_category">Upcoming Contests</div>

<hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

<?php
$upcoming_query = "SELECT contestid, hostid, name, DATE_FORMAT(heldon,'%d %M %Y') as heldon, contestlink, description FROM contest join users where hostid=userid AND heldon > CURRENT_DATE() ORDER BY heldon";
$upcoming_result = mysqli_query($conn, $upcoming_query);

if(mysqli_num_rows($upcoming_result)===0)
{
?>

<div style="font-size:1.2rem;margin:15px">No Upcoming Contests!</div>

<?php
}

else
{
while($row = mysqli_fetch_assoc($upcoming_result))
{
  $contestid = $row['contestid'];
  $hostname = $row['name'];
  $hostid = $row['hostid'];
  $heldon = $row['heldon'];
  $contestlink = $row['contestlink'];
  $desc = $row['description'];
?>
<div class = "contest">

<div class="hostedby">
Contest hosted by <a href="#"><?php echo $hostname; ?></a>
</div>

<div class="description"> 
<?php echo $desc;?>  
</div>

<div class="contestfooter">
<div><b>Starts on : </b><?php echo $heldon;?> </div>
<div style="grid-area:viewdetails;text-align:right"><a href="<?php echo $contestlink?>" target="_blank">View Details</a></div>
</div>
</div>
<?php
}
}
?>

<div class="label contest_category">Archived Contests</div>

<hr width="100%" style="margin:20px 0px;border:none;border-bottom:0.5px solid #76D7C4">

<?php
$archived_query = "SELECT contestid, hostid, name, DATE_FORMAT(heldon,'%d %M %Y') as heldon, contestlink, description FROM contest join users where hostid=userid AND heldon < CURRENT_DATE() ORDER BY heldon";
$archived_result = mysqli_query($conn, $archived_query);

if(mysqli_num_rows($archived_result)===0)
{
?>

<div style="font-size:1.2rem;margin:15px">No Archived Contests!</div>

<?php
}

while($row = mysqli_fetch_assoc($archived_result))
{
  $contestid = $row['contestid'];
  $hostname = $row['name'];
  $hostid = $row['hostid'];
  $heldon = $row['heldon'];
  $contestlink = $row['contestlink'];
  $desc = $row['description'];

?>
<div class = "contest">

<div class="hostedby">
Contest hosted by <a href="#"><?php echo $hostname; ?></a>
</div>

<div class="description"> 
<?php echo $desc;?>  
</div>

<div class="contestfooter">
<div><b>Held on : </b><?php echo $heldon;?> </div>

<div id="participation">
<?php
  if(!(mysqli_num_rows($generaluser_result) === 0))
  {
  $participated_query= "SELECT * FROM participant WHERE participantID = ". $userid . " AND contestid = ". $contestid . " AND hostid = ". $hostid;
  $participated_result= mysqli_query($conn, $participated_query);
  if(mysqli_num_rows($participated_result) === 0)
  {
?>
<div style="text-align:center;color:red">
You missed this contest!
</div>

<?php
  }
  else
  {
?>
<div style="text-align:center;color:#76D7C4">
Hope you enjoyed this contest!
</div>
<?php
  }
}
?>
</div>
<div style="grid-area:viewdetails;text-align:right"><a href="<?php echo $contestlink?>" target="_blank">View Details</a></div>
</div>
</div>
<?php
}
?>

<script type="text/javascript">
var searchlistwidth = document.getElementsByClassName("searchbox")[0].clientWidth-20;
document.getElementsByClassName("searchlist")[0].style.width=searchlistwidth+"px";

function closesearch()
{
    document.getElementById("overlay").style.opacity="0";
    document.getElementById("overlay").style.zIndex="-1"; 
    $('.searchlist').css("visibility","hidden");
}

function participate(participantID, contestID, hostID)
{
  $.ajax({
        url: "contest_participated.php",
        method: "POST",
        data:{pid:participantID, cid:contestID, hid:hostID},
        success:function(result)
        {
          location.reload(true);
        }

  });
}
</script>

</body>
</html>