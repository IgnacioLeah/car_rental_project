<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT ADMIN PAGE */

if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

/* FEEDBACK DATA */

$feedbackQuery = "
SELECT * FROM feedback
ORDER BY FED_ID DESC
";

$feedbackData = mysqli_query($con, $feedbackQuery);

/* TOP CARS */

$topCarsQuery = "
SELECT cars.CAR_NAME,
cars.CAR_IMG,
COUNT(booking.CAR_ID) as total

FROM booking

JOIN cars
ON booking.CAR_ID = cars.CAR_ID

GROUP BY booking.CAR_ID

ORDER BY total DESC

LIMIT 3
";

$topCars = mysqli_query($con, $topCarsQuery);

/* TOTAL FEEDBACK */

$totalFeedback =
mysqli_num_rows($feedbackData);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible"
content="IE=edge">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>CaRs | Admin Feedbacks</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{

    min-height:100vh;

    background:
    linear-gradient(rgba(0,0,0,0.82), rgba(0,0,0,0.82)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    padding:25px;

    overflow-x:hidden;
}

.wrapper{

    width:100%;
    max-width:1450px;
    margin:auto;
}

/* NAVBAR */

.navbar{

    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:16px 35px;

    background:rgba(10,10,10,0.82);

    backdrop-filter:blur(12px);

    border-radius:22px;

    border:1px solid rgba(255,255,255,0.05);

    margin-bottom:35px;

    position:relative;

    z-index:9999;
}

.logo{

    color:#ff7200;

    font-size:34px;

    font-weight:700;
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
}

.menu ul li a:hover,
.menu ul li a.active{

    background:#161616;

    color:#ff7200;
}

/* PROFILE */

.profile{
    position:relative;
}

/* BUTTON */

.profile-btn{

    display:flex;
    align-items:center;
    gap:10px;

    padding:12px 20px;

    border-radius:16px;

    cursor:pointer;

    color:white;

    font-size:14px;
    font-weight:600;

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

.profile-btn:hover{

    transform:translateY(-2px);
}

/* DROPDOWN */

.dropdown{

    position:absolute;

    top:70px;
    right:0;

    width:230px;

    background:
    linear-gradient(
    180deg,
    rgba(22,22,22,0.96),
    rgba(12,12,12,0.96)
    );

    backdrop-filter:blur(14px);

    border-radius:22px;

    border:1px solid rgba(255,255,255,0.06);

    overflow:hidden;

    display:none;

    z-index:99999;

    box-shadow:
    0 18px 40px rgba(0,0,0,0.45);

    animation:dropdownFade 0.25s ease;
}

/* DROPDOWN HEADER */

.dropdown-header{

    padding:18px;

    border-bottom:
    1px solid rgba(255,255,255,0.06);

    background:
    rgba(255,255,255,0.03);
}

.dropdown-header h3{

    color:white;

    font-size:16px;

    margin-bottom:4px;
}

.dropdown-header p{

    color:#aaaaaa;

    font-size:12px;
}

/* DROPDOWN LINKS */

.dropdown a{

    display:flex;
    align-items:center;

    gap:12px;

    padding:16px 18px;

    text-decoration:none;

    color:#dddddd;

    font-size:14px;

    transition:0.3s ease;
}

.dropdown a:hover{

    background:
    rgba(255,114,0,0.12);

    color:#ff7200;
}

/* ICON */

.dropdown a i{

    width:18px;

    text-align:center;
}

/* ANIMATION */

@keyframes dropdownFade{

    from{
        opacity:0;
        transform:translateY(-10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* HEADER */

.header{

    display:flex;
    justify-content:space-between;
    align-items:center;

    gap:20px;

    margin-bottom:30px;

    flex-wrap:wrap;
}

.title h1{

    color:white;

    font-size:48px;

    margin-bottom:10px;
}

.title h1 span{

    color:#ff7200;
}

.title p{

    color:#cccccc;

    font-size:15px;
}

/* STATS */

.stats{

    display:flex;
    gap:20px;
}

.stat-card{

    min-width:200px;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(10px);

    border-radius:22px;

    padding:24px;

    border:1px solid rgba(255,255,255,0.05);

    color:white;
}

.stat-card h2{

    font-size:34px;

    margin-bottom:8px;
}

.stat-card p{

    color:#cccccc;

    font-size:14px;
}

/* SECTION TITLE */

.section-title{

    color:white;

    font-size:26px;

    margin-bottom:20px;
}

/* TOP CARS */

.dashboard{

    display:grid;

    grid-template-columns:
    repeat(auto-fit, minmax(280px,1fr));

    gap:25px;

    margin-bottom:40px;
}

.card{

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(12px);

    border-radius:26px;

    overflow:hidden;

    border:1px solid rgba(255,255,255,0.05);

    transition:0.3s ease;
}

.card:hover{

    transform:translateY(-6px);
}

/* IMAGE */

.card-image{

    width:100%;
    height:220px;

    overflow:hidden;

    background:#111;
}

.card-image img{

    width:100%;
    height:100%;

    object-fit:cover;

    display:block;
}

/* CARD CONTENT */

.card-content{

    padding:22px;

    color:white;
}

.card-content h3{

    font-size:24px;

    margin-bottom:10px;
}

.card-content p{

    color:#cccccc;

    font-size:14px;

    margin-bottom:15px;
}

.booking-badge{

    display:inline-flex;
    align-items:center;

    gap:8px;

    background:rgba(255,114,0,0.15);

    color:#ff7200;

    padding:10px 16px;

    border-radius:50px;

    font-size:13px;

    font-weight:600;
}

/* TABLE */

.container{

    width:100%;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(12px);

    border-radius:28px;

    padding:30px;

    border:1px solid rgba(255,255,255,0.05);

    overflow:auto;
}

.table-header{

    margin-bottom:25px;
}

.table-header h2{

    color:white;

    font-size:30px;
}

table{

    width:100%;

    border-collapse:collapse;

    overflow:hidden;

    border-radius:18px;

    background:white;
}

thead{

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;
}

th{

    padding:18px;

    font-size:14px;
}

td{

    padding:18px;

    text-align:center;

    font-size:14px;

    color:#333;

    border-bottom:1px solid #f1f1f1;
}

tbody tr:hover{

    background:#fff7f1;
}

.comment{

    max-width:450px;

    margin:auto;

    line-height:1.7;

    word-break:break-word;
}

.empty{

    text-align:center;

    padding:25px;

    color:#777;
}

/* RESPONSIVE */

@media(max-width:950px){

    .navbar{

        flex-direction:column;
        gap:18px;
    }

    .menu ul{

        flex-wrap:wrap;
        justify-content:center;
    }

    .title h1{

        font-size:38px;
    }
}

@media(max-width:650px){

    body{

        padding:12px;
    }

    .title h1{

        font-size:30px;
    }

    table{

        min-width:650px;
    }
}

</style>

</head>

<body>

<div class="wrapper">

    <!-- NAVBAR -->

    <div class="navbar">

        <div class="logo">

            Ca<span>Rs</span> Admin

        </div>

        <div class="menu">

            <ul>

                <li>
                    <a href="adminvehicle.php">
                        Vehicles
                    </a>
                </li>

                <li>
                    <a href="adminusers.php">
                        Users
                    </a>
                </li>

                <li>
                    <a href="admindash.php"
                    class="active">
                        Feedbacks
                    </a>
                </li>

            </ul>

        </div>

        <!-- PROFILE -->

        <div class="profile">

            <div class="profile-btn"
            onclick="toggleMenu()">

                <i class="fa-solid fa-user-shield"></i>

                Admin

                <i class="fa-solid fa-angle-down"></i>

            </div>

            <!-- DROPDOWN -->

            <div class="dropdown"
            id="dropdownMenu">

                <div class="dropdown-header">

                    <h3>Administrator</h3>

                    <p>Car Rental System</p>

                </div>

                <a href="#"
                onclick="confirmLogout()">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>

            </div>

        </div>

    </div>

    <!-- HEADER -->

    <div class="header">

        <div class="title">

            <h1>

                Customer <span>Feedbacks</span>

            </h1>

            <p>

                Manage user feedbacks and monitor top booked vehicles.

            </p>

        </div>

        <div class="stats">

            <div class="stat-card">

                <h2>

                    <?php echo $totalFeedback; ?>

                </h2>

                <p>

                    Total Feedbacks

                </p>

            </div>

        </div>

    </div>

    <!-- TOP CARS -->

    <h2 class="section-title">

        ⭐ Top Booked Cars

    </h2>

    <div class="dashboard">

        <?php

        if(mysqli_num_rows($topCars) > 0){

            while($row =
            mysqli_fetch_assoc($topCars)){

            $imagePath = $row['CAR_IMG'];

            if(empty($imagePath)){

                $imagePath =
                "images/default.png";
            }

            if(
                !str_contains(
                $imagePath,
                'images/')
            ){

                $imagePath =
                "images/" .
                $imagePath;
            }

        ?>

        <div class="card">

            <div class="card-image">

                <img src="<?php echo $imagePath; ?>"
                loading="lazy"
                alt="Car Image"
                onerror="this.src='images/default.png'">

            </div>

            <div class="card-content">

                <h3>

                    <?php
                    echo htmlspecialchars(
                    $row['CAR_NAME']
                    );
                    ?>

                </h3>

                <p>

                    One of the most booked cars
                    in the rental system.

                </p>

                <div class="booking-badge">

                    <i class="fa-solid fa-star"></i>

                    <?php echo $row['total']; ?>

                    Bookings

                </div>

            </div>

        </div>

        <?php
            }

        }else{
        ?>

        <div class="card">

            <div class="card-content">

                <h3>No Data Found</h3>

            </div>

        </div>

        <?php } ?>

    </div>

    <!-- TABLE -->

    <div class="container">

        <div class="table-header">

            <h2>

                Feedback Management

            </h2>

        </div>

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Email</th>

                    <th>Comment</th>

                </tr>

            </thead>

            <tbody>

            <?php

            if(mysqli_num_rows($feedbackData) > 0){

                mysqli_data_seek($feedbackData, 0);

                while($res =
                mysqli_fetch_assoc($feedbackData)){

            ?>

            <tr>

                <td>

                    <?php
                    echo $res['FED_ID'];
                    ?>

                </td>

                <td>

                    <?php
                    echo htmlspecialchars(
                    $res['EMAIL']
                    );
                    ?>

                </td>

                <td class="comment">

                    <?php
                    echo htmlspecialchars(
                    $res['COMMENT']
                    );
                    ?>

                </td>

            </tr>

            <?php
                }

            }else{
            ?>

            <tr>

                <td colspan="3"
                class="empty">

                    No feedback found

                </td>

            </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

<script>

function toggleMenu(){

    let menu =
    document.getElementById(
    "dropdownMenu"
    );

    menu.style.display =
    (menu.style.display === "block")
    ? "none"
    : "block";
}

window.onclick = function(e){

    if(!e.target.closest('.profile')){

        document.getElementById(
        "dropdownMenu"
        ).style.display = "none";
    }
}

function confirmLogout(){

    if(confirm(
    "Are you sure you want to logout?"
    )){

        window.location.href =
        "index.php";
    }
}

</script>

</body>
</html>