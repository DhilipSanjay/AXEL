function toggle(num)
{
    if(num===1) //open profile page
    {
        $("#s1").css("border-bottom","2px solid #76D7C4");
        $("#s2").css("border-bottom","2px solid white");
        $("#otherinfo").css("display","block");
        $("#holder").css("display","none");       
    }

    else //open announcements page
    {   
        $("#s2").css("border-bottom","2px solid #76D7C4");
        $("#s1").css("border-bottom","2px solid white");
        $("#holder").css("display","block");
        $("#otherinfo").css("display","none");     
    }
}

function enlreq(reqid,accid)
{
    var enlreq=createreqobj();

    enlreq.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
        
            alert(this.responseText);
    } 

    };

  var param = "reqid="+reqid+"&accid="+accid+"&reqtype=enlighten";

  enlreq.open("POST", "enlightenmentorreq.php", true);
  enlreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
  enlreq.send(param);
}

function mentorreq(startupid,mentorid)
{
    var menreq=createreqobj();

    menreq.onreadystatechange = function() {

    if (this.readyState == 4 && this.status == 200) {
        
            alert(this.responseText);
    } 

    };

  var param = "sid="+startupid+"&mid="+mentorid+"&reqtype=mentorship";

  menreq.open("POST", "enlightenmentorreq.php", true);
  menreq.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
  menreq.send(param);
}