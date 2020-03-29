var newheight=window.innerHeight-90;
document.getElementById("sidenavbar").style.height=newheight+"px";
document.getElementById("otherarea").style.height=newheight+"px";

function accept(reqid,accid,event)
{

    if(event.target.innerHTML!="Accepted")
    {
    var reqobj=createreqobj();

    reqobj.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          event.target.style.backgroundColor ="#c0c0c0";
          event.target.innerHTML="Accepted";
        }

      };

    var url="accept.php?requestid="+reqid+"&acceptorid="+accid+"&accept=enlightenment";

    reqobj.open("GET", url, true);
    reqobj.send();
    }
    
}


function acceptasmentor(mentorid,accid,event)
{
    if(event.target.innerHTML!="Accepted as mentor")
    {
    var mentorreqobj=createreqobj();

    mentorreqobj.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          event.target.style.backgroundColor ="#c0c0c0";
          event.target.innerHTML="Accepted as mentor";
        }

      };

    var url="accept.php?mentorid="+mentorid+"&acceptorid="+accid+"&accept=mentorship";

    mentorreqobj.open("GET", url, true);
    mentorreqobj.send();
    }
    
}

function fillrequests(userid)
{
  var reqfillobj=createreqobj();

  document.getElementById("enlightenbox").style.borderBottom="2px solid #76D7C4";
  document.getElementById("mentorbox").style.borderBottom="2px solid #E5E7E9";

  document.getElementById("mentorbox").setAttribute("onclick","fillmentorreq("+userid+")");
  document.getElementById("enlightenbox").removeAttribute("onclick");

  document.getElementById("enlightenholder").style.height="82.5%";
  document.getElementById("enlightenholder").style.visibility="visible";

  document.getElementById("mentorreqholder").style.height="0";
  document.getElementById("mentorreqholder").style.visibility="hidden";
  

  reqfillobj.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("enlightenholder").innerHTML=this.responseText;
    }

  };

  var url="requests.php?userid="+userid+"&reqtype=enlightenreq";

  reqfillobj.open("GET", url, true);
  reqfillobj.send();

}

function fillmentorreq(userid)
{
  var mentorreqfillobj=createreqobj();

  document.getElementById("enlightenbox").style.borderBottom="2px solid #E5E7E9";
  document.getElementById("mentorbox").style.borderBottom="2px solid #76D7C4";

  document.getElementById("enlightenbox").setAttribute("onclick","fillrequests("+userid+")");
  document.getElementById("mentorbox").removeAttribute("onclick");

  document.getElementById("mentorreqholder").style.height="82.5%";
  document.getElementById("mentorreqholder").style.visibility="visible";

  document.getElementById("enlightenholder").style.height="0";
  document.getElementById("enlightenholder").style.visibility="hidden";
  

  mentorreqfillobj.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("mentorreqholder").innerHTML=this.responseText;
    }

  };

  var url="requests.php?userid="+userid+"&reqtype=mentorreq";

  mentorreqfillobj.open("GET", url, true);
  mentorreqfillobj.send();
}

function applaud(userid,postid,postuserid,count,event)
{
  var src=event.target.src;
  var applaudobj=createreqobj(); //ajax object for applaud

  if(src==="http://localhost:8000/Axel/clapping.svg") //not yet applauded
  {
  applaudobj.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
      event.target.src="clapping_enabled.svg";
      checkapplaudcount(postid,count);
    }

  };

  var url="applaud.php?userid="+userid+"&postid="+postid+"&postuserid="+postuserid+"&todo=insertapplaud";

    applaudobj.open("GET", url, true);
    applaudobj.send();
  }

  else
  {
    applaudobj.onreadystatechange = function() {

      if (this.readyState == 4 && this.status == 200) {
        event.target.src="clapping.svg";
        checkapplaudcount(postid,count);
      }
  
    };
  
    var url="applaud.php?userid="+userid+"&postid="+postid+"&postuserid="+postuserid+"&todo=deleteapplaud";
  
      applaudobj.open("GET", url, true);
      applaudobj.send();
  }

  


}
  