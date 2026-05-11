<?php
session_start();
require_once('connection.php');

/* PROTECT PAGE */

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

/* FETCH USER DATA */

$userQuery = mysqli_query(
$con,
"SELECT * FROM users WHERE EMAIL='$email'"
);

$user = mysqli_fetch_assoc($userQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>CaRs | About Us</title>

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
    linear-gradient(rgba(0,0,0,0.78), rgba(0,0,0,0.78)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow-x:hidden;

    padding:20px;
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

    margin-bottom:30px;

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
}

.menu ul li{

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

/* SHOW */

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

    border:2px solid #ff7200;

    object-fit:cover;
}

.dropdown-header h4{

    color:white;

    font-size:15px;

    margin-bottom:3px;
}

.dropdown-header p{

    color:#aaaaaa;

    font-size:11px;

    word-break:break-word;
}

/* LINKS */

.dropdown-links{

    padding:10px;
}

.dropdown-links a{

    display:flex;
    align-items:center;

    gap:12px;

    padding:14px 15px;

    border-radius:12px;

    color:white;

    text-decoration:none;

    font-size:13px;

    font-weight:500;

    transition:0.3s;
}

.dropdown-links a:hover{

    background:#ff7200;
}

/* ABOUT CONTAINER */

.about-container{

    width:100%;

    display:grid;

    grid-template-columns:1fr 1fr;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,0.05);

    border-radius:24px;

    overflow:hidden;

    box-shadow:
    0 10px 30px rgba(0,0,0,0.35);
}

/* IMAGE */

.about-image{

    width:100%;
    height:100%;

    position:relative;

    overflow:hidden;
}

.about-image img{

    width:100%;
    height:100%;

    object-fit:cover;

    transition:0.4s ease;
}

.about-image:hover img{

    transform:scale(1.03);
}

/* OVERLAY */

.overlay{

    position:absolute;

    inset:0;

    background:
    linear-gradient(
    to top,
    rgba(0,0,0,0.75),
    rgba(0,0,0,0.10)
    );
}

/* BADGE */

.badge{

    position:absolute;

    top:20px;
    left:20px;

    background:rgba(255,114,0,0.15);

    border:1px solid rgba(255,114,0,0.25);

    color:#ff7200;

    padding:10px 18px;

    border-radius:50px;

    font-size:12px;

    font-weight:600;

    backdrop-filter:blur(10px);
}

/* CONTENT */

.about-content{

    padding:40px;

    color:white;

    display:flex;
    flex-direction:column;
    justify-content:center;
}

/* TAG */

.tag{

    color:#ff7200;

    font-size:13px;

    font-weight:600;

    letter-spacing:3px;

    margin-bottom:14px;
}

/* TITLE */

.about-content h1{

    font-size:45px;

    line-height:1.2;

    margin-bottom:16px;

    font-weight:700;
}

.about-content h1 span{

    color:#ff7200;
}

/* LINE */

.line{

    width:90px;
    height:4px;

    background:#ff7200;

    border-radius:10px;

    margin-bottom:22px;
}

/* DESCRIPTION */

.description{

    font-size:15px;

    line-height:1.9;

    color:#dddddd;

    margin-bottom:28px;
}

/* FEATURES */

.features{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:15px;
}

/* FEATURE CARD */

.feature-card{

    background:rgba(255,255,255,0.08);

    padding:18px 14px;

    border-radius:16px;

    text-align:center;

    transition:0.3s ease;
}

.feature-card:hover{

    transform:translateY(-4px);

    background:rgba(255,255,255,0.12);
}

.feature-card i{

    font-size:24px;

    color:#ff7200;

    margin-bottom:10px;
}

.feature-card h3{

    font-size:15px;

    margin-bottom:8px;
}

.feature-card p{

    font-size:12px;

    line-height:1.6;

    color:#cccccc;
}

/* RESPONSIVE */

@media(max-width:1000px){

    .about-container{

        grid-template-columns:1fr;
    }

    .about-image{

        height:320px;
    }

    .features{

        grid-template-columns:1fr;
    }

    .about-content{

        padding:28px;
    }

    .about-content h1{

        font-size:34px;
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

@media(max-width:700px){

    body{

        padding:12px;
    }

    .navbar{

        padding:18px;
    }

    .menu ul li a{

        font-size:12px;
    }

    .about-content{

        padding:24px 18px;
    }

    .about-content h1{

        font-size:28px;
    }

    .description{

        font-size:13px;
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

        <!-- LOGO -->

        <div class="logo">
            Ca<span>Rs</span>
        </div>

        <!-- RIGHT SIDE -->

        <div class="menu">

            <!-- MENU -->

            <ul>

                <li>
                    <a href="cardetails.php">
                        <i class="fa-solid fa-house"></i>
                        HOME
                    </a>
                </li>

                <li>
                    <a href="#" class="active">
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
                                <?php echo htmlspecialchars($user['FNAME']); ?>
                            </h4>

                            <p>
                                <?php echo htmlspecialchars($user['EMAIL']); ?>
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

    <!-- ABOUT SECTION -->

    <div class="about-container">

        <!-- IMAGE -->

        <div class="about-image">

            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1600&auto=format&fit=crop">

            <div class="overlay"></div>

            <div class="badge">
                Premium Car Rental
            </div>

        </div>

        <!-- CONTENT -->

        <div class="about-content">

            <div class="tag">
                ABOUT OUR COMPANY
            </div>

            <h1>
                Drive Your <span>Dream Car</span> With Us
            </h1>

            <div class="line"></div>

            <p class="description">

                At CaRs, we provide stylish, safe, and premium vehicles
                designed to give every customer a smooth and luxurious journey.

                <br><br>

                Our mission is to deliver modern car rental services with
                comfort, reliability, and affordable pricing.

            </p>

            <!-- FEATURES -->

            <div class="features">

                <div class="feature-card">

                    <i class="fa-solid fa-car-side"></i>

                    <h3>Premium Cars</h3>

                    <p>
                        Luxury and modern cars for every travel experience.
                    </p>

                </div>

                <div class="feature-card">

                    <i class="fa-solid fa-shield-heart"></i>

                    <h3>Safe & Secure</h3>

                    <p>
                        Well-maintained vehicles with trusted safety features.
                    </p>

                </div>

                <div class="feature-card">

                    <i class="fa-solid fa-wallet"></i>

                    <h3>Affordable Rates</h3>

                    <p>
                        Competitive rental pricing with premium quality.
                    </p>

                </div>

                <div class="feature-card">

                    <i class="fa-solid fa-headset"></i>

                    <h3>24/7 Support</h3>

                    <p>
                        Friendly support team always ready to assist you.
                    </p>

                </div>

            </div>

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