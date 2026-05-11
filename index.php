<?php
require_once('connection.php');
session_start();

/* PREVENT FORM RESUBMISSION */

if(isset($_SESSION['login_success']))
{
    unset($_SESSION['login_success']);
}

/* LOGIN */

if(isset($_POST['login']))
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass  = mysqli_real_escape_string($con, $_POST['pass']);

    if(empty($email) || empty($pass))
    {
        $_SESSION['error'] = "Please fill all fields";

        header("Location: index.php");
        exit();
    }
    else{

        $query = "SELECT * FROM users WHERE EMAIL='$email'";

        $res = mysqli_query($con, $query);

        if($row = mysqli_fetch_assoc($res))
        {
            $db_password = $row['PASSWORD'];

            if(md5($pass) == $db_password)
            {
                $_SESSION['email'] = $email;

                /* SUCCESS */

                $_SESSION['login_success'] = true;

                header("Location: cardetails.php");
                exit();
            }
            else{

                $_SESSION['error'] = "Incorrect Credentials";

                header("Location: index.php");
                exit();
            }

        }else{

            $_SESSION['error'] = "Incorrect Credentials";

            header("Location: index.php");
            exit();
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

<title>CaRs | Login</title>

<!-- GOOGLE FONT -->

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<!-- FONT AWESOME -->

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<script>

/* PREVENT BACK */

function preventBack(){

    window.history.forward();
}

setTimeout("preventBack()", 0);

window.onunload = function(){ null };

</script>

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

    background:
    linear-gradient(rgba(0,0,0,0.78), rgba(0,0,0,0.78)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow:hidden;
}

/* MAIN WRAPPER */

.hai{

    width:100%;
    min-height:100vh;

    padding:25px 50px;
}

/* NAVBAR */

.navbar{

    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:14px 35px;

    background:rgba(10,10,10,0.82);

    backdrop-filter:blur(12px);

    border-radius:20px;

    border:1px solid rgba(255,255,255,0.05);

    position:sticky;
    top:10px;

    z-index:999;
}

/* LOGO */

.logo{

    color:#ff7200;

    font-size:38px;

    font-weight:700;

    cursor:pointer;
}

.logo span{

    color:white;
}

/* MENU */

.menu ul{

    display:flex;
    align-items:center;

    gap:14px;

    list-style:none;
}

.menu ul li a{

    text-decoration:none;

    color:#dddddd;

    font-size:14px;

    font-weight:500;

    padding:12px 18px;

    border-radius:14px;

    transition:0.3s ease;

    display:flex;
    align-items:center;

    gap:8px;
}

.menu ul li a:hover,
.menu ul li a.active{

    background:#161616;

    color:#ff7200;
}

/* CONTENT */

.content{

    width:100%;

    min-height:calc(100vh - 120px);

    display:flex;
    justify-content:space-between;
    align-items:center;

    gap:50px;
}

/* LEFT SIDE */

.left{

    flex:1;
}

/* TITLE */

.left h1{

    color:white;

    font-size:72px;

    line-height:1.2;

    margin-bottom:20px;
}

.left h1 span{

    color:#ff7200;
}

/* PARAGRAPH */

.par{

    color:#dddddd;

    font-size:17px;

    line-height:1.9;

    margin-bottom:35px;
}

/* BUTTONS */

.buttons{

    display:flex;

    gap:18px;

    flex-wrap:wrap;
}

/* BUTTON */

.btn{

    padding:15px 28px;

    border-radius:16px;

    text-decoration:none;

    font-size:15px;

    font-weight:600;

    transition:0.3s ease;

    display:flex;
    align-items:center;

    gap:10px;
}

/* PRIMARY */

.btn-primary{

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    box-shadow:
    0 10px 25px rgba(255,114,0,0.25);
}

.btn-primary:hover{

    transform:translateY(-3px);
}

/* OUTLINE */

.btn-outline{

    background:rgba(255,255,255,0.08);

    border:1px solid rgba(255,255,255,0.10);

    color:white;
}

.btn-outline:hover{

    background:#ff7200;
}

/* LOGIN CARD */

.form{

    width:420px;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(14px);

    border-radius:28px;

    padding:40px;

    border:1px solid rgba(255,255,255,0.05);

    box-shadow:
    0 15px 35px rgba(0,0,0,0.35);
}

/* LOGIN TITLE */

.form h2{

    color:white;

    text-align:center;

    font-size:34px;

    margin-bottom:30px;
}

/* INPUT GROUP */

.input-group{

    margin-bottom:22px;
}

/* LABEL */

.input-group label{

    display:block;

    color:#dddddd;

    margin-bottom:10px;

    font-size:14px;

    font-weight:500;
}

/* INPUT BOX */

.input-box{

    position:relative;

    width:100%;
}

/* LEFT ICON */

.left-icon{

    position:absolute;

    left:18px;
    top:50%;

    transform:translateY(-50%);

    color:#ff7200;

    font-size:15px;

    z-index:2;
}

/* INPUT */

.input-box input{

    width:100%;

    height:58px;

    padding-left:50px;
    padding-right:55px;

    border:none;

    outline:none;

    border-radius:16px;

    background:rgba(255,255,255,0.08);

    color:white;

    font-size:14px;

    border:1px solid transparent;

    transition:0.3s ease;
}

/* FOCUS */

.input-box input:focus{

    border-color:#ff7200;
}

/* PLACEHOLDER */

input::placeholder{

    color:#aaaaaa;
}

/* TOGGLE ICON */

.toggle-icon{

    position:absolute;

    right:18px;
    top:50%;

    transform:translateY(-50%);

    cursor:pointer;

    color:#cccccc;

    font-size:15px;

    z-index:2;

    display:flex;
    justify-content:center;
    align-items:center;
}

.toggle-icon:hover{

    color:#ff7200;
}

/* LOGIN BUTTON */

.btnn{

    width:100%;

    height:58px;

    border:none;

    border-radius:16px;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s ease;

    margin-top:10px;
}

.btnn:hover{

    transform:translateY(-2px);
}

/* LINK */

.link{

    text-align:center;

    color:#cccccc;

    margin-top:25px;

    line-height:1.8;

    font-size:14px;
}

.link a{

    color:#ff7200;

    text-decoration:none;

    font-weight:600;
}

/* RESPONSIVE */

@media(max-width:1050px){

    .content{

        flex-direction:column;

        justify-content:center;

        padding-top:40px;
    }

    .left{

        text-align:center;
    }

    .left h1{

        font-size:54px;
    }

    .buttons{

        justify-content:center;
    }
}

@media(max-width:700px){

    body{

        overflow:auto;
    }

    .hai{

        padding:12px;
    }

    .navbar{

        flex-direction:column;

        gap:16px;

        padding:18px;
    }

    .menu ul{

        flex-wrap:wrap;

        justify-content:center;
    }

    .left h1{

        font-size:40px;
    }

    .par{

        font-size:14px;
    }

    .form{

        width:100%;

        padding:30px 20px;
    }
}

</style>

</head>

<body>

<?php

if(isset($_SESSION['error']))
{
    echo "<script>alert('".$_SESSION['error']."')</script>";

    unset($_SESSION['error']);
}

?>

<div class="hai">

    <!-- NAVBAR -->

    <div class="navbar">

        <div class="icon">

            <h2 class="logo"
            onclick="secretAdmin()">

                Ca<span>Rs</span>

            </h2>

        </div>

        <div class="menu">

            <ul>

                <li>

                    <a href="#" class="active">

                        <i class="fa-solid fa-house"></i>

                        HOME

                    </a>

                </li>

                <li>

                    <a href="cars.php">

                        <i class="fa-solid fa-car"></i>

                        Explore Cars

                    </a>

                </li>

                <li>

                    <a href="aboutus.html">

                        <i class="fa-solid fa-circle-info"></i>

                        ABOUT

                    </a>

                </li>

                <li>

                    <a href="services.html">

                        <i class="fa-solid fa-briefcase"></i>

                        SERVICES

                    </a>

                </li>

                <li>

                    <a href="contactus.html">

                        <i class="fa-solid fa-envelope"></i>

                        CONTACT

                    </a>

                </li>

            </ul>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="content">

        <!-- LEFT -->

        <div class="left">

            <h1>

                Rent Your <br>

                <span>Dream Car</span>

            </h1>

            <p class="par">

                Live the life of luxury with premium vehicles.<br>

                Choose from our modern car collections and<br>

                enjoy comfort, performance, and style.

            </p>

            <div class="buttons">

                <a href="register.php"
                class="btn btn-primary">

                    <i class="fa-solid fa-user-plus"></i>

                    JOIN US

                </a>

                <a href="cars.php"
                class="btn btn-outline">

                    <i class="fa-solid fa-car-side"></i>

                    Explore Cars

                </a>

            </div>

        </div>

        <!-- LOGIN FORM -->

        <div class="form">

            <h2>Login Here</h2>

            <form method="POST"
            action="">

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

                <!-- PASSWORD -->

                <div class="input-group">

                    <label>Password</label>

                    <div class="input-box">

                        <i class="fa-solid fa-lock left-icon"></i>

                        <input type="password"
                        name="pass"
                        id="password"
                        placeholder="Enter password"
                        required>

                        <span class="toggle-icon"
                        onclick="togglePassword()"
                        id="toggleIcon">

                            <i class="fa-solid fa-eye"></i>

                        </span>

                    </div>

                </div>

                <!-- BUTTON -->

                <input class="btnn"
                type="submit"
                value="LOGIN"
                name="login">

            </form>

            <p class="link">

                Don't have an account?<br>

                <a href="register.php">

                    Sign up here

                </a>

            </p>

        </div>

    </div>

</div>

<script>

/* TOGGLE PASSWORD */

function togglePassword(){

    let pass =
    document.getElementById("password");

    let icon =
    document.getElementById("toggleIcon");

    if(pass.type === "password"){

        pass.type = "text";

        icon.innerHTML =
        '<i class="fa-solid fa-eye-slash"></i>';

    }else{

        pass.type = "password";

        icon.innerHTML =
        '<i class="fa-solid fa-eye"></i>';
    }
}

/* SECRET ADMIN ACCESS */

let clickCount = 0;

function secretAdmin(){

    clickCount++;

    if(clickCount === 5){

        window.location.href =
        "adminlogin.php";
    }

    setTimeout(() => {

        clickCount = 0;

    }, 2000);
}

</script>

</body>
</html>