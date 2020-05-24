<?php
if(isset($_POST["login"]))
{
    include('dbconnect.php');
    session_start();
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $usertype = mysqli_real_escape_string($conn, $_POST['radio']);
    
    $query = "SELECT userid,name,usertype FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) === 1 and $row['usertype'] === $usertype)
    {
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['name'] = $row['name'];       
        $_SESSION['email'] = $email;
        $_SESSION['usertype'] = $usertype;
        $_SESSION['logged_in'] = true;

        header("location: dashboard.php");
    }
    else
    {
        session_abort();
        echo "<script> alert(\"Invalid email or password or usertype\")</script>";
    }
}
?>
<!DOCTYPE html>
<head>
<title>Login - Axel</title>
<link rel="stylesheet" href="home.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="icon" href="logo.png">
<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/@clr/ui/clr-ui.min.css" />
<link rel="stylesheet" href="https://unpkg.com/@clr/ui@0.12.5/clr-ui.min.css" />
</head>

<style>
.loginbut
{
    background-color: #76D7C4 !important;
}

.loginbut:hover,.loginbut:focus
{
    color:#76D7C4 !important;
    background-color:white !important;
    border:1px solid #76D7C4 !important;
    outline:none !important;
    box-shadow:none !important;
}

.login-wrapper
{
    opacity:0.2;
    transform:translateX(-75px);
    animation-name:login !important;
    animation-duration:0.5s !important;
    animation-fill-mode:forwards !important;
}

.login
{
    transform:translateX(-100px);
    animation-name:login !important;
    animation-duration:0.5s !important;
    opacity:0.2;
    animation-fill-mode:forwards !important;
}

#email:focus,#pass:focus
{
    background:none !important;
    background-size:0 0 !important;
    border-bottom:1px solid #76D7C4 !important;
}

@keyframes login {
    100%
    {
        transform:translateX(0);
        opacity:1;
    }
}
</style>

<body>
    <div class="login-wrapper" style="background:url('regbg.jpg');background-position:center;background-attachment:fixed;background-repeat: no-repeat;background-size: cover">
        <form class="login" action="" method="post">
            <section class="title">
                <h1 class="welcome">Login</h1>
                <h4>Now is your time to <span style="color:#76D7C4">evolve.</span></h4>
            </section>
            <div class="login-group">
                <clr-input-container>
                <label class="clr-sr-only">Email Address</label>
                <input type="email" name="email" id="email" style="padding:20px 0;margin-bottom:20px;width:80%" clrInput placeholder="Email" [(ngModel)]="form.email" required/>
                </clr-input-container>
                <clr-password-container>
                <label class="clr-sr-only">Password</label>
                <input type="password" name="password" id="pass" style="padding:20px 0;margin-bottom:20px;width:80%"  clrPassword placeholder="Password" [(ngModel)]="form.password" required/>
                </clr-password-container>
                <clr-checkbox-wrapper>
                <!--<label>Remember me</label>
                <input type="checkbox" name="rememberMe" clrCheckbox [(ngModel)]="form.rememberMe"/><br>-->

                <label><b>User type:</b></label>
                <br>
                <input type ="radio" id = "startup" name="radio" value="startup" required> Startup
                <br>
                <input type ="radio" id = "mentor" name="radio" value="mentor" required> Mentor
                <br>
                <input type ="radio" id = "general" name="radio" value="general" required> General User
                </clr-checkbox-wrapper>
                <button type="submit" name="login" style="margin-top:25px;width:80%;border:none" class="btn btn-primary loginbut">Login</button>
                <a href="register.html"  style="margin-top:15px;width:80%;color:#76D7C4 !important" class="signup">I want to create a new account!</a>
            </div>
        </form>
    </div>
</body>
</html>