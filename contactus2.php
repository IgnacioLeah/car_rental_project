<?php
session_start();
require_once('connection.php');

/* CHECK LOGIN */

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

/* GET USER DATA */

$sql = "SELECT * FROM users WHERE EMAIL='$email'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

/* SAFE CHECK */

if (!$user) {

    $fullname = "Unknown User";

} else {

    $fullname = $user['FNAME'] . " " . $user['LNAME'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CaRs | Contact</title>

<!-- GOOGLE FONT -->

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- FONT AWESOME -->

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
    linear-gradient(rgba(0,0,0,0.80), rgba(0,0,0,0.80)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    padding:20px;

    overflow-x:hidden;
}

/* WRAPPER */

.main-wrapper{

    max-width:1400px;

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

    margin-bottom:40px;

    position:sticky;
    top:15px;

    z-index:999;

    border:1px solid rgba(255,255,255,0.05);
}

/* LOGO */

.logo{

    color:#ff7200;

    font-size:34px;

    font-weight:700;

    letter-spacing:1px;
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

    transform:translateY(-2px);
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

    line-height:1.3;
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

/* ARROW */

.arrow{

    color:#999;

    font-size:12px;
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

    box-shadow:
    0 15px 40px rgba(0,0,0,0.55);

    opacity:0;
    visibility:hidden;

    transform:translateY(10px);

    transition:0.3s ease;
}

.dropdown.show{

    opacity:1;

    visibility:visible;

    transform:translateY(0);
}

/* HEADER */

.dropdown-header{

    display:flex;
    align-items:center;

    gap:12px;

    padding:18px;

    background:#181818;

    border-bottom:1px solid rgba(255,255,255,0.06);
}

.dropdown-img{

    width:55px;
    height:55px;

    border-radius:50%;

    object-fit:cover;

    border:2px solid #ff7200;
}

.dropdown-header h4{

    color:white;

    font-size:15px;

    margin-bottom:3px;
}

.dropdown-header p{

    color:#aaaaaa;

    font-size:11px;
}

/* LINKS */

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

/* CONTACT SECTION */

.contact-section{

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:25px;
}

/* CARD */

.contact-card{

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border-radius:24px;

    padding:40px 30px;

    text-align:center;

    border:1px solid rgba(255,255,255,0.05);

    transition:0.3s;
}

.contact-card:hover{

    transform:translateY(-5px);

    background:rgba(255,255,255,0.10);
}

/* ICON */

.contact-icon{

    width:75px;
    height:75px;

    margin:auto;

    margin-bottom:20px;

    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    background:#ff7200;

    color:white;

    font-size:28px;
}

/* TITLE */

.contact-card h2{

    color:white;

    font-size:24px;

    margin-bottom:12px;
}

/* TEXT */

.contact-card p{

    color:#cccccc;

    font-size:14px;

    line-height:1.7;
}

/* RESPONSIVE */

@media(max-width:1000px){

    .contact-section{

        grid-template-columns:1fr;
    }
}

@media(max-width:900px){

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

@media(max-width:600px){

    body{

        padding:10px;
    }

    .contact-card{

        padding:30px 20px;
    }

    .contact-card h2{

        font-size:20px;
    }

    .dropdown{

        width:220px;
    }

    .profile-info{

        display:none;
    }
}

</style>

</head>

<body>

<div class="main-wrapper">

    <!-- NAVBAR -->

    <nav class="navbar">

        <!-- LOGO -->

        <div class="logo">
            Ca<span>Rs</span>
        </div>

        <!-- MENU -->

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
                    <a href="#" class="active">
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

                <div class="profile-btn" onclick="toggleDropdown()">

                    <img src="images/profile.png" class="circle">

                    <div class="profile-info">

                        <span class="profile-name">
                            <?php echo htmlspecialchars($user['FNAME']); ?>
                        </span>

                        <small>Welcome Back</small>

                    </div>

                    <i class="fa-solid fa-chevron-down arrow"></i>

                </div>

                <!-- DROPDOWN -->

                <div class="dropdown" id="dropdownMenu">

                    <div class="dropdown-header">

                        <img src="images/profile.png"
                        class="dropdown-img">

                        <div>

                            <h4>
                                <?php echo htmlspecialchars($fullname); ?>
                            </h4>

                            <p>
                                <?php echo htmlspecialchars($email); ?>
                            </p>

                        </div>

                    </div>

                    <div class="dropdown-links">

                        <a href="profile.php">

                            <i class="fa-regular fa-user"></i>

                            Account Settings

                        </a>

                        <a href="bookinstatus.php">

                            <i class="fa-solid fa-clipboard-list"></i>

                            Booking Status

                        </a>

                        <a href="#" onclick="confirmLogout()">

                            <i class="fa-solid fa-right-from-bracket"></i>

                            Logout

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </nav>

    <!-- CONTACT CARDS -->

    <div class="contact-section">

        <!-- ADDRESS -->

        <div class="contact-card">

            <div class="contact-icon">

                <i class="fas fa-map-marker-alt"></i>

            </div>

            <h2>Address</h2>

            <p>
                Cebu City, Philippines
            </p>

        </div>

        <!-- PHONE -->

        <div class="contact-card">

            <div class="contact-icon">

                <i class="fas fa-phone-alt"></i>

            </div>

            <h2>Phone</h2>

            <p>
                +63 912 345 6789
            </p>

        </div>

        <!-- EMAIL -->

        <div class="contact-card">

            <div class="contact-icon">

                <i class="fas fa-envelope"></i>

            </div>

            <h2>Email</h2>

            <p>
                contact@cars.com
            </p>

        </div>

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

/* LOGOUT CONFIRMATION */

function confirmLogout(){

    let confirmAction =
    confirm("Are you sure you want to logout?");

    if(confirmAction){

        window.location.href = "index.php";
    }
}

</script>

</body>

</html>