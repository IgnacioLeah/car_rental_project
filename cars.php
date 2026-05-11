<?php
require_once('connection.php');

/* GET ALL CARS WITH TOTAL BOOKINGS */
/* MOST BOOKED CARS FIRST */

$sql = "
SELECT cars.*, COUNT(booking.BOOK_ID) AS total_bookings
FROM cars
LEFT JOIN booking
ON cars.CAR_ID = booking.CAR_ID
GROUP BY cars.CAR_ID
ORDER BY total_bookings DESC, cars.CAR_ID DESC
";

$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible"
content="IE=edge">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>CaRs | Explore Cars</title>

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
    linear-gradient(rgba(0,0,0,0.84), rgba(0,0,0,0.84)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    padding:25px;

    overflow-x:hidden;
}

/* WRAPPER */

.wrapper{

    width:100%;
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

    background:rgba(10,10,10,0.80);

    backdrop-filter:blur(12px);

    border-radius:20px;

    margin-bottom:35px;

    border:1px solid rgba(255,255,255,0.05);

    position:sticky;
    top:10px;

    z-index:999;
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

    gap:15px;

    flex-wrap:wrap;
}

.menu a{

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

.menu a:hover,
.menu a.active{

    background:#161616;

    color:#ff7200;
}

/* TITLE */

.page-title{

    text-align:center;

    margin-bottom:40px;
}

.page-title h1{

    color:white;

    font-size:52px;

    margin-bottom:12px;
}

.page-title h1 span{

    color:#ff7200;
}

.page-title p{

    color:#cccccc;

    font-size:15px;
}

/* CARS GRID */

.cars-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit, minmax(320px,1fr));

    gap:28px;

    align-items:stretch;
}

/* CARD */

.car-card{

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

    box-shadow:
    0 10px 25px rgba(0,0,0,0.25);

    display:flex;

    flex-direction:column;

    height:100%;

    position:relative;
}

.car-card:hover{

    transform:translateY(-8px);

    box-shadow:
    0 18px 35px rgba(0,0,0,0.35);
}

/* TOP BADGE */

.top-badge{

    position:absolute;

    top:18px;
    left:18px;

    z-index:5;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    padding:8px 14px;

    border-radius:50px;

    font-size:12px;

    font-weight:700;

    box-shadow:
    0 8px 18px rgba(0,0,0,0.35);
}

/* IMAGE */

.car-image{

    position:relative;

    width:100%;

    height:240px;

    min-height:240px;

    max-height:240px;

    overflow:hidden;

    background:#111;

    flex-shrink:0;
}

.car-image img{

    width:100%;
    height:100%;

    object-fit:cover;

    display:block;

    transition:0.4s ease;
}

.car-card:hover .car-image img{

    transform:scale(1.05);
}

/* OVERLAY */

.overlay{

    position:absolute;

    inset:0;

    background:
    linear-gradient(
    to top,
    rgba(0,0,0,0.7),
    rgba(0,0,0,0.1)
    );
}

/* PRICE */

.price-tag{

    position:absolute;

    top:18px;
    right:18px;

    background:#ff7200;

    color:white;

    padding:10px 16px;

    border-radius:50px;

    font-size:13px;

    font-weight:600;
}

/* CONTENT */

.car-content{

    padding:24px;

    display:flex;

    flex-direction:column;

    flex:1;
}

/* CAR NAME */

.car-name{

    color:white;

    font-size:24px;

    font-weight:600;

    margin-bottom:15px;

    min-height:65px;

    display:flex;

    align-items:flex-start;
}

/* CAR DETAILS */

.car-info{

    display:flex;
    flex-wrap:wrap;

    gap:12px;

    margin-bottom:18px;
}

.info-box{

    background:rgba(255,255,255,0.08);

    padding:10px 14px;

    border-radius:12px;

    color:#dddddd;

    font-size:13px;

    display:flex;
    align-items:center;

    gap:8px;
}

/* DESCRIPTION */

.description{

    color:#bbbbbb;

    font-size:14px;

    line-height:1.8;

    margin-bottom:20px;

    min-height:80px;
}

/* RATING */

.rating{

    display:flex;

    align-items:center;

    justify-content:space-between;

    margin-bottom:22px;

    margin-top:auto;
}

/* STARS */

.stars{

    color:#ffb400;

    font-size:15px;
}

/* BOOK COUNT */

.book-count{

    color:#cccccc;

    font-size:13px;
}

/* BUTTON */

.book-btn{

    width:100%;

    height:54px;

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

    display:flex;

    justify-content:center;
    align-items:center;

    gap:10px;

    text-decoration:none;

    margin-top:auto;
}

.book-btn:hover{

    transform:translateY(-2px);

    background:
    linear-gradient(
    135deg,
    #ff8c1a,
    #ff7200
    );
}

/* EMPTY */

.empty{

    width:100%;

    text-align:center;

    padding:60px 20px;

    color:white;

    background:rgba(255,255,255,0.06);

    border-radius:24px;
}

.empty i{

    font-size:60px;

    color:#ff7200;

    margin-bottom:20px;
}

.empty h2{

    margin-bottom:10px;
}

/* RESPONSIVE */

