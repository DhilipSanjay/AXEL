    if(window.innerWidth<=769)
    {
      var newheight=window.innerHeight;
    }

    else
    {
      var newheight=window.innerHeight-90;
    }

/*document.getElementById("sidenavbar").style.height=newheight+"px";*/
document.getElementById("otherarea").style.height=newheight+"px";

var createdann=0; //for now no announcement created

var newannbox=0;
var newcontestbox=0;

var listisopen=0;

function openlist()
{
  if(listisopen===0)
  {
    document.getElementById("sidenavbar").style.width="100%";
    document.getElementById("logout").style.width="80%";
    listisopen=1;
  }

  else
  {
    document.getElementById("sidenavbar").style.width="0";
    document.getElementById("logout").style.width="0";
    listisopen=0;
  }

}

function opennewcontestbox()
{
  if(newcontestbox===0)
  {
    document.getElementsByClassName("fortopbuttons")[0].style.opacity="0.5";
    document.getElementsByClassName("fortopbuttons")[0].style.zIndex="3";
    
    document.getElementById("createnewcontest").style.zIndex="10";
    if(window.innerWidth<=769)
    {
      document.getElementById("createnewcontest").style.height="100%";
    }
    else
    {
      document.getElementById("createnewcontest").style.height="85%";
    }

    document.getElementById("createnewcontest").style.visibility="visible";

    newcontestbox=1;
  }

  else
  {
    document.getElementsByClassName("fortopbuttons")[0].style.opacity="0";
    document.getElementsByClassName("fortopbuttons")[0].style.zIndex="-1";
    
    document.getElementById("createnewcontest").style.height="0";
    document.getElementById("createnewcontest").style.zIndex="-1";
    document.getElementById("createnewcontest").style.visibility="hidden";

    newcontestbox=0;
  }

}

function opennewannouncementbox(userid)
{
  if(createdann===1) //reset the announcement box
  {

    var parameter = "createann(" + userid + ")";

    document.getElementById("createann").style.backgroundColor="#76D7C4";
    document.getElementById("createann").style.color="white";
    document.getElementById("createann").style.cursor="pointer";
    document.getElementById("createann").setAttribute("onclick",parameter);
    document.getElementById("createann").innerHTML="Create Announcement";
    document.getElementById("ann").value="";

    createdann=0;
  }

  if(newannbox===0)
  {
    document.getElementsByClassName("fortopbuttons")[0].style.opacity="0.5";
    document.getElementsByClassName("fortopbuttons")[0].style.zIndex="3";
    
    document.getElementById("createnewannouncementbox").style.zIndex="10";

    if(window.innerWidth<=769)
    {
      document.getElementById("createnewannouncementbox").style.height="100%";
    }
    else
    {
      document.getElementById("createnewannouncementbox").style.height="70%";
    }
    document.getElementById("createnewannouncementbox").style.visibility="visible";

    newannbox=1;
  }

  else
  {
    document.getElementsByClassName("fortopbuttons")[0].style.opacity="0";
    document.getElementsByClassName("fortopbuttons")[0].style.zIndex="-1";
    
    document.getElementById("createnewannouncementbox").style.height="0";
    document.getElementById("createnewannouncementbox").style.zIndex="-1";
    document.getElementById("createnewannouncementbox").style.visibility="hidden";

    newannbox=0;
  }
   

}

function createann(userid)
{
  var createann=createreqobj();

  createann.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
        //opennewannouncementbox() //for closing the create announcement box
        if(this.responseText==="error")
        {
        document.getElementById("createann").style.backgroundColor="white";
        document.getElementById("createann").style.color="red";
        document.getElementById("createann").style.cursor="default";
        document.getElementById("createann").removeAttribute("onclick");
        document.getElementById("createann").innerHTML="Some error occured while creating the announcement!";
        }

        else
        {
        document.getElementById("createann").style.backgroundColor="white";
        document.getElementById("createann").style.color="#76D7C4";
        document.getElementById("createann").style.cursor="default";
        document.getElementById("createann").removeAttribute("onclick");
        document.getElementById("createann").innerHTML="Created successfully!";
        }

        createdann=1;
    } 

  };

  var ann = document.getElementById("ann").value;

  if(ann==="")
  {
    alert("Announcement cannot be empty!");
  }

  else
  {
  ann=encodeURIComponent(ann);  //used to have & and other symbols in announcement
  var param="userid="+userid+"&ann="+ann;
  createann.open("POST", "createann.php", true);
  createann.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
  createann.send(param);
  }
}

var errorurl=0;

