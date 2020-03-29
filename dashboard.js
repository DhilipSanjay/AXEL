var newheight=window.innerHeight-90;
document.getElementById("sidenavbar").style.height=newheight+"px";
document.getElementById("otherarea").style.height=newheight+"px";

/*window.onscroll = function(){

    if(window.scrollY>=0)
    {
    topmargin=window.scrollY+10;
    document.getElementById("sidenavbar").style.marginTop=topmargin+"px";
    document.getElementById("otherarea").style.marginTop=topmargin+"px";
    }
}*/

function accept(reqid,accid,event)
{

    if(event.target.innerHTML!="Accepted")
    {
    var reqobj=createreqobj();

    /*alert(reqid+","+accid);*/

    reqobj.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          event.target.style.backgroundColor ="#c0c0c0";
          event.target.innerHTML="Accepted";
        }

      };

    var parameters="requestid="+reqid+"&acceptorid="+accid+"&accept=enlightenment";

    reqobj.open("POST", "accept.php", true);
    reqobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    reqobj.send(parameters);
    }
    
}


function acceptasmentor(mentorid,accid,event)
{
    if(event.target.innerHTML!="Accepted as mentor")
    {
    var mentorreqobj=createreqobj();

    /*alert(reqid+","+accid);*/

    mentorreqobj.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          event.target.style.backgroundColor ="#c0c0c0";
          event.target.innerHTML="Accepted as mentor";
        }

      };

    var parameters="mentorid="+mentorid+"&acceptorid="+accid+"&accept=mentorship";

    mentorreqobj.open("POST", "accept.php", true);
    mentorreqobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    mentorreqobj.send(parameters);
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

  var parameters="userid="+userid+"&reqtype=enlightenreq";

  reqfillobj.open("POST", "requests.php", true);
  reqfillobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  reqfillobj.send(parameters);

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

  var parameters="userid="+userid+"&reqtype=mentorreq";

  mentorreqfillobj.open("POST", "requests.php", true);
  mentorreqfillobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  mentorreqfillobj.send(parameters);
}

function applaud(userid,postid,postuserid,event){
  /*alert(userid+"and"+postid+"and"+postuserid);*/
  var src=event.target.src;
  var applaudobj=createreqobj(); //ajax object for applaud

  if(src==="http://localhost:8000/Axel/clapping.svg") //not yet applauded
  {
  applaudobj.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
      event.target.src="clapping_enabled.svg";
    }

  };

  var parameters="userid="+userid+"&postid="+postid+"&postuserid="+postuserid+"&todo=insertapplaud";

    applaudobj.open("POST", "applaud.php", true);
    applaudobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    applaudobj.send(parameters);
  }

  else
  {
    applaudobj.onreadystatechange = function() {

      if (this.readyState == 4 && this.status == 200) {
        event.target.src="clapping.svg";
      }
  
    };
  
    var parameters="userid="+userid+"&postid="+postid+"&postuserid="+postuserid+"&todo=deleteapplaud";
  
      applaudobj.open("POST", "applaud.php", true);
      applaudobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      applaudobj.send(parameters);
  }


}
  