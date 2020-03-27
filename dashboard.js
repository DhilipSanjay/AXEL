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
  