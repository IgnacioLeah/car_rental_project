<?php 
session_start();
require_once('connection.php');

/* PROTECT PAGE */

if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

/* GET CAR ID */

if(!isset($_GET['id'])){
    header("Location: cardetails.php");
    exit();
}

$carid = $_GET['id'];

/* GET CAR INFO */

$sql = "SELECT * FROM cars WHERE CAR_ID='$carid'";
$cname = mysqli_query($con,$sql);
$car = mysqli_fetch_assoc($cname);

/* GET USER INFO */

$value = $_SESSION['email'];

$sql = "SELECT * FROM users WHERE EMAIL='$value'";
$name = mysqli_query($con,$sql);
$user = mysqli_fetch_assoc($name);

$uemail = $user['EMAIL'];
$carprice = $car['PRICE'];
$userPhone = $user['PHONE_NUMBER'];

/* BOOKING PROCESS */

if(isset($_POST['book'])){

    $bplace = mysqli_real_escape_string($con,$_POST['place']);
    $bdate = $_POST['date'];
    $rdate = $_POST['rdate'];
    $phno = $_POST['ph'];
    $des = mysqli_real_escape_string($con,$_POST['des']);

    /* AUTO COMPUTE DURATION */

    $duration = (strtotime($rdate) - strtotime($bdate)) / (60*60*24);

    if($duration > 0){

        $price = ($duration * $carprice);

        $sql = "INSERT INTO booking 
        (CAR_ID,EMAIL,BOOK_PLACE,BOOK_DATE,DURATION,PHONE_NUMBER,DESTINATION,PRICE,RETURN_DATE) 
        VALUES 
        ('$carid','$uemail','$bplace','$bdate','$duration','$phno','$des','$price','$rdate')";

        mysqli_query($con,$sql);

        header("Location: payment.php");
        exit();

    }else{

        echo "<script>alert('Invalid return date');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>CaRs | Book Vehicle</title>

<!-- GOOGLE FONT -->

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<!-- FONT AWESOME -->

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

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
    linear-gradient(
    rgba(0,0,0,0.82),
    rgba(0,0,0,0.82)),
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
    max-width:1300px;

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

.menu ul{

    display:flex;

    gap:15px;

    list-style:none;
}

.menu ul li a{

    text-decoration:none;

    color:#dddddd;

    padding:12px 18px;

    border-radius:14px;

    font-size:14px;

    font-weight:500;

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

/* MAIN */

.booking-container{

    display:grid;

    grid-template-columns:
    420px 1fr;

    gap:30px;
}

/* CARD */

.car-card,
.booking-card{

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(12px);

    border-radius:28px;

    border:1px solid rgba(255,255,255,0.06);

    overflow:hidden;

    box-shadow:
    0 20px 45px rgba(0,0,0,0.35);
}

/* CAR IMAGE */

.car-image{

    width:100%;

    height:260px;

    overflow:hidden;

    background:#111;
}

.car-image img{

    width:100%;
    height:100%;

    object-fit:cover;
}

/* CAR CONTENT */

.car-content{

    padding:28px;
}

.car-content h1{

    color:white;

    font-size:34px;

    margin-bottom:18px;
}

.car-details{

    display:flex;

    flex-direction:column;

    gap:15px;

    margin-bottom:25px;
}

/* INFO BOX */

.info-box{

    background:rgba(255,255,255,0.06);

    padding:15px 18px;

    border-radius:16px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.info-box span{

    color:#bbbbbb;

    font-size:14px;
}

.info-box strong{

    color:white;

    font-size:14px;
}

/* PRICE */

.price-box{

    width:100%;

    padding:18px;

    border-radius:18px;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    text-align:center;

    color:white;
}

.price-box h2{

    font-size:36px;

    margin-bottom:4px;
}

.price-box p{

    font-size:13px;
}

/* BOOKING FORM */

.booking-card{

    padding:35px;
}

/* HEADER */

.form-header{

    margin-bottom:30px;
}

.form-header h2{

    color:white;

    font-size:38px;

    margin-bottom:8px;
}

.form-header p{

    color:#cccccc;

    font-size:14px;
}

/* GRID */

.form-grid{

    display:grid;

    grid-template-columns:
    repeat(2,1fr);

    gap:22px;
}

/* INPUT GROUP */

.input-group{

    display:flex;

    flex-direction:column;
}

/* FULL WIDTH */

.full-width{

    grid-column:span 2;
}

/* LABEL */

.input-group label{

    color:white;

    margin-bottom:10px;

    font-size:14px;

    font-weight:500;

    display:flex;
    align-items:center;

    gap:10px;
}

/* INPUT */

.input-group input{

    width:100%;

    height:58px;

    padding:0 18px;

    border:none;

    outline:none;

    border-radius:16px;

    background:rgba(255,255,255,0.08);

    color:white;

    font-size:14px;

    border:1px solid transparent;

    transition:0.3s ease;
}

.input-group input:focus{

    border-color:#ff7200;
}

/* READONLY */

input[readonly]{

    background:rgba(255,114,0,0.12);

    color:#ffb067;

    font-weight:600;
}

/* PLACEHOLDER */

input::placeholder{

    color:#999;
}

/* BUTTON */

.book-btn{

    width:100%;

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

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    margin-top:10px;

    transition:0.3s ease;

    display:flex;
    justify-content:center;
    align-items:center;

    gap:12px;

    box-shadow:
    0 12px 30px rgba(255,114,0,0.25);
}

.book-btn:hover{

    transform:translateY(-3px);
}

/* TOTAL */

.total-box{

    margin-top:25px;

    background:rgba(255,255,255,0.06);

    border-radius:20px;

    padding:22px;
}

.total-row{

    display:flex;
    justify-content:space-between;

    margin-bottom:14px;

    color:#dddddd;

    font-size:14px;
}

.total-price{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-top:18px;

    padding-top:18px;

    border-top:1px solid rgba(255,255,255,0.08);
}

.total-price h3{

    color:white;

    font-size:18px;
}

.total-price span{

    color:#ff7200;

    font-size:30px;

    font-weight:700;
}

/* RESPONSIVE */

@media(max-width:980px){

    .booking-container{

        grid-template-columns:1fr;
    }

    .form-grid{

        grid-template-columns:1fr;
    }

    .full-width{

        grid-column:span 1;
    }
}

@media(max-width:700px){

    body{

        padding:12px;
    }

    .navbar{

        flex-direction:column;

        gap:18px;

        padding:20px;
    }

    .menu ul{

        flex-wrap:wrap;

        justify-content:center;
    }

    .booking-card{

        padding:22px;
    }

    .form-header h2{

        font-size:30px;
    }

    .car-content h1{

        font-size:28px;
    }
}

</style>

</head>

<body>

<div class="wrapper">

    <!-- NAVBAR -->

    <div class="navbar">

        <div class="logo">

            Ca<span>Rs</span>

        </div>

        <div class="menu">

            <ul>

                <li>

                    <a href="cardetails.php">

                        <i class="fa-solid fa-house"></i>

                        Home

                    </a>

                </li>

                <li>

                    <a href="bookinstatus.php">

                        <i class="fa-solid fa-clipboard-list"></i>

                        Booking Status

                    </a>

                </li>

            </ul>

        </div>

    </div>

    <!-- MAIN -->

    <div class="booking-container">

        <!-- LEFT CARD -->

        <div class="car-card">

            <div class="car-image">

                <?php 
                $image = !empty($car['CAR_IMG']) 
                ? $car['CAR_IMG'] 
                : 'default.png';
                ?>

                <img src="images/<?php echo $image; ?>"
                onerror="this.src='images/default.png'">

            </div>

            <div class="car-content">

                <h1>

                    <?php echo $car['CAR_NAME']; ?>

                </h1>

                <div class="car-details">

                    <div class="info-box">

                        <span>
                            Fuel Type
                        </span>

                        <strong>

                            <?php echo $car['FUEL_TYPE']; ?>

                        </strong>

                    </div>

                    <div class="info-box">

                        <span>
                            Capacity
                        </span>

                        <strong>

                            <?php echo $car['CAPACITY']; ?> Seats

                        </strong>

                    </div>

                    <div class="info-box">

                        <span>
                            Availability
                        </span>

                        <strong style="color:#4ade80;">

                            Available

                        </strong>

                    </div>

                </div>

                <div class="price-box">

                    <h2>

                        ₱<?php echo number_format((float)$car['PRICE'],2); ?>

                    </h2>

                    <p>
                        Per Day Rental
                    </p>

                </div>

            </div>

        </div>

        <!-- RIGHT CARD -->

        <div class="booking-card">

            <div class="form-header">

                <h2>

                    Book Your Ride

                </h2>

                <p>

                    Fill in your booking details below.

                </p>

            </div>

            <form method="POST">

                <div class="form-grid">

                    <!-- PLACE -->

                    <div class="input-group">

                        <label>

                            <i class="fa-solid fa-location-dot"></i>

                            Booking Place

                        </label>

                        <input type="text"
                        name="place"
                        placeholder="Enter booking location"
                        required>

                    </div>

                    <!-- PHONE -->

                    <div class="input-group">

                        <label>

                            <i class="fa-solid fa-phone"></i>

                            Phone Number

                        </label>

                        <input 
                        type="text" 
                        name="ph"
                        value="<?php echo $userPhone; ?>"
                        maxlength="11"
                        pattern="09[0-9]{9}"
                        inputmode="numeric"
                        required
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">

                    </div>

                    <!-- BOOK DATE -->

                    <div class="input-group">

                        <label>

                            <i class="fa-solid fa-calendar-days"></i>

                            Booking Date

                        </label>

                        <input type="date"
                        name="date"
                        id="datefield"
                        required>

                    </div>

                    <!-- RETURN DATE -->

                    <div class="input-group">

                        <label>

                            <i class="fa-solid fa-calendar-check"></i>

                            Return Date

                        </label>

                        <input type="date"
                        name="rdate"
                        id="rfield"
                        required>

                    </div>

                    <!-- DESTINATION -->

                    <div class="input-group full-width">

                        <label>

                            <i class="fa-solid fa-map-location-dot"></i>

                            Destination

                        </label>

                        <input type="text"
                        name="des"
                        placeholder="Enter your destination"
                        required>

                    </div>

                    <!-- DURATION -->

                    <div class="input-group">

                        <label>

                            <i class="fa-solid fa-clock"></i>

                            Duration

                        </label>

                        <input type="text"
                        id="duration"
                        readonly
                        placeholder="0 Days">

                    </div>

                    <!-- TOTAL -->

                    <div class="input-group">

                        <label>

                            <i class="fa-solid fa-money-bill-wave"></i>

                            Estimated Price

                        </label>

                        <input type="text"
                        id="estimatedPrice"
                        readonly
                        placeholder="₱0.00">

                    </div>

                    <!-- TOTAL BOX -->

                    <div class="full-width">

                        <div class="total-box">

                            <div class="total-row">

                                <span>
                                    Daily Rate
                                </span>

                                <span>

                                    ₱<?php echo number_format((float)$car['PRICE'],2); ?>

                                </span>

                            </div>

                            <div class="total-row">

                                <span>
                                    Rental Days
                                </span>

                                <span id="daysText">

                                    0 Day(s)

                                </span>

                            </div>

                            <div class="total-price">

                                <h3>

                                    Total Amount

                                </h3>

                                <span id="totalPrice">

                                    ₱0.00

                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- BUTTON -->

                    <div class="full-width">

                        <button type="submit"
                        name="book"
                        class="book-btn">

                            <i class="fa-solid fa-car-side"></i>

                            Confirm Booking

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

/* MIN DATE */

let today =
new Date().toISOString().split('T')[0];

document.getElementById(
"datefield"
).setAttribute("min", today);

document.getElementById(
"rfield"
).setAttribute("min", today);

/* PRICE */

const carPrice =
<?php echo (float)$car['PRICE']; ?>;

/* AUTO CALCULATE */

document.getElementById(
"rfield"
).addEventListener(
"change",
calculateBooking
);

document.getElementById(
"datefield"
).addEventListener(
"change",
calculateBooking
);

function calculateBooking(){

    let start =
    document.getElementById(
    "datefield"
    ).value;

    let end =
    document.getElementById(
    "rfield"
    ).value;

    if(start && end){

        let d1 = new Date(start);

        let d2 = new Date(end);

        let diff =
        (d2 - d1) /
        (1000 * 60 * 60 * 24);

        if(diff > 0){

            let total =
            diff * carPrice;

            document.getElementById(
            "duration"
            ).value =
            diff + " Day(s)";

            document.getElementById(
            "estimatedPrice"
            ).value =
            "₱" + total.toLocaleString(
            undefined,
            {
                minimumFractionDigits:2,
                maximumFractionDigits:2
            });

            document.getElementById(
            "daysText"
            ).innerText =
            diff + " Day(s)";

            document.getElementById(
            "totalPrice"
            ).innerText =
            "₱" + total.toLocaleString(
            undefined,
            {
                minimumFractionDigits:2,
                maximumFractionDigits:2
            });

        }else{

            document.getElementById(
            "duration"
            ).value = "";

            document.getElementById(
            "estimatedPrice"
            ).value = "";

            document.getElementById(
            "daysText"
            ).innerText =
            "0 Day(s)";

            document.getElementById(
            "totalPrice"
            ).innerText =
            "₱0.00";
        }
    }
}

</script>

</body>
</html>