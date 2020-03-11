<!DOCTYPE html>
<head>
<title>Axel - Home</title>
<link rel="stylesheet" href="home.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
<script src="home.js" type="text/javascript"></script>
</head>
<body>

<div id="overlay" onclick="closesidebar()"></div>

<div id="menu">
<img id="close" src="close.png" onclick="closesidebar()">
    <a id="active">Home</a>
    <a href="about.php">What we do</a>
    <a href="contact.php">Get in touch</a>
    <a href="contests.php">Contests</a>
    <a href="login.php">Login</a>
</div>

<div id="home">

<img id="logo" src="logo.png" height="47px" width="45px" alt="logo">
<div id="title">AXEL</div>
<img onclick="openlink('login.php')" id="user" src="user.png" alt="login">
<img id="listicon" onclick="opensidebar();" src="list.png" alt="picture">

<div id="maininfo">
    <div id="content">
     <div id="text">It's time to <p id="evolve">evolve.</p></div>
        <div id="info">
        Whether you are a budding startup looking for mentorship from the best experts or an experienced mentor with a 
        passion to guide startups, we are here to help you out.
        </div>

        <div id="buttonholder">
        <div class="button" onmouseover="highlightevolve()" onmouseout="dehighlightevolve()">I am a startup</div>
        <div class="button" onmouseover="highlightevolve()" onmouseout="dehighlightevolve()">I am a mentor</div>
        </div>

    </div>
</div>
</div>

<div id="others">

<div class="label pollstitle">Poll of the day</div>
<div id="polls">
Polls go here
</div>

<div class="label">Announcements</div>
<hr width="97.5%">
<div id="announcements">

<div class="announcementsholder">
    <div class="imgholder"></div>
<div class="announcementsinfo"><p>Content goes here</p></div>
</div>

<div class="announcementsholder">
    <div class="imgholder"></div>
<div class="announcementsinfo"><p>Content goes here</p></div>
</div>

<div class="announcementsholder">
    <div class="imgholder"></div>
<div class="announcementsinfo"><p>Content goes here</p></div>
</div>

<div class="announcementsholder">
    <div class="imgholder"></div>
<div class="announcementsinfo"><p>Content goes here</p></div>
</div>

<div class="loadmore" onclick="openlink('announcements.php')">
Load More
</div>

</div>

<div class="label">News</div>

<div class="holder">

<div id="news">

<div class="newsholder"><p>Content goes here</p></div>
<div class="newsholder"><p>Content goes here</p></div>
<div class="newsholder"><p>Content goes here</p></div>
<div class="newsholder"><p>Content goes here</p></div>

<div class="loadmore new" onclick="openlink('news.php')">
Load More
</div>

</div>

</div>

<div class="holder contestsholder">

<div class="label contestlabel">Contests</div>
<hr width="97.5%" class="contestline">
<p id="desc">Check out some of the interesting contests hosted by enthusiastic startups!</p>

<div id="contests">

<div class="box1">
<div class="cholder ch1"><p>Content goes here</p></div>
<div class="cholder ch1"><p>Content goes here</p></div>
</div>

<div class="box1 additional">
<div class="cholder ch1"><p>Content goes here</p></div>
<div class="cholder ch1"><p>Content goes here</p></div>
</div>

<div id="loadmoreflex">
<div class="loadmore new contestloadmore" onclick="openlink('contests.php')">
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
</script>
</body>
</html>