<?php
include("dbconnect.php");
$retval = false;
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
                $member_insert = "INSERT INTO members VALUES (?,?,?)";
                if($stmt = mysqli_prepare($conn, $member_insert))
                {
                    while($member !== '' && $desgination_member !== '')
                    {
                        mysqli_stmt_bind_param($stmt, "iss", $userid, $member, $desgination_member);
                        if(mysqli_stmt_execute($stmt))
                        {
                            echo "Member $member_count Inserted successfully";
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
                        else
                        {
                            echo "Error: Could not execute the query: " . mysqli_error($conn);
                        }
                    }
                }
                else
                {
                    echo "Error: Could not prepare the query: " . mysqli_error($conn);
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
                $qual = "";
                if(isset($_POST['qualification'.$qual_count.'']))
                {
                    $qual = mysqli_real_escape_string($conn,$_POST['qualification'.$qual_count.'']);
                }
                $qual_insert = "INSERT INTO mentorqual VALUES (?,?)";
                if($stmt = mysqli_prepare($conn, $qual_insert))
                {
                    while($qual !== '')
                    {
                        mysqli_stmt_bind_param($stmt,"is", $userid, $qual);
                        if(mysqli_stmt_execute($stmt))
                        {
                            echo "Qualification $qual_count Inserted successfully";
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
                        else
                        {
                            echo "Error: Could not execute the query: " . mysqli_error($conn);
                        }
                    }
                }
                else
                {
                    echo "Error: Could not prepare the query: " . mysqli_error($conn);
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
            $link = "";
            if(isset($_POST['link'.$link_count.'']))
            {
                $link = mysqli_real_escape_string($conn,$_POST['link'.$link_count.'']);
            }
            $link_insert = "INSERT INTO userlinks VALUES (?,?)"; 
            if($stmt = mysqli_prepare($conn, $link_insert))
            {
                mysqli_stmt_bind_param($stmt, "is", $userid, $link);
                while($link !== '')
                {
                    if(mysqli_stmt_execute($stmt))
                    {
                        echo "Link $link_count Inserted successfully";
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
                    else
                    {
                        echo "Error: Could not execute the query: " . mysqli_error($conn);
                    }
                }
            }
            else
            {
                echo "Error: Could not prepare the query: " . mysqli_error($conn);
            }           
            
            //Session creation
                session_start();
                $_SESSION['userid'] = $userid;
                $_SESSION['name'] = $name;       
                $_SESSION['email'] = $email;
                $_SESSION['usertype'] = $usertype;
                $_SESSION['logged_in'] = true;
                echo "Session created";
                
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