@media(max-width:850px){

    .navbar{

        flex-direction:column;

        gap:18px;
    }

    .menu{

        justify-content:center;
    }

    .page-title h1{

        font-size:38px;
    }
}

@media(max-width:650px){

    body{

        padding:12px;
    }

    .navbar{

        padding:14px 18px;
    }

    .page-title h1{

        font-size:30px;
    }

    .car-content{

        padding:18px;
    }
}

</style>

</head>

<body>

<div class="wrapper">

    <!-- NAVBAR -->

    <nav class="navbar">

        <div class="logo">
            Ca<span>Rs</span>
        </div>

        <div class="menu">

            <a href="index.php">
                <i class="fa-solid fa-house"></i>
                Home
            </a>

            <a href="cars.php" class="active">
                <i class="fa-solid fa-car"></i>
                Explore Cars
            </a>

            <a href="services.html">
                <i class="fa-solid fa-briefcase"></i>
                Services
            </a>

            <a href="aboutus.html">
                <i class="fa-solid fa-circle-info"></i>
                About
            </a>

            <a href="contactus.html">
                <i class="fa-solid fa-envelope"></i>
                Contact
            </a>

        </div>

    </nav>

    <!-- TITLE -->

    <div class="page-title">

        <h1>
            Explore <span>Premium Cars</span>
        </h1>

        <p>
            Discover the most popular and top rented vehicles available today.
        </p>

    </div>

    <!-- CARS -->

    <div class="cars-grid">

        <?php

        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){

                $totalBookings =
                $row['total_bookings'];

                /* STAR RATING */

                if($totalBookings >= 20){

                    $stars = 5;

                }elseif($totalBookings >= 15){

                    $stars = 4;

                }elseif($totalBookings >= 10){

                    $stars = 3;

                }elseif($totalBookings >= 5){

                    $stars = 2;

                }else{

                    $stars = 1;
                }

                /* SAFE IMAGE */

                $image =
                !empty($row['CAR_IMG'])
                ? 'images/' . $row['CAR_IMG']
                : 'images/defaultcar.jpg';

                /* SAFE DESCRIPTION */

                $description =
                !empty($row['CAR_DESC'])
                ? $row['CAR_DESC']
                : 'Premium rental vehicle with excellent performance and comfort.';

                /* SAFE TRANSMISSION */

                $transmission =
                !empty($row['TRANSMISSION'])
                ? $row['TRANSMISSION']
                : 'Automatic';

                /* SAFE SEATS */

                $seats =
                !empty($row['SEATS'])
                ? $row['SEATS']
                : '4';

        ?>

        <!-- CARD -->

        <div class="car-card">

            <?php if($totalBookings > 0){ ?>

            <div class="top-badge">

                🔥 <?php echo $totalBookings; ?> Bookings

            </div>

            <?php } ?>

            <!-- IMAGE -->

            <div class="car-image">

                <img src="<?php echo htmlspecialchars($image); ?>"
                onerror="this.src='images/defaultcar.jpg'">

                <div class="overlay"></div>

                <div class="price-tag">

                    ₱<?php echo number_format((float)$row['PRICE'],2); ?>/day

                </div>

            </div>

            <!-- CONTENT -->

            <div class="car-content">

                <h2 class="car-name">

                    <?php echo htmlspecialchars($row['CAR_NAME']); ?>

                </h2>

                <!-- INFO -->

                <div class="car-info">

                    <div class="info-box">

                        <i class="fa-solid fa-gas-pump"></i>

                        <?php echo htmlspecialchars($row['FUEL_TYPE']); ?>

                    </div>

                    <div class="info-box">

                        <i class="fa-solid fa-gear"></i>

                        <?php echo htmlspecialchars($transmission); ?>

                    </div>

                    <div class="info-box">

                        <i class="fa-solid fa-users"></i>

                        <?php echo $seats; ?> Seats

                    </div>

                </div>

                <!-- DESCRIPTION -->

                <p class="description">

                    <?php echo htmlspecialchars($description); ?>

                </p>

                <!-- RATING -->

                <div class="rating">

                    <div class="stars">

                        <?php

                        for($i=1; $i<=5; $i++){

                            if($i <= $stars){

                                echo '<i class="fa-solid fa-star"></i>';

                            }else{

                                echo '<i class="fa-regular fa-star"></i>';
                            }
                        }

                        ?>

                    </div>

                    <div class="book-count">

                        <?php echo $totalBookings; ?>
                        bookings

                    </div>

                </div>

                <!-- BOOK BUTTON -->

                <a href="index.php"
                class="book-btn"
                onclick="return confirmLogin()">

                    <i class="fa-solid fa-calendar-check"></i>

                    Book Now

                </a>

            </div>

        </div>

        <?php
            }

        }else{
        ?>

        <!-- EMPTY -->

        <div class="empty">

            <i class="fa-solid fa-car"></i>

            <h2>No Cars Available</h2>

            <p>
                Cars will appear here once added by admin.
            </p>

        </div>

        <?php } ?>

    </div>

</div>

<script>

/* LOGIN ALERT */

function confirmLogin(){

    alert("Please login first before booking a car.");

    return true;
}

</script>

</body>

</html>