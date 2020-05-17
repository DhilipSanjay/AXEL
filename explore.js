function toggle(num)
{
    if(num===1)
    {
        $("#s1").css("border-bottom","2px solid #76D7C4");
        $("#s2").css("border-bottom","2px solid white");
        $("#s3").css("border-bottom","2px solid white");
        $("#popular_startups").css("display","block");
        $("#popular_mentors").css("display","none");
        $("#nearby").css("display","none");        
    }
    else if(num === 2)
    {   
        $("#s2").css("border-bottom","2px solid #76D7C4");
        $("#s1").css("border-bottom","2px solid white");
        $("#s3").css("border-bottom","2px solid white");
        $("#popular_startups").css("display","none");
        $("#popular_mentors").css("display","block");
        $("#nearby").css("display","none");
    }

    else if (num === 3)
    {
        $("#s3").css("border-bottom","2px solid #76D7C4");
        $("#s1").css("border-bottom","2px solid white");
        $("#s2").css("border-bottom","2px solid white");
        $("#popular_startups").css("display","none");
        $("#popular_mentors").css("display","none");
        $("#nearby").css("display","block");   
    }
}

function selectuser(userid)
{
    window.location.href="profile.php?userid="+userid;
}