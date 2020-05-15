$(document).ready(function()
{
    $('#searchtext').on('keyup mousedown',function()
    {
        if(reqboxopen==1)
        {
            openclosereqbox();
        }

        if(isopen==1)
        {
            opennotiholder();
        }
       
        var query = $(this).val();
        if(query != '')
        {
            $.ajax({
                url:"search.php",
                method:"POST",
                data:{query:query},
                success:function(data)
                {
                    /*$('.searchlist').fadeIn();*/
                    $('.searchlist').css("visibility","visible");
                    $('#overlay').css("opacity","0.5");
                    $('#overlay').css("z-index","1");
                    $('.searchlist').html(data);
                }
            });
        }
        else
        {
            /*$('.searchlist').fadeOut();*/
            $('.searchlist').css("visibility","hidden");
            $('#overlay').css("opacity","0");
            $('#overlay').css("z-index","-1");
        }
    });    
});

function selectuser(userid)
    {
        /*$('#searchtext').val(username);
        $('.searchlist').css("visibility","hidden");
        $('#overlay').css("opacity","0");
        $('#overlay').css("z-index","-1");*/

        window.location.href="profile.php?userid="+userid;
    }