$(document).ready(function()
{
    $('#searchtext').keyup(function()
    {
        var query = $(this).val();
        if(query != '')
        {
            $.ajax({
                url:"search.php",
                method:"POST",
                data:{query:query},
                success:function(data)
                {
                    $('.searchlist').fadeIn();
                    $('.searchlist').css("visibility","visible");
                    $('#overlay').css("opacity","0.5");
                    $('#overlay').css("z-index","1");
                    $('.searchlist').html(data);
                }
            });
        }
        else
        {
            $('.searchlist').fadeOut();
            $('#overlay').css("opacity","0");
            $('#overlay').css("z-index","-1");
        }
    });    
});

function selectuser(username)
    {
        $('#searchtext').val(username);
        $('.searchlist').fadeOut();
    }