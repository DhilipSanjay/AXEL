function highlightevolve()
{
    document.getElementById("evolve").style.color="#76D7C4";
}


function dehighlightevolve()
{
    document.getElementById("evolve").style.color="white";
}

function openlink(url)
{
    window.location.href=url;
}

function getPosition(element) {
    var yPosition = 0;

    while(element) {
        yPosition += (element.offsetTop - element.scrollTop /*+ element.clientTop*/ ); //here offsetTop gives the distance of an element from the top of its parent 
        //scrolltop gives the vertical distance the element has been scrolled and clienttop is the top border width of the element
        element = element.offsetParent;
    }

    return yPosition;
}

var poll = document.getElementById("polls");
var ann = document.getElementById("announcements");
var news = document.getElementById("news");
var contests = document.getElementById("contests");

window.onscroll = function(){

    poll.style.transform="translateY(-100px)";
    poll.style.opacity="0";

    ann.style.transform="translateX(-100px)";
    ann.style.opacity="0";

    news.style.transform="translateY(-100px)";
    news.style.opacity="0";

    contests.style.transform="translateX(100px)";
    contests.style.opacity="0";

    if(window.scrollY>=(getPosition(poll)-600))   
    {
        poll.style.animationName="contentcomingin";
        poll.style.animationDuration="0.5s";
        poll.style.animationFillMode="forwards";
    }

    if(window.scrollY>=(getPosition(ann)-600))   
    {
        ann.style.animationName="anncontestcontentcomingin";
        ann.style.animationDuration="0.5s";
        ann.style.animationFillMode="forwards";
    }

    if(window.scrollY>=(getPosition(news)-600))   
    {
        news.style.animationName="contentcomingin";
        news.style.animationDuration="0.5s";
        news.style.animationFillMode="forwards";
    }

    if(window.scrollY>=(getPosition(contests)-600))   
    {
        contests.style.animationName="anncontestcontentcomingin";
        contests.style.animationDuration="0.5s";
        contests.style.animationFillMode="forwards";
    }
}