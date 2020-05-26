<?php
include("dbconnect.php");
if(isset($_POST['Submit']))
{
    $user_insert = "INSERT INTO users(dp, username, password, name, location, phoneno, email, usertype, vkey) VALUES (?,?,?,?,?,?,?,?,?)";
    
    if($stmt= mysqli_prepare($conn, $user_insert) )
    {
        mysqli_stmt_bind_param($stmt, "sssssssss", $dp, $username, $password, $name, $location, $phoneno, $email, $usertype, $vkey);
        $dp= "avatar.png"; //as of now let this be the profile pic
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $usertype = mysqli_real_escape_string($conn, $_POST['radio']);
        $name = mysqli_real_escape_string($conn, $_POST['profilename']);
        $phoneno = mysqli_real_escape_string($conn, $_POST['phoneno']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $vkey = md5(time().$username); //md5 hash of username and time
         
        if(mysqli_stmt_execute($stmt))
        {
            echo "Inserted successfully";
            //Fetching userid
            $userid_query = "SELECT userid FROM users WHERE email = '$email'";
            $userid_result = mysqli_query($conn, $userid_query);
            $info = mysqli_fetch_array($userid_result, MYSQLI_ASSOC);
            $userid = $info['userid'];  

            if($usertype === "startup") //For startup 
            {   
                $founder= mysqli_real_escape_string($conn, $_POST['founder']);
                $field = mysqli_real_escape_string($conn, $_POST['startup_field']);
                //inserting into startup table
                $startup_insert = "INSERT INTO startup VALUES ($userid, '$founder', '$field')";
                if(mysqli_query($conn, $startup_insert))
                {
                    echo "Startup inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
                
                //inserting the members of startup
                $member_count = 1;
                $member_insert = "";
                $member = "";
                $desgination_member = "";
                if(isset($_POST['member'.$member_count.'']))
                {
                    $member = mysqli_real_escape_string($conn,$_POST['member'.$member_count.'']);
                }
                if(isset($_POST['designation_member'.$member_count.'']))
                {
                    $desgination_member = mysqli_real_escape_string($conn,$_POST['designation_member'.$member_count.'']);
                }
                
                while($member !== '' && $desgination_member !== '')
                {
                    $member_insert .= "INSERT INTO members VALUES ($userid, '$member', '$desgination_member');";
                    $member_count++;
                    $member = "";
                    $desgination_member = "";
                    if(isset($_POST['member'.$member_count.'']))
                    {
                        $member = mysqli_real_escape_string($conn,$_POST['member'.$member_count.'']);
                    }
                    if(isset($_POST['designation_member'.$member_count.'']))
                    {
                        $desgination_member = mysqli_real_escape_string($conn,$_POST['designation_member'.$member_count.'']);
                    }
                        if($member === '' || $desgination_member === '')
                        {
                            $member_count--;
                        }
                    }
                
                if($member_count === 1)
                {
                    if($member_insert !== '')
                    {
                        if(mysqli_query($conn, $member_insert))
                    {
                        echo "Member inserted successfully";
                    }
                    else
                    {
                        echo "Error: Could not execute the query: " . mysqli_error($conn);
                    }
                    }
                }
                else if($member_count > 1)
                {
                    if(mysqli_multi_query($conn, $member_insert))
                    {
                        echo "Members  inserted successfully";
                    }
                    else
                    {
                        echo "Error: Could not execute the query: " . mysqli_error($conn);
                    }
                }
            }
            else if($usertype === "mentor") //For mentor
            {
                $field = mysqli_real_escape_string($conn, $_POST['field']);
                //inserting into mentor table               
                $mentor_insert = "INSERT INTO mentor VALUES ($userid, '$field')";
                if(mysqli_query($conn, $mentor_insert))
                {
                    echo "Mentor inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
                //inserting mentor qualifications
                $qual_count = 1;
                $qual_insert = "";
                $qual = "";
                if(isset($_POST['qualification'.$qual_count.'']))
                {
                    $qual = mysqli_real_escape_string($conn,$_POST['qualification'.$qual_count.'']);
                }
                
                while($qual !== '')
                {
                    $qual_insert .= "INSERT INTO mentorqual VALUES ($userid, '$qual');";
                    $qual_count++;
                    $qual = "";
                    if(isset($_POST['qualification'.$qual_count.'']))
                    {
                        $qual = mysqli_real_escape_string($conn,$_POST['qualification'.$qual_count.'']);
                    }
                    if($qual === '')
                    {
                        $qual_count--;
                    }
                }
                
                if($qual_count === 1)
                {
                    if($qual_insert !== '')
                    {
                        if(mysqli_query($conn, $qual_insert))
                    {
                        echo "Qualification inserted successfully";
                    }
                    else
                    {
                        echo "Error: Could not execute the query: " . mysqli_error($conn);
                    }
                    }
                }
                else if($qual_count > 1)
                {
                    if(mysqli_multi_query($conn, $qual_insert))
                    {
                        echo "Qualifications inserted successfully";
                    }
                    else
                    {
                        echo "Error: Could not execute the query: " . mysqli_error($conn);
                    }
                }
            }
            else if ($usertype === "general") //For general user
            {   
                $designation = mysqli_real_escape_string($conn, $_POST['designation']);
                $general_insert = "INSERT INTO generaluser VALUES ($userid, '$designation')";
                //inserting into generaluser
                if(mysqli_query($conn, $general_insert))
                {
                    echo "General user inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
            }
            //inserting user links
            $link_count = 1;
            $link_insert = "";
            $link = "";
            if(isset($_POST['link'.$link_count.'']))
            {
                $link = mysqli_real_escape_string($conn,$_POST['link'.$link_count.'']);
            }
            
            while($link !== '')
            {
                $link_insert .= "INSERT INTO userlinks VALUES ($userid, '$link');";
                $link_count++;
                $link = "";
                if(isset($_POST['link'.$link_count.'']))
                {
                    $link = mysqli_real_escape_string($conn,$_POST['link'.$link_count.'']);
                }
                if($link === '')
                {
                    $link_count--;
                }
            }
            
            if($link_count === 1)
            {
                if($link_insert !== '')
                {
                    if(mysqli_query($conn, $link_insert))
                    {
                        echo "Link inserted successfully";
                    }
                    else
                    {
                        echo "Error: Could not execute the query: " . mysqli_error($conn);
                    }
                }
            }
            else if($link_count > 1)
            {
                if(mysqli_multi_query($conn, $link_insert))
                {
                    echo "Links inserted successfully";
                }
                else
                {
                    echo "Error: Could not execute the query: " . mysqli_error($conn);
                }
            }


            //Sending verification email
            $subject = "Axel - Email Verification";
            $message = "Hello $c_name, you are one step away from using Axel! <a href= 'https://localhost/AXEL/verify.php?vkey=$vkey'>Click Here</a> to verify your email address and activate your account!";
            $headers = "From: thisisourprojectx@gmail.com" . "\r\n";
            // Always set content-type when sending HTML email
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            if(mail($email,$subject,$message,$headers))
            {
            header("Location: thankyou.php");
            }
            else
            {
            header("Location: error.php");
            }


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
