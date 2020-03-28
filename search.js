//Jquery
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
                    $('.searchlist').html(data);
                }
                
            });
        }
        else
        {
            $('.searchlist').fadeOut();
        }
    });
    
});

function selectuser(username)
    {
        console.log(username);
        $('#searchtext').val(username);
        $('.searchlist').fadeOut();
    }

