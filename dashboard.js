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

    var parameters="requestid="+reqid+"&acceptorid="+accid;

    reqobj.open("POST", "acceptenlightenment.php", true);
    reqobj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    reqobj.send(parameters);
    }
    
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
  