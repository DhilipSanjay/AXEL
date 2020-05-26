<!DOCTYPE html>
<html>
<head>
    <title>Account Verification - Axel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico">
    <!--BOOTSTRAP CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<style>
.paymentbox
{
    font-size:22px;
    margin:100px auto;
    width:70%;
    box-shadow: 0 0 6px 0 #ccc;
    padding:50px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.button
{
    background-color:#76D7C4;
    margin-top:35px;
    padding:10px;
    width:300px;
    color:white;
    text-align:center;
    border-radius:5px;
    cursor:pointer;
    transition:all 0.2s ease-in-out;
}

.button:hover
{
    background-color:#76D7C4;
}

#title
{
    font-size:40px;
    margin-bottom:40px;
}

@media screen and (max-width:769px)
{
    .paymentbox
    {
        width:90%;
        font-size:20px;
    }

    #title
    {
        font-size:32px;
    }

    .button
    {
        width:100%;
    }
}   

</style>
<body>
<div class="input-group mb-3 paymentbox">
<?php

if(isset($_GET['vkey']))
{
    include("dbconnect.php");
    $vkey = mysqli_real_escape_string($conn,$_GET['vkey']);

    $customer_query = "SELECT * FROM users WHERE vkey = '$vkey' AND verified = 0 LIMIT 1";
    $customer_result = mysqli_query($conn, $customer_query);
    $row = mysqli_fetch_array($customer_result, MYSQLI_ASSOC);

    if(mysqli_num_rows($customer_result) == 1)
    {
        $customer_update = "UPDATE users SET verified = 1 WHERE vkey = '$vkey' AND verified = 0";
        if(mysqli_query($conn, $customer_update))
        {

?>


<span id="title">HOORAY!&#128293</span>

<span style="text-align:justify">Your account has been verified!</span>

<div class="button" onclick="gotologin()">Go to login</div>


<?php    
}
else
{
    echo "Error: Could not update: ". mysqli_error($conn);
    header("Location: error.php");
}    
 
}

else {


?>

<span id="title">OOPS!&#129317</span>

<span style="text-align:justify">This account is invalid or already verified! <i>Sorry!</i></span>

<div class="button" onclick="gotohome()">Go to homepage</div>

<?php }
} ?>

</div>

</body>
<script>
function gotologin() {

    window.location.href="login.php?type=any";
}

function gotohome() {

window.location.href="index.php";
}
</script>
</html>