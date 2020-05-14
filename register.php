<?php
include("dbconnect.php");
if(isset($_POST['Submit']))
{
    $user_insert = "INSERT INTO users(dp, username, password, name, location, phoneno, email, usertype) VALUES (?,?,?,?,?,?,?,?)";
    
    if($stmt= mysqli_prepare($conn, $user_insert) )
    {
        mysqli_stmt_bind_param($stmt, "ssssssss", $dp, $username, $password, $name, $location, $phoneno, $email, $usertype);
        $dp= "avatar.png"; //as of now let this be the profile pic
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $usertype = mysqli_real_escape_string($conn, $_POST['radio']);
        $name = mysqli_real_escape_string($conn, $_POST['profilename']);
        $phoneno = mysqli_real_escape_string($conn, $_POST['phoneno']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        
        if(mysqli_stmt_execute($stmt))
        {
            //echo "Inserted successfully";
            //Fetching userid
            $userid_query = "SELECT userid FROM users WHERE email = '$email'";
            $userid_result = mysqli_query($conn, $userid_query);
            $info = mysqli_fetch_array($userid_result, MYSQLI_ASSOC);
            $userid = $info['userid'];  

            session_start();
            if($usertype === "startup")
            {   
                $founder= mysqli_real_escape_string($conn, $_POST['founder']);
                $field = mysqli_real_escape_string($conn, $_POST['startup_field']);
                $member = mysqli_real_escape_string($conn, $_POST['member']);
                $member_designation = mysqli_real_escape_string($conn, $_POST['member_designation']);

                $startup_insert = "INSERT INTO startup VALUES ($userid, '$founder', '$field')";
                if(mysqli_query($conn, $startup_insert))
                {
                    //echo "Startup inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
                $member_insert = "INSERT INTO members VALUES ($userid, '$member', '$member_designation')";
                if(mysqli_query($conn, $member_insert))
                {
                    //echo "Startup members inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
            }
            else if($usertype === "mentor")
            {
                $field = mysqli_real_escape_string($conn, $_POST['field']);
                $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
                
                $mentor_insert = "INSERT INTO mentor VALUES ($userid, '$field')";
                if(mysqli_query($conn, $mentor_insert))
                {
                    //echo "Mentor inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
                $qual_insert = "INSERT INTO mentorqual VALUES ($userid, '$qualification')";
                if(mysqli_query($conn, $qual_insert))
                {
                    //echo "Mentor Qualification inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
            }
            else if ($usertype === "general")
            {   
                $designation = mysqli_real_escape_string($conn, $_POST['designation']);
                $general_insert = "INSERT INTO generaluser VALUES ($userid, '$designation')";
                if(mysqli_query($conn, $general_insert))
                {
                    //echo "General user inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
            }
            $_SESSION['userid'] = $userid;
            $_SESSION['name'] = $name;       
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = $usertype;
            $_SESSION['logged_in'] = true;

            header("location: dashboard.php");
        }
        else
        {
            echo "Error: Could not execute the query: " . mysqli_error($conn);
        }
    }
    else
    {
        echo "Error: Could not prepare the query: " . mysqli_error($conn);
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Register - Axel</title>
    <link rel="stylesheet" href="home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<div class="main-container">
    <div class="text">
    <h3>Time to evolve!</h3>
    <h6>Register yourself as an Axel member now!</h6>
    </div>
    <div class="progressbar">
        <div id="step1">STEP 1</div>
        <div id="step2">STEP 2</div>
    </div>
    <form action="" method="post">  
    <div id="firststep">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
        <label>User type:</label>
            <br>
            <input type ="radio" id = "startup" name="radio" value="startup" required> Startup
            <br>
            <input type ="radio" id = "mentor" name="radio" value="mentor" required> Mentor
            <br>
            <input type ="radio" id = "general" name="radio" value="general" required> General User
        </div>
    <div class="footer"><button type="button" name="Next" class="btn btn-modify" onclick="validate_step1()">Next</button></div>
    </div>
    <div id="secondstep">
        <div id="dp-holder">
            <img id="dp" name="dp" src="avatar.png">
        </div>
        <div class="form-group">
                <label for="profilename">Profile Name</label>
                <input type="text" class="form-control" id="profilename" name="profilename" placeholder="Profile Name">
        </div>
        <div class="form-group">
                <label for="phoneno">Phone Number</label>
                <input type="text" class="form-control" id="phoneno" name="phoneno" placeholder="Phone Number">
        </div>
        <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Location">
        </div>

        <div id="startup_form">
            <div class="form-group">
                    <label for="founder">Founder</label>
                    <input type="text" class="form-control" id="founder" name="founder" placeholder="Founder">
            </div>
            <div class="form-group">
                    <label for="startup_field">Field</label>
                    <input type="text" class="form-control" id="startup_field" name="startup_field" placeholder="Field">
            </div>
            <div class="form-group">
                    <label for="member">Member</label>
                    <input type="text" class="form-control" id="member" name="member" placeholder="Member">
            </div>
            <div class="form-group">
                <label for="member_designation">Member Designation</label>
                <input type="text" class="form-control" id="member_designation" name="member_designation" placeholder="Member Designation">
            </div>    
        </div>

        <div id="mentor_form">
            <div class="form-group">
                    <label for="field">Field</label>
                    <input type="text" class="form-control" id="field" name="field" placeholder="Field">
            </div>
            <div class="form-group">
                    <label for="qualification">Qualification</label>
                    <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Qualification">
            </div>   
        </div>

        <div id="general_form">
        <div class="form-group">
                <label for="Designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation">
        </div>  
        </div>
        <div class="footer">
            <button type="submit" name="Submit" class="btn btn-modify" onsubmit="event.preventDefault(); validate_step2();">Submit</button>
        </div>
    </div>
    
    </form>
</div>
<div class="main-container" id="redirect">
    Already Registered? <a href="login.php">Login here</a>
</div>
<script>

document.getElementById("step1").style.backgroundColor = "#76D7C4";
document.getElementById("step1").style.color = "white";

if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
function CheckedRadio() {
    var radioButtons = document.getElementsByName("radio");
    var retval = 0;
      for (var x = 0; x < radioButtons.length; x ++) {
        if (radioButtons[x].checked) {
           retval = 1;
        }
      }
    return retval;
}
function validateEmail()
{
    email = document.getElementById("email").value;
    var mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(email.match(mailformat))
    {
        return true;
    }
    else
    {
    alert("Please enter a valid email address!");    //The pop up alert for an invalid email address;
    return false;
    }
}  

function validate_step1()
{
    if(document.getElementById("email").value == '' || document.getElementById("username").value == '' || document.getElementById("password").value == '' || !CheckedRadio)
    {
        alert('Please Fill all the details!');
    }
    else
    {
        if(validateEmail())
        {
            loadnext();
        } 
    }

}
function loadnext()
{
    document.getElementById("step2").style.backgroundColor = "#76D7C4";
    document.getElementById("step2").style.color = "white";
    document.getElementById("step1").style.backgroundColor = "white";
    document.getElementById("step1").style.color = "black";
    document.getElementById("firststep").style.display = "none";
    document.getElementById("redirect").style.display = "none";
    document.getElementById("secondstep").style.display = "block";
    if(document.getElementById("startup").checked)
    {
        document.getElementById("startup_form").style.display = "block";
    }
    else if(document.getElementById("mentor").checked)
    {
        document.getElementById("mentor_form").style.display = "block";
    }
    else if(document.getElementById("general").checked)
    {
        document.getElementById("general_form").style.display = "block";
    }  
}
function checkSpecific()
{
    if(document.getElementById("startup").checked)
    {
        if(document.getElementById("founder").value == '' || document.getElementById("startup_field").value == '' || document.getElementById("member").value == ''|| document.getElementById("member_designation").value == '' )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    else if(document.getElementById("mentor").checked)
    {
        if(document.getElementById("qualification").value == '' || document.getElementById("field").value == '')
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    else if(document.getElementById("general").checked)
    {
        if(document.getElementById("designation").value == '')
        {
            return false;
        }
        else
        {
            return true;
        }
    }  


    
}
function loadfinal()
{
    document.getElementById("step2").style.backgroundColor = "#76D7C4";
    document.getElementById("step2").style.fonStyle = "italic";
    //document.getElementById("secondstep").style.display = "none";
    document.getElementById("secondstep").innerHTML = "Your account has been successfully created!";
    document.getElementById("secondstep").style.textAlign= "center";
}
function validate_step2()
{
    if(document.getElementById("profilename").value == '' || document.getElementById("phoneno").value == '' || document.getElementById("location").value == '' || !checkSpecific())
    {
        console.log("Entered");
        alert('Please Fill all the details!');
        return false;
    }
    else
    {
        loadfinal();
        return true;
    }
}
</script>
</body>
</html>

 

 