<?php
require_once('connection.php');
session_start();

/* PREVENT RESUBMISSION */

if(isset($_SESSION['admin_login_success']))
{
    unset($_SESSION['admin_login_success']);
}

/* ADMIN LOGIN */

if(isset($_POST['adlog'])){

    $id   = mysqli_real_escape_string($con, $_POST['adid']);
    $pass = mysqli_real_escape_string($con, $_POST['adpass']);

    if(empty($id) || empty($pass))
    {
        $_SESSION['error'] = "Please fill all fields";

        header("Location: adminlogin.php");
        exit();
    }
    else{

        $query = "SELECT * FROM admin WHERE ADMIN_ID='$id'";

        $res = mysqli_query($con, $query);

        if($row = mysqli_fetch_assoc($res))
        {
            $db_password = $row['ADMIN_PASSWORD'];

            if($pass == $db_password)
            {
                $_SESSION['admin'] = $id;

                $_SESSION['admin_login_success'] = true;

                header("Location: admindash.php");
                exit();
            }
            else{

                $_SESSION['error'] = "Invalid Credentials";

                header("Location: adminlogin.php");
                exit();
            }

        }else{

            $_SESSION['error'] = "Invalid Credentials";

            header("Location: adminlogin.php");
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

<title>CaRs | Admin Login</title>

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

    display:flex;
    justify-content:center;
    align-items:center;

    padding:20px;

    background:
    linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.82)),
    url("images/adminbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow:hidden;
}

/* HOME BUTTON */

.back{

    position:absolute;

    top:25px;
    left:25px;

    padding:13px 22px;

    border:none;

    border-radius:16px;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    box-shadow:
    0 10px 25px rgba(255,114,0,0.25);

    transition:0.3s ease;
}

.back:hover{

    transform:translateY(-2px);
}

.back a{

    color:white;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    display:flex;
    align-items:center;

    gap:8px;
}

/* MAIN WRAPPER */

.wrapper{

    width:100%;

    max-width:1200px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    gap:60px;
}

/* LEFT SIDE */

.left{

    flex:1;
}

/* BADGE */

.badge{

    width:max-content;

    padding:10px 18px;

    border-radius:50px;

    background:rgba(255,114,0,0.15);

    border:1px solid rgba(255,114,0,0.30);

    color:#ff7200;

    font-size:13px;

    font-weight:600;

    margin-bottom:24px;
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

.left p{

    color:#dddddd;

    font-size:16px;

    line-height:1.9;
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

    backdrop-filter:blur(16px);

    border-radius:30px;

    padding:40px;

    border:1px solid rgba(255,255,255,0.06);

    box-shadow:
    0 15px 35px rgba(0,0,0,0.35);
}

/* TITLE */

.form h2{

    text-align:center;

    color:white;

    font-size:34px;

    margin-bottom:8px;
}

.subtitle{

    text-align:center;

    color:#bbbbbb;

    font-size:14px;

    margin-bottom:35px;
}

/* INPUT GROUP */

.input-group{

    margin-bottom:22px;
}

/* LABEL */

.input-group label{

    display:block;

    color:#dddddd;

    font-size:14px;

    margin-bottom:10px;

    font-weight:500;
}

/* INPUT BOX */

.input-box{

    position:relative;
}

/* ICON */

.left-icon{

    position:absolute;

    left:18px;
    top:50%;

    transform:translateY(-50%);

    color:#ff7200;

    z-index:2;
}

/* INPUT */

.input-box input{

    width:100%;

    height:58px;

    padding-left:52px;
    padding-right:55px;

    border:none;

    outline:none;

    border-radius:18px;

    background:rgba(255,255,255,0.08);

    border:1px solid transparent;

    color:white;

    font-size:14px;

    transition:0.3s ease;
}

/* FOCUS */

.input-box input:focus{

    border-color:#ff7200;

    background:rgba(255,255,255,0.12);
}

/* PLACEHOLDER */

input::placeholder{

    color:#aaaaaa;
}

/* TOGGLE */

.toggle-password{

    position:absolute;

    right:18px;
    top:50%;

    transform:translateY(-50%);

    cursor:pointer;

    color:#cccccc;

    z-index:2;
}

.toggle-password:hover{

    color:#ff7200;
}

/* BUTTON */

.btnn{

    width:100%;

    height:58px;

    border:none;

    border-radius:18px;

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

/* RESPONSIVE */

@media(max-width:950px){

    body{

        overflow:auto;
    }

    .wrapper{

        flex-direction:column;

        justify-content:center;

        text-align:center;
    }

    .left h1{

        font-size:48px;
    }
}

@media(max-width:600px){

    body{

        padding:12px;
    }

    .form{

        width:100%;

        padding:30px 20px;
    }

    .left h1{

        font-size:36px;
    }

    .left p{

        font-size:14px;
    }

    .back{

        top:15px;
        left:15px;
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

<!-- HOME BUTTON -->

<button class="back">

    <a href="index.php">

        <i class="fa-solid fa-house"></i>

        Go To Home

    </a>

</button>

<!-- MAIN -->

<div class="wrapper">

    <!-- LEFT SIDE -->

    <div class="left">

        <div class="badge">
            ADMIN ACCESS
        </div>

        <h1>

            Hello <span>Admin</span>

        </h1>

        <p>

            Access the dashboard to manage cars,
            bookings, users, and rental services
            with full administrative control.

        </p>

    </div>

    <!-- LOGIN FORM -->

    <form class="form"
    method="POST">

        <h2>Admin Login</h2>

        <p class="subtitle">

            Enter your admin credentials

        </p>

        <!-- ADMIN ID -->

        <div class="input-group">

            <label>Admin ID</label>

            <div class="input-box">

                <i class="fa-solid fa-user-shield left-icon"></i>

                <input type="text"
                name="adid"
                placeholder="Enter admin ID"
                required>

            </div>

        </div>

        <!-- PASSWORD -->

        <div class="input-group">

            <label>Password</label>

            <div class="input-box">

                <i class="fa-solid fa-lock left-icon"></i>

                <input type="password"
                name="adpass"
                id="adpass"
                placeholder="Enter password"
                required>

                <span class="toggle-password"
                onclick="togglePassword()"
                id="toggleIcon">

                    <i class="fa-solid fa-eye"></i>

                </span>

            </div>

        </div>

        <!-- BUTTON -->

        <input type="submit"
        class="btnn"
        value="LOGIN"
        name="adlog">

    </form>

</div>

<script>

/* TOGGLE PASSWORD */

function togglePassword(){

    let pass =
    document.getElementById("adpass");

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

</script>

</body>
</html>