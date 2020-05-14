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
            loadsecond();
        } 
    }

}
function loadsecond()
{
    document.getElementById("step1").style.backgroundColor = "#76D7C4";
    document.getElementById("step1").style.fonStyle = "italic";
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
        if(document.getElementById("founder").value == '' || document.getElementById("startup_field").value == '' || document.getElementById("member1").value == ''|| document.getElementById("designation_member1").value == '' )
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
        if(document.getElementById("qualification1").value == '' || document.getElementById("field").value == '')
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
function loadthird()
{
    document.getElementById("step2").style.backgroundColor = "#76D7C4";
    document.getElementById("step2").style.fonStyle = "italic";
    document.getElementById("secondstep").style.display = "none";
    document.getElementById("thirdstep").style.display = "block";
    //document.getElementById("secondstep").innerHTML = "Your account has been successfully created!";
    //document.getElementById("secondstep").style.textAlign= "center";
}
function validate_step2()
{
    if(document.getElementById("profilename").value == '' || document.getElementById("phoneno").value == '' || document.getElementById("location").value == '' || !checkSpecific())
    {
        alert('Please Fill all the details!');
        return false;
    }
    else
    {
        loadthird();
        return true;
    }
}
var member_count = 1;
function addMember() {
    member_count++;
    var member = document.createElement('div');
    member.setAttribute('class', 'form-group');
    member.innerHTML =' <label for="member">Member ' +member_count+'</label> <input type="text" class="form-control" id="member' +member_count+'" name="member'+member_count+'" placeholder="Member ' +member_count+'">';
    document.getElementById('member_details').appendChild(member);
    
    var designation_member = document.createElement('div');
    designation_member.setAttribute('class', 'form-group');
    designation_member.innerHTML = '<label for="member_designation">Designation of Member ' +member_count+'</label><input type="text" class="form-control" id="designation_member' +member_count+'" name="designation_member' +member_count+'" placeholder="Designation of Member ' +member_count+'">';
    document.getElementById('member_details').appendChild(designation_member);              
}

var qual_count =1;
function addQualification()
{
    qual_count++;
    var qual = document.createElement('div');
    qual.setAttribute('class', 'form-group');
    qual.innerHTML = '<label for="qualification'+qual_count+'">Qualification '+qual_count+'</label><input type="text" class="form-control" id="qualification'+qual_count+'" name="qualification'+qual_count+'" placeholder="Qualification '+qual_count+'">';

    document.getElementById('qualification_details').appendChild(qual);
}

var link_count = 1;
function addLinks()
{
    link_count++;
    var link = document.createElement('div');
    link.setAttribute('class', 'form-group');
    link.innerHTML = '<label for="link'+link_count+'">Link '+link_count+'</label><input type="text" class="form-control" id="link'+link_count+'" name="link'+link_count+'" placeholder="Link '+link_count+'">';

    document.getElementById('link_details').appendChild(link);
}