function checkURL()
{
  var regex = /^(http:\/\/|https:\/\/)(www\.)(\w+)(\.\w+)([\w\/=!@#\$%^&*()+{}\[\]\'\"\\:;.,<>\.\-\?]+)$/gim;
  var url = document.getElementById("conlink").value;
  var res = regex.test(url);
  
  if(res==false)
  {
    errorurl=1;
    document.getElementById("errorURL").style.display="block";
  }

  else
  {
    errorurl=0;
    document.getElementById("errorURL").style.display="none";
  }

  //console.log(regex.test(url));
}

function hostcontest(hostid)
{
  var hostcontest=createreqobj();

  hostcontest.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
        
        //alert(this.responseText);
        location.reload(true); //to reload the page
    } 

  };

  var link = document.getElementById("conlink").value;
  var date = document.getElementById("datepicker").value;
  var desc = document.getElementById("contdesc").value;

  /*var todaydate = new Date(); 
  var dd = todaydate.getDate(); 
  var mm = todaydate.getMonth()+1; 
  var yyyy = todaydate.getFullYear();//January is 0! var yyyy = today.getFullYear(); if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var today = dd+'/'+mm+'/'+yyyy;

  if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var todaysdate = dd+'-'+mm+'-'+yyyy;*/

  if(desc===""||link===""||date==="")
  {
    alert("Please fill in all the fields!");
  }

  else if(errorurl===1)
  {
    alert("Incorrect link specified!");
  }

  else
  {
  desc=encodeURIComponent(desc);  //used to have & and other symbols in description
  var param="hostid="+hostid+"&date="+date+"&desc="+desc+"&link="+link;
  hostcontest.open("POST", "hostcontest.php", true);
  hostcontest.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
  hostcontest.send(param);
  }
}

function accept(reqid,accid,event)
{

    if(event.target.innerHTML!="Accepted")
    {
    var reqobj=createreqobj();

    reqobj.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          event.target.style.backgroundColor ="#c0c0c0";
          event.target.innerHTML="Accepted";

          if(document.getElementsByClassName("reqbox").length===0)
          {
          document.getElementById("round").style.visibility="hidden";
          }
        }

      };

    var url="accept.php?requestid="+reqid+"&acceptorid="+accid+"&accept=enlightenment";

    reqobj.open("GET", url, true);
    reqobj.send();
    }
    
}


function acceptasmentor(startupid,accid,event)
{
    if(event.target.innerHTML!="Accepted as mentor")
    {
    var mentorreqobj=createreqobj();

    mentorreqobj.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
          event.target.style.backgroundColor ="#c0c0c0";
          event.target.innerHTML="Accepted as mentor";


          if(document.getElementsByClassName("reqbox").length===0)
          {
          document.getElementById("round").style.visibility="hidden";
          }

        }


      };

    var url="accept.php?startupid="+startupid+"&acceptorid="+accid+"&accept=mentorship";

    mentorreqobj.open("GET", url, true);
    mentorreqobj.send();
    }
    
}

function fillrequests(userid,usertype)
{
  var reqfillobj=createreqobj();

  if(usertype!=="startup"&&usertype!=="general") //this is only for mentors
  {
  document.getElementById("enlightenbox").style.borderBottom="2px solid #76D7C4";
  document.getElementById("mentorbox").style.borderBottom="2px solid #E5E7E9";

  document.getElementById("mentorbox").setAttribute("onclick","fillmentorreq("+userid+")");
  document.getElementById("enlightenbox").removeAttribute("onclick");

  document.getElementById("enlightenholder").style.height="82.5%";
  document.getElementById("enlightenholder").style.visibility="visible";

  document.getElementById("mentorreqholder").style.height="0";
  document.getElementById("mentorreqholder").style.visibility="hidden";
  }

  reqfillobj.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
     document.getElementById("enlightenholder").innerHTML=this.responseText;


     if(usertype==="startup") //this is only for mentors
     {

     if(document.getElementsByClassName("reqbox").length>=1)
     {
       document.getElementById("round").style.visibility="visible";
     }

     }

     else if(usertype==="mentor")
     {
       fillmentorreq(userid);
     }
    }

  };

  var url="requests.php?userid="+userid+"&reqtype=enlightenreq";

  reqfillobj.open("GET", url, true);
  reqfillobj.send();

}

function fillmentorreq(userid)
{
  var mentorreqfillobj=createreqobj();

  //alert(document.getElementById("mentorbox").innerHTML);

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

     if(document.getElementsByClassName("reqbox").length>=1)
     {
     document.getElementById("round").style.visibility="visible";
     }
    }

  };

  var url="requests.php?userid="+userid+"&reqtype=mentorreq";

  mentorreqfillobj.open("GET", url, true);
  mentorreqfillobj.send();
}
  
function applaud(userid,postid,postuserid,count,event)
{
  var status=event.target.getAttribute("status");
  var applaudobj=createreqobj(); //ajax object for applaud

  document.getElementsByClassName("countbox")[count].style.animation="slideout 0.25s forwards";

  if(status==="0") //not yet applauded
  {
  applaudobj.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
      event.target.setAttribute("status","1");
      event.target.src="clapping_enabled.svg";
      checkapplaudcount(postid,count);
    }

  };

  var url="applaud.php?userid="+userid+"&postid="+postid+"&postuserid="+postuserid+"&todo=insertapplaud&datetime="+Date();

    applaudobj.open("GET", url, true);
    applaudobj.send();
  }

  else //applauded already
  {
    applaudobj.onreadystatechange = function() {

      if (this.readyState == 4 && this.status == 200) {
        event.target.setAttribute("status","0");
        event.target.src="clapping.svg";
        checkapplaudcount(postid,count);
      }

    };
  
    var url="applaud.php?userid="+userid+"&postid="+postid+"&postuserid="+postuserid+"&todo=deleteapplaud&datetime="+Date();
  
      applaudobj.open("GET", url, true);
      applaudobj.send();
  }
}

function updatenotiread()
{
  // console.log(localStorage.getItem("notiupdated"));
  var reqobj=createreqobj();

  reqobj.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };

  var url="updatenotiread.php";

  reqobj.open("GET", url, true);  
  reqobj.send();
}