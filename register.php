<?php
require_once('connection.php');

if(isset($_POST['regs']))
{
    $fname=mysqli_real_escape_string($con,$_POST['fname']);
    $lname=mysqli_real_escape_string($con,$_POST['lname']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $lic=mysqli_real_escape_string($con,$_POST['lic']);
    $ph=mysqli_real_escape_string($con,$_POST['ph']);
    $pass=mysqli_real_escape_string($con,$_POST['pass']);
    $cpass=mysqli_real_escape_string($con,$_POST['cpass']);
    $gender=mysqli_real_escape_string($con,$_POST['gender']);

    $Pass=md5($pass);

    /* ✅ PHONE VALIDATION ONLY */
    if(!preg_match('/^[0-9]{11}$/', $ph)){
        echo '<script>alert("Phone number must be exactly 11 digits")</script>';
    }

    else if(empty($fname)|| empty($lname)|| empty($email)|| empty($lic)|| empty($ph)|| empty($pass)|| empty($gender)){
        echo '<script>alert("Please fill all fields")</script>';
    }
    else{
        if($pass==$cpass){

            $check="SELECT * FROM users WHERE EMAIL='$email'";
            $res=mysqli_query($con,$check);

            if(mysqli_num_rows($res)>0){
                echo '<script>alert("Email already exists!")</script>';
                echo '<script>window.location.href="index.php"</script>';
            }
            else{
                $sql="INSERT INTO users (FNAME,LNAME,EMAIL,LIC_NUM,PHONE_NUMBER,PASSWORD,GENDER)
                VALUES('$fname','$lname','$email','$lic','$ph','$Pass','$gender')";

                if(mysqli_query($con,$sql)){
                    echo '<script>alert("Registration Successful!")</script>';
                    echo '<script>window.location.href="index.php"</script>';
                } else {
                    echo '<script>alert("Error occurred")</script>';
                }
            }
        }
        else{
            echo '<script>alert("Passwords do not match")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REGISTER | CaRs</title>

<style>
/* ✅ YOUR ORIGINAL STYLE (UNCHANGED) */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Poppins', sans-serif;
    background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70') no-repeat center/cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

body::before{
    content:'';
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.65);
    z-index:-1;
}

.main{
    width:900px;
    height:520px;
    background:rgba(0,0,0,0.85);
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
}

.password-box{position:relative;}

.password-box input{
    width:100%;
    padding-right:40px;
}

.password-box span{
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
}

.register{width:90%;color:#fff;}

.register h2{
    text-align:center;
    margin-bottom:15px;
    color:#ff7200;
}

#register{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

input{
    padding:10px;
    border:none;
    border-radius:5px;
}

.gender{
    grid-column:span 2;
    display:flex;
    justify-content:center;
    gap:20px;
}

.btnn{
    grid-column:span 2;
    padding:10px;
    background:#ff7200;
    color:#fff;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

#back{
    position:absolute;
    top:20px;
    left:20px;
    background:#ff7200;
    border:none;
    padding:10px 15px;
}

#back a{
    color:#fff;
    text-decoration:none;
}
</style>
</head>

<body>

<button id="back"><a href="index.php">HOME</a></button>

<div class="main">
<div class="register">
<h2>Register Here</h2>

<form id="register" method="POST">

<input type="text" name="fname" placeholder="First Name" required>
<input type="text" name="lname" placeholder="Last Name" required>

<input type="email" name="email" placeholder="Email" required>
<input type="text" name="lic" placeholder="License Number" required>

<!-- ✅ ONLY CHANGE HERE -->
<input type="tel" name="ph" placeholder="Phone Number"
maxlength="11"
pattern="[0-9]{11}"
oninput="this.value=this.value.replace(/[^0-9]/g,'')"
required>

<div class="password-box">
<input type="password" name="pass" id="psw" placeholder="Password" required>
<span onclick="togglePassword('psw', this)">👁️</span>
</div>

<div class="password-box">
<input type="password" name="cpass" id="cpsw" placeholder="Confirm Password" required>
<span onclick="togglePassword('cpsw', this)">👁️</span>
</div>

<div class="gender">
<label><input type="radio" name="gender" value="male"> Male</label>
<label><input type="radio" name="gender" value="female"> Female</label>
</div>

<input type="submit" class="btnn" value="REGISTER" name="regs">

</form>
</div>
</div>

<script>
/* ✅ YOUR TOGGLE (UNCHANGED) */
function togglePassword(id, icon){
    let input = document.getElementById(id);

    if(input.type === "password"){
        input.type = "text";
        icon.textContent = "🙈";
    } else {
        input.type = "password";
        icon.textContent = "👁️";
    }
}
</script>

</body>
</html>