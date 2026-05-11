<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT PAGE */

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

/* GET ALL BOOKINGS */

$sql = "SELECT * FROM booking 
        WHERE EMAIL='$email' 
        ORDER BY BOOK_ID DESC";

$result = mysqli_query($con,$sql);

if(!$result){
    die("Query Error: " . mysqli_error($con));
}

/* GET USER */

$sql2 = "SELECT * FROM users WHERE EMAIL='$email'";
$res2 = mysqli_query($con,$sql2);

$user = mysqli_fetch_assoc($res2);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Booking Status | CaRs</title>

<!-- GOOGLE FONT -->

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

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
    linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.82)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow-x:hidden;

    padding:18px;
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

    margin-bottom:28px;

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

    z-index:9999;
}

.dropdown.show{

    opacity:1;
    visibility:visible;

    transform:translateY(0);
}

/* DROPDOWN HEADER */

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

    padding:13px 15px;

    border-radius:12px;

    color:white;

    text-decoration:none;

    font-size:13px;

    transition:0.3s;
}

.dropdown-links a:hover{

    background:#ff7200;
}

/* PAGE HEADER */

.page-header{

    text-align:center;

    margin-bottom:24px;
}

.page-header h1{

    color:white;

    font-size:34px;

    margin-bottom:6px;
}

.page-header p{

    color:#cccccc;

    font-size:14px;
}

.page-header span{

    color:#ff7200;

    font-weight:600;
}

/* BOOKING WRAPPER */

.booking-wrapper{

    display:flex;
    flex-direction:column;

    gap:14px;
}

/* BOOKING CARD */

.booking-card{

    display:flex;
    align-items:center;

    gap:14px;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(10px);

    border-radius:16px;

    overflow:hidden;

    padding:12px;

    border:1px solid rgba(255,255,255,0.05);

    transition:0.3s;
}

.booking-card:hover{

    transform:translateY(-2px);

    box-shadow:
    0 8px 18px rgba(0,0,0,0.25);
}

/* CAR IMAGE */

.car-image{

    width:170px;

    min-width:170px;

    height:110px;

    border-radius:14px;

    overflow:hidden;
}

.car-image img{

    width:100%;
    height:100%;

    object-fit:cover;
}

/* CONTENT */

.booking-content{

    flex:1;

    padding:2px 4px;
}

/* TOP */

.top-row{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:10px;
}

.top-row h2{

    color:#ff7200;

    font-size:20px;

    font-weight:700;
}

/* STATUS */

.status{

    padding:5px 12px;

    border-radius:20px;

    font-size:10px;

    font-weight:700;
}

.pending{

    background:#ff9800;

    color:white;
}

.approved{

    background:#22c55e;

    color:white;
}

.rejected{

    background:#ef4444;

    color:white;
}

/* INFO */

.booking-info{

    display:flex;
    flex-wrap:wrap;

    gap:8px;

    margin-bottom:10px;
}

.info-item{

    display:flex;
    align-items:center;

    gap:6px;

    color:#e5e5e5;

    background:rgba(255,255,255,0.05);

    padding:7px 10px;

    border-radius:10px;

    font-size:10px;
}

.info-item i{

    color:#ff7200;
}

/* PRICE */

.price{

    color:#ff7200;

    font-size:20px;

    font-weight:700;

    margin-bottom:8px;
}

/* REJECT BOX */

.reject-box{

    margin-top:10px;

    padding:10px 12px;

    border-radius:10px;

    background:rgba(239,68,68,0.12);

    border-left:3px solid #ef4444;

    color:#fecaca;

    font-size:11px;
}

.reject-box strong{

    display:block;

    color:#ff4d4d;

    margin-bottom:4px;
}

/* EMPTY */

.empty-box{

    text-align:center;

    padding:60px 25px;

    background:rgba(255,255,255,0.08);

    border-radius:18px;

    backdrop-filter:blur(10px);
}

.empty-box i{

    font-size:60px;

    color:#ff7200;

    margin-bottom:18px;
}

.empty-box h2{

    color:white;

    margin-bottom:10px;
}

.empty-box p{

    color:#bbbbbb;

    margin-bottom:22px;
}

