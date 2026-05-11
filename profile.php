<?php
session_start();
require_once('connection.php');

/* PROTECT PAGE */

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

/* GET USER */

$userQuery = mysqli_query(
$con,
"SELECT * FROM users WHERE EMAIL='$email'"
);

$user = mysqli_fetch_assoc($userQuery);

/* UPDATE PROFILE */

$message = "";

if(isset($_POST['update'])){

    $fname = mysqli_real_escape_string(
    $con,
    trim($_POST['fname'])
    );

    $lname = mysqli_real_escape_string(
    $con,
    trim($_POST['lname'])
    );

    $newEmail = mysqli_real_escape_string(
    $con,
    trim($_POST['email'])
    );

    $password = trim($_POST['password']);

    /* CURRENT DATA */

    $currentFname = $user['FNAME'];
    $currentLname = $user['LNAME'];
    $currentEmail = $user['EMAIL'];

    /* VALIDATION */

    if(empty($fname) ||
       empty($lname) ||
       empty($newEmail)){

        $message = "Please fill all required fields.";

    }else{

        /* CHECK IF NOTHING CHANGED */

        if(
            $fname == $currentFname &&
            $lname == $currentLname &&
            $newEmail == $currentEmail &&
            empty($password)
        ){

            $message = "No changes detected.";

        }else{

            /* UPDATE WITH PASSWORD */

            if(!empty($password)){

                $update = mysqli_query(
                $con,
                "UPDATE users SET
                FNAME='$fname',
                LNAME='$lname',
                EMAIL='$newEmail',
                PASSWORD='$password'
                WHERE EMAIL='$email'"
                );

            }else{

                /* UPDATE WITHOUT PASSWORD */

                $update = mysqli_query(
                $con,
                "UPDATE users SET
                FNAME='$fname',
                LNAME='$lname',
                EMAIL='$newEmail'
                WHERE EMAIL='$email'"
                );
            }

            if($update){

                $_SESSION['email'] = $newEmail;

                $email = $newEmail;

                $message = "Profile Updated Successfully!";

                /* REFRESH USER */

                $userQuery = mysqli_query(
                $con,
                "SELECT * FROM users WHERE EMAIL='$email'"
                );

                $user = mysqli_fetch_assoc($userQuery);

            }else{

                $message = "Failed to update profile.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Profile Settings | CaRs</title>

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

    background:
    linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.82)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow-x:hidden;

    padding:20px;
}

/* WRAPPER */

.main-wrapper{

    width:100%;
    max-width:1300px;

    margin:auto;
}

/* NAVBAR */

.navbar{

    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:14px 35px;

    background:rgba(10,10,10,0.82);

    backdrop-filter:blur(10px);

    border-radius:18px;

    margin-bottom:30px;

    position:sticky;
    top:10px;

    z-index:999;

    border:1px solid rgba(255,255,255,0.05);
}

/* LOGO */

.logo{

    color:#ff7200;

    font-size:34px;

    font-weight:700;
}

.logo span{

    color:white;
}

/* MENU */

.menu{

    display:flex;
    align-items:center;

    gap:28px;
}

.menu ul{

    display:flex;
    align-items:center;

    gap:12px;

    list-style:none;
}

.menu ul li a{

    text-decoration:none;

    color:#d9d9d9;

    font-size:14px;

    font-weight:500;

    padding:12px 18px;

    border-radius:12px;

    transition:0.3s ease;

    display:flex;
    align-items:center;

    gap:8px;
}

.menu ul li a:hover,
.menu ul li a.active{

    background:#161616;

    color:#ff7b00;
}

/* PROFILE */

.profile{

    position:relative;
}

.profile-btn{

    display:flex;
    align-items:center;

    gap:12px;

    padding:8px 12px;

    background:#111;

    border:1px solid rgba(255,255,255,0.08);

    border-radius:50px;

    cursor:pointer;

    transition:0.3s ease;
}

.profile-btn:hover{

    background:#1a1a1a;
}

/* PROFILE IMAGE */

.circle{

    width:46px;
    height:46px;

    border-radius:50%;

    object-fit:cover;

    border:2px solid #ff7200;
}

/* PROFILE INFO */

.profile-info{

    display:flex;
    flex-direction:column;
}

.profile-name{

    color:white;

    font-size:14px;

    font-weight:600;
}

.profile-info small{

    color:#bbbbbb;

    font-size:11px;
}

/* DROPDOWN */

.dropdown{

    position:absolute;

    top:78px;
    right:0;

    width:260px;

    background:#111;

    border-radius:18px;

    overflow:hidden;

    border:1px solid rgba(255,255,255,0.08);

    opacity:0;
    visibility:hidden;

    transform:translateY(10px);

    transition:0.3s ease;

    z-index:999;
}

.dropdown.show{

    opacity:1;
    visibility:visible;

    transform:translateY(0);
}

.dropdown-header{

    display:flex;
    align-items:center;

    gap:12px;

    padding:18px;

    background:#181818;
}

.dropdown-img{

    width:55px;
    height:55px;

    border-radius:50%;

    border:2px solid #ff7200;
}

.dropdown-header h4{

    color:white;

    font-size:15px;
}

.dropdown-header p{

    color:#aaaaaa;

    font-size:11px;
}

.dropdown-links{

    padding:10px;
}

.dropdown-links a{

    display:flex;
    align-items:center;

    gap:12px;

    padding:14px;

    border-radius:12px;

    color:white;

    text-decoration:none;

    font-size:13px;

    transition:0.3s;
}

.dropdown-links a:hover{

    background:#ff7200;
}

/* PROFILE CONTAINER */

.profile-container{

    width:100%;

    max-width:700px;

    margin:auto;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border-radius:24px;

    padding:40px;

    border:1px solid rgba(255,255,255,0.05);
}

/* TITLE */

.profile-title{

    text-align:center;

    margin-bottom:30px;
}

.profile-title h1{

    color:white;

    font-size:34px;

    margin-bottom:8px;
}

.profile-title p{

    color:#bbbbbb;

    font-size:14px;
}

/* MESSAGE */

.message{

    background:#ff7200;

    color:white;

    padding:14px;

    border-radius:14px;

    text-align:center;

    margin-bottom:20px;

    font-size:14px;
}

/* INPUT GROUP */

.input-group{

    margin-bottom:20px;
}

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
}

.input-box i{

    position:absolute;

    top:50%;
    left:15px;

    transform:translateY(-50%);

    color:#ff7200;
}

.input-box .toggle-password{

    position:absolute;

    right:15px;
    left:auto;

    cursor:pointer;

    color:#cccccc;
}

/* INPUT */

.input-box input{

    width:100%;

    padding:15px 45px;

    border:none;

    outline:none;

    border-radius:16px;

    background:rgba(255,255,255,0.08);

    color:white;

    font-size:14px;

    border:1px solid transparent;

    transition:0.3s ease;
}

.input-box input:focus{

    border-color:#ff7200;
}

/* BUTTON */

.update-btn{

    width:100%;

    padding:16px;

    border:none;

    border-radius:16px;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    font-size:15px;

    font-weight:600;

    cursor:pointer;

    transition:0.3s ease;
}

.update-btn:hover{

    transform:translateY(-2px);
}

/* RESPONSIVE */

@media(max-width:850px){

    .navbar{

        flex-direction:column;

        gap:15px;
    }

    .menu{

        flex-direction:column;
    }

    .menu ul{

        flex-wrap:wrap;

        justify-content:center;
    }
}

@media(max-width:650px){

    body{

        padding:10px;
    }

    .profile-container{

        padding:25px 18px;
    }

    .profile-title h1{

        font-size:28px;
    }

    .profile-info{

        display:none;
    }

    .dropdown{

        width:220px;
    }
}

</style>

</head>

<body>

<div class="main-wrapper">

    <!-- NAVBAR -->

    <nav class="navbar">

        <div class="logo">
            Ca<span>Rs</span>
        </div>

        <div class="menu">

            <ul>

                <li>
                    <a href="cardetails.php">

                        <i class="fa-solid fa-house"></i>

                        HOME

                    </a>
                </li>

                <li>
                    <a href="aboutus2.php">

                        <i class="fa-solid fa-circle-info"></i>

                        ABOUT

                    </a>
                </li>

                <li>
                    <a href="contactus2.php">

                        <i class="fa-solid fa-envelope"></i>

                        CONTACT

                    </a>
                </li>

                <li>
                    <a href="feedback/Feedbacks.php">

                        <i class="fa-solid fa-star"></i>

                        FEEDBACK

                    </a>
                </li>

            </ul>

            <!-- PROFILE -->

            <div class="profile">

                <div class="profile-btn"
                onclick="toggleDropdown()">

                    <img src="images/profile.png"
                    class="circle">

                    <div class="profile-info">

                        <span class="profile-name">
                            <?php echo htmlspecialchars($user['FNAME']); ?>
                        </span>

                        <small>Welcome Back</small>

                    </div>

                    <i class="fa-solid fa-chevron-down"></i>

                </div>

                <!-- DROPDOWN -->

                <div class="dropdown"
                id="dropdownMenu">

                    <div class="dropdown-header">

                        <img src="images/profile.png"
                        class="dropdown-img">

                        <div>

                            <h4>
                                <?php echo htmlspecialchars($user['FNAME']." ".$user['LNAME']); ?>
                            </h4>

                            <p>
                                <?php echo htmlspecialchars($user['EMAIL']); ?>
                            </p>

                        </div>

                    </div>

                    <div class="dropdown-links">

                        <a href="#">

                            <i class="fa-regular fa-user"></i>

                            Account Settings

                        </a>

                        <a href="bookinstatus.php">

                            <i class="fa-solid fa-clipboard-list"></i>

                            Booking Status

                        </a>

                        <a href="#"
                        onclick="confirmLogout()">

                            <i class="fa-solid fa-right-from-bracket"></i>

                            Logout

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </nav>

    <!-- PROFILE SETTINGS -->

    <div class="profile-container">

        <div class="profile-title">

            <h1>Account Settings</h1>

            <p>
                Update your profile information
            </p>

        </div>

        <?php if(!empty($message)){ ?>

            <div class="message">

                <?php echo $message; ?>

            </div>

        <?php } ?>

        <form method="POST">

            <!-- FIRST NAME -->

            <div class="input-group">

                <label>First Name</label>

                <div class="input-box">

                    <i class="fa-solid fa-user"></i>

                    <input type="text"
                    name="fname"
                    value="<?php echo htmlspecialchars($user['FNAME']); ?>"
                    required>

                </div>

            </div>

            <!-- LAST NAME -->

            <div class="input-group">

                <label>Last Name</label>

                <div class="input-box">

                    <i class="fa-solid fa-user"></i>

                    <input type="text"
                    name="lname"
                    value="<?php echo htmlspecialchars($user['LNAME']); ?>"
                    required>

                </div>

            </div>

            <!-- EMAIL -->

            <div class="input-group">

                <label>Email</label>

                <div class="input-box">

                    <i class="fa-solid fa-envelope"></i>

                    <input type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($user['EMAIL']); ?>"
                    required>

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="input-group">

                <label>New Password</label>

                <div class="input-box">

                    <i class="fa-solid fa-lock"></i>

                    <input type="password"
                    name="password"
                    id="password"
                    placeholder="Enter new password">

                    <i class="fa-solid fa-eye toggle-password"
                    id="togglePassword"></i>

                </div>

            </div>

            <!-- BUTTON -->

            <button type="submit"
            name="update"
            class="update-btn">

                <i class="fa-solid fa-pen"></i>

                Update Profile

            </button>

        </form>

    </div>

</div>

<!-- SCRIPT -->

<script>

/* TOGGLE DROPDOWN */

function toggleDropdown(){

    document
    .getElementById("dropdownMenu")
    .classList.toggle("show");
}

/* CLOSE DROPDOWN */

window.onclick = function(e){

    if(!e.target.closest('.profile')){

        let dropdown =
        document.getElementById("dropdownMenu");

        if(dropdown.classList.contains('show')){

            dropdown.classList.remove('show');
        }
    }
}

/* TOGGLE PASSWORD */

const togglePassword =
document.getElementById("togglePassword");

const password =
document.getElementById("password");

togglePassword.addEventListener("click", function(){

    const type =
    password.getAttribute("type") === "password"
    ? "text"
    : "password";

    password.setAttribute("type", type);

    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
});

/* LOGOUT */

function confirmLogout(){

    let confirmAction =
    confirm("Are you sure you want to logout?");

    if(confirmAction){

        window.location.href =
        "index.php";
    }
}

</script>

</body>
</html>