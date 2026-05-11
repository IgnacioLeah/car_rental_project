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

    /* PHONE VALIDATION */

    if(!preg_match('/^[0-9]{11}$/', $ph)){

        echo '<script>alert("Phone number must be exactly 11 digits")</script>';
    }

    else if(
        empty($fname) ||
        empty($lname) ||
        empty($email) ||
        empty($lic) ||
        empty($ph) ||
        empty($pass) ||
        empty($gender)
    ){

        echo '<script>alert("Please fill all fields")</script>';
    }

    else{

        if($pass==$cpass){

            $check="SELECT * FROM users WHERE EMAIL='$email'";

            $res=mysqli_query($con,$check);

            if(mysqli_num_rows($res)>0){

                echo '<script>alert("Email already exists!")</script>';

                echo '<script>window.location.href="index.php"</script>';

            }else{

                $sql="INSERT INTO users
                (FNAME,LNAME,EMAIL,LIC_NUM,PHONE_NUMBER,PASSWORD,GENDER)
                VALUES
                ('$fname','$lname','$email','$lic','$ph','$Pass','$gender')";

                if(mysqli_query($con,$sql)){

                    echo '<script>alert("Registration Successful!")</script>';

                    echo '<script>window.location.href="index.php"</script>';

                }else{

                    echo '<script>alert("Error occurred")</script>';
                }
            }

        }else{

            echo '<script>alert("Passwords do not match")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible"
content="IE=edge">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>REGISTER | CaRs</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

/* BODY */

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;

    background:
    linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.82)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow-x:hidden;
}

/* HOME BUTTON */

.home-btn{

    position:absolute;

    top:25px;
    left:25px;

    padding:12px 22px;

    background:#ff7200;

    color:white;

    text-decoration:none;

    border-radius:14px;

    font-size:14px;

    font-weight:600;

    transition:0.3s ease;

    display:flex;
    align-items:center;

    gap:8px;

    box-shadow:
    0 8px 20px rgba(255,114,0,0.25);
}

.home-btn:hover{

    background:#ff8c1a;

    transform:translateY(-2px);
}

/* MAIN CARD */

.main{

    width:100%;

    max-width:900px;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(14px);

    border-radius:32px;

    border:1px solid rgba(255,255,255,0.06);

    box-shadow:
    0 15px 35px rgba(0,0,0,0.35);

    padding:50px;
}

/* REGISTER */

.register{

    width:100%;
}

/* TITLE */

.register h2{

    color:white;

    text-align:center;

    font-size:42px;

    margin-bottom:10px;
}

.register p{

    color:#bbbbbb;

    text-align:center;

    font-size:15px;

    margin-bottom:35px;
}

/* FORM */

#register{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:24px;

    width:100%;
}

/* INPUT GROUP */

.input-group{

    display:flex;
    flex-direction:column;

    width:100%;
}

/* FULL WIDTH */

.full-width{

    grid-column:span 2;
}

/* LABEL */

.input-group label{

    color:#dddddd;

    font-size:14px;

    margin-bottom:10px;

    font-weight:500;
}

/* INPUT BOX */

.input-box{

    position:relative;

    width:100%;
}

/* LEFT ICON */

.input-box .left-icon{

    position:absolute;

    top:50%;
    left:18px;

    transform:translateY(-50%);

    color:#ff7200;

    font-size:15px;
}

/* TOGGLE PASSWORD */

.toggle-password{

    position:absolute;

    top:50%;
    right:18px;

    transform:translateY(-50%);

    color:#cccccc;

    cursor:pointer;

    font-size:15px;

    z-index:2;
}

/* INPUT */

.input-box input{

    width:100%;

    height:62px;

    padding-left:52px;

    padding-right:52px;

    border:none;

    outline:none;

    border-radius:18px;

    background:rgba(255,255,255,0.10);

    color:white;

    font-size:15px;

    border:1px solid transparent;

    transition:0.3s ease;
}

/* FOCUS */

.input-box input:focus{

    border-color:#ff7200;

    background:rgba(255,255,255,0.13);
}

/* PLACEHOLDER */

input::placeholder{

    color:#aaaaaa;
}

/* GENDER */

.gender{

    grid-column:span 2;

    display:flex;
    justify-content:center;

    gap:40px;

    margin-top:5px;
}

.gender label{

    color:white;

    font-size:15px;

    display:flex;
    align-items:center;

    gap:10px;

    cursor:pointer;
}

.gender input{

    accent-color:#ff7200;

    width:16px;
    height:16px;
}

/* BUTTON */

.btnn{

    grid-column:span 2;

    height:62px;

    border:none;

    border-radius:18px;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    font-size:17px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s ease;

    margin-top:10px;
}

.btnn:hover{

    transform:translateY(-2px);

    background:
    linear-gradient(
    135deg,
    #ff8c1a,
    #ff7200
    );
}

/* RESPONSIVE */

@media(max-width:750px){

    body{

        padding:14px;
    }

    .main{

        padding:35px 22px;
    }

    #register{

        grid-template-columns:1fr;
    }

    .full-width,
    .btnn{

        grid-column:span 1;
    }

    .gender{

        grid-column:span 1;

        flex-direction:column;

        align-items:flex-start;

        gap:16px;
    }

    .register h2{

        font-size:32px;
    }

    .home-btn{

        top:15px;
        left:15px;

        padding:10px 18px;

        font-size:13px;
    }
}

</style>

</head>

<body>

<!-- HOME BUTTON -->

<a href="index.php"
class="home-btn">

    <i class="fa-solid fa-house"></i>

    HOME

</a>

<!-- MAIN -->

<div class="main">

    <div class="register">

        <h2>Create Account</h2>

        <p>
            Fill in your details to get started.
        </p>

        <form id="register"
        method="POST">

            <!-- FIRST NAME -->

            <div class="input-group">

                <label>First Name</label>

                <div class="input-box">

                    <i class="fa-solid fa-user left-icon"></i>

                    <input type="text"
                    name="fname"
                    placeholder="Enter first name"
                    required>

                </div>

            </div>

            <!-- LAST NAME -->

            <div class="input-group">

                <label>Last Name</label>

                <div class="input-box">

                    <i class="fa-solid fa-user left-icon"></i>

                    <input type="text"
                    name="lname"
                    placeholder="Enter last name"
                    required>

                </div>

            </div>

            <!-- EMAIL -->

            <div class="input-group">

                <label>Email</label>

                <div class="input-box">

                    <i class="fa-solid fa-envelope left-icon"></i>

                    <input type="email"
                    name="email"
                    placeholder="Enter email"
                    required>

                </div>

            </div>

            <!-- LICENSE -->

            <div class="input-group">

                <label>License Number</label>

                <div class="input-box">

                    <i class="fa-solid fa-id-card left-icon"></i>

                    <input type="text"
                    name="lic"
                    placeholder="Enter license number"
                    required>

                </div>

            </div>

            <!-- PHONE -->

            <div class="input-group full-width">

                <label>Phone Number</label>

                <div class="input-box">

                    <i class="fa-solid fa-phone left-icon"></i>

                    <input type="tel"
                    name="ph"
                    placeholder="09XXXXXXXXX"
                    maxlength="11"
                    pattern="[0-9]{11}"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                    required>

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="input-group">

                <label>Password</label>

                <div class="input-box">

                    <i class="fa-solid fa-lock left-icon"></i>

                    <input type="password"
                    name="pass"
                    id="psw"
                    placeholder="Enter password"
                    required>

                    <i class="fa-solid fa-eye toggle-password"
                    onclick="togglePassword('psw', this)"></i>

                </div>

            </div>

            <!-- CONFIRM PASSWORD -->

            <div class="input-group">

                <label>Confirm Password</label>

                <div class="input-box">

                    <i class="fa-solid fa-lock left-icon"></i>

                    <input type="password"
                    name="cpass"
                    id="cpsw"
                    placeholder="Confirm password"
                    required>

                    <i class="fa-solid fa-eye toggle-password"
                    onclick="togglePassword('cpsw', this)"></i>

                </div>

            </div>

            <!-- GENDER -->

            <div class="gender">

                <label>

                    <input type="radio"
                    name="gender"
                    value="male"
                    required>

                    Male

                </label>

                <label>

                    <input type="radio"
                    name="gender"
                    value="female">

                    Female

                </label>

            </div>

            <!-- BUTTON -->

            <input type="submit"
            class="btnn"
            value="REGISTER"
            name="regs">

        </form>

    </div>

</div>

<script>

/* TOGGLE PASSWORD */

function togglePassword(id, icon){

    let input =
    document.getElementById(id);

    if(input.type === "password"){

        input.type = "text";

        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    }else{

        input.type = "password";

        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

</script>

</body>
</html>