/* BROWSE BUTTON */

.browse-btn{

    display:inline-block;

    padding:12px 24px;

    border-radius:12px;

    text-decoration:none;

    background:#ff7200;

    color:white;

    font-size:13px;

    font-weight:600;

    transition:0.3s;
}

.browse-btn:hover{

    background:#ff8c1a;
}

/* RESPONSIVE */

@media(max-width:950px){

    .booking-card{

        flex-direction:column;

        align-items:flex-start;
    }

    .car-image{

        width:100%;

        min-width:100%;

        height:180px;
    }
}

@media(max-width:850px){

    .navbar{

        flex-direction:column;

        gap:14px;
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

    .page-header h1{

        font-size:28px;
    }

    .top-row{

        flex-direction:column;

        align-items:flex-start;

        gap:8px;
    }

    .profile-info{

        display:none;
    }

    .dropdown{

        width:220px;
    }

    .car-image{

        height:160px;
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

                    <i class="fa-solid fa-chevron-down arrow"></i>

                </div>

                <!-- DROPDOWN -->

                <div class="dropdown"
                id="dropdownMenu">

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

                        <a href="#" class="active">

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

    <!-- PAGE HEADER -->

    <div class="page-header">

        <h1>My Bookings</h1>

        <p>
            Hello,
            <span>
                <?php echo htmlspecialchars($user['FNAME']." ".$user['LNAME']); ?>
            </span>
        </p>

    </div>

    <?php if(mysqli_num_rows($result) > 0){ ?>

    <div class="booking-wrapper">

        <?php while($rows = mysqli_fetch_assoc($result)){ 

            /* GET CAR */

            $car_id = $rows['CAR_ID'];

            $carQuery = mysqli_query(
            $con,
            "SELECT * FROM cars WHERE CAR_ID='$car_id'"
            );

            $car = mysqli_fetch_assoc($carQuery);

            /* STATUS */

            $status = $rows['BOOK_STATUS'] ?? "PENDING";

            $statusClass = "pending";

            if($status=="APPROVED"){
                $statusClass="approved";
            }

            if($status=="REJECTED"){
                $statusClass="rejected";
            }

            /* IMAGE */

            $image = !empty($car['CAR_IMG'])
            ? $car['CAR_IMG']
            : 'default.png';

            /* REJECT MESSAGE */

            $rejectReason =
            $rows['REASON_OF_REJECT'] ?? '';
        ?>

        <div class="booking-card">

            <!-- IMAGE -->

            <div class="car-image">

                <img 
                src="images/<?php echo htmlspecialchars($image); ?>"
                onerror="this.src='images/default.png'">

            </div>

            <!-- CONTENT -->

            <div class="booking-content">

                <div class="top-row">

                    <h2>
                        <?php echo htmlspecialchars($car['CAR_NAME']); ?>
                    </h2>

                    <span class="status <?php echo $statusClass; ?>">

                        <?php echo htmlspecialchars($status); ?>

                    </span>

                </div>

                <!-- INFO -->

                <div class="booking-info">

                    <div class="info-item">

                        <i class="fa-solid fa-calendar-days"></i>

                        <?php echo $rows['DURATION']; ?> Days

                    </div>

                    <div class="info-item">

                        <i class="fa-solid fa-car"></i>

                        Car Rental

                    </div>

                </div>

                <!-- PRICE -->

                <div class="price">

                    ₱<?php echo number_format($rows['PRICE'],2); ?>

                </div>

                <!-- REJECT MESSAGE -->

                <?php if($status=="REJECTED" && !empty($rejectReason)){ ?>

                <div class="reject-box">

                    <strong>
                        Rejection Message
                    </strong>

                    <?php echo htmlspecialchars($rejectReason); ?>

                </div>

                <?php } ?>

            </div>

        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

    <!-- EMPTY -->

    <div class="empty-box">

        <i class="fa-solid fa-car-side"></i>

        <h2>No Bookings Found</h2>

        <p>
            You don't have any bookings yet.
        </p>

        <a href="cardetails.php"
        class="browse-btn">

            Browse Cars

        </a>

    </div>

    <?php } ?>

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