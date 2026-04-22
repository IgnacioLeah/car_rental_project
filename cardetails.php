<?php 
session_start();
require_once('connection.php');

/* 🔐 PROTECT PAGE */
if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

$value = $_SESSION['email'];

/* USER DATA */
$sql="SELECT * FROM users WHERE EMAIL='$value'";
$name = mysqli_query($con,$sql);
$rows=mysqli_fetch_assoc($name);

/* AVAILABLE CARS */
$sql2="SELECT * FROM cars WHERE AVAILABLE='Y'";
$cars= mysqli_query($con,$sql2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Details</title>

<style>
/* ✅ YOUR CSS (UNCHANGED) */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    background:url("images/carbg2.jpg") no-repeat center/cover;
    min-height:100vh;
}

body::before{
    content:'';
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:-1;
}

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    background:rgba(0,0,0,0.7);
}

.logo{
    color:#ff7200;
    font-size:28px;
    font-weight:bold;
}

.menu ul{
    display:flex;
    align-items:center;
    gap:20px;
}

.menu ul li{
    list-style:none;
}

.menu ul li a{
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

.menu ul li a:hover{
    color:#ff7200;
}

.circle{
    width:40px;
    border-radius:50%;
}

.overview{
    text-align:center;
    margin:30px 0;
    color:#fff;
}

.car-container{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
    gap:25px;
    padding:20px 60px;
}

.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    border-radius:12px;
    padding:15px;
    text-align:center;
    color:#fff;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
}

.card img{
    width:100%;
    height:160px;
    object-fit:cover;
    border-radius:10px;
    margin-bottom:10px;
}

.card h2{
    color:#ff7200;
}

.book-btn{
    margin-top:10px;
    display:inline-block;
    background:#ff7200;
    color:#fff;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">CaRs</div>

    <div class="menu">
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="aboutus2.html">ABOUT</a></li>
            <li><a href="contactus2.html">CONTACT</a></li>
            <li><a href="feedback/Feedbacks.php">FEEDBACK</a></li>
            <li><a href="bookinstatus.php">STATUS</a></li>
            <li><img src="images/profile.png" class="circle"></li>
            <li style="color:white;">Hello, <?php echo $rows['FNAME']; ?></li>
            <li><a href="index.php">LOGOUT</a></li>
        </ul>
    </div>
</div>

<h1 class="overview">OUR CARS OVERVIEW</h1>

<!-- CAR GRID -->
<div class="car-container">

<?php while($result=mysqli_fetch_assoc($cars)){ ?>

<div class="card">

<?php 
$image = !empty($result['CAR_IMG']) ? $result['CAR_IMG'] : 'default.png';
?>

<img src="images/<?php echo $image; ?>" 
     onerror="this.src='images/default.png'">

<h2><?php echo $result['CAR_NAME']; ?></h2>

<p>Fuel: <?php echo $result['FUEL_TYPE']; ?></p>
<p>Capacity: <?php echo $result['CAPACITY']; ?></p>

<p><strong>₱<?php echo $result['PRICE']; ?> / day</strong></p>

<a class="book-btn" href="booking.php?id=<?php echo $result['CAR_ID']; ?>">
    Book Now
</a>

</div>

<?php } ?>

</div>

</body>
</html>