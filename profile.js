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