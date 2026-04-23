<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT PAGE */
if(!isset($_SESSION['email'])){
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

/* GET LATEST BOOKING */
$sql = "SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC LIMIT 1";
$result = mysqli_query($con,$sql);

if(!$result){
    die("Query Error: " . mysqli_error($con));
}

$rows = mysqli_fetch_assoc($result);

/* NO BOOKING */
if(!$rows){
    echo "<script>alert('NO BOOKING FOUND'); window.location='cardetails.php';</script>";
    exit();
}

/* GET USER */
$sql2 = "SELECT * FROM users WHERE EMAIL='$email'";
$res2 = mysqli_query($con,$sql2);
$rows2 = mysqli_fetch_assoc($res2);

/* GET CAR */
$car_id = $rows['CAR_ID'];
$sql3 = "SELECT * FROM cars WHERE CAR_ID='$car_id'";
$res3 = mysqli_query($con,$sql3);
$rows3 = mysqli_fetch_assoc($res3);

/* STATUS */
$status = isset($rows['BOOK_STATUS']) ? $rows['BOOK_STATUS'] : "PENDING";

$statusClass = "pending";
if($status == "APPROVED") $statusClass="approved";
if($status == "REJECTED") $statusClass="rejected";

/* ✅ TOTAL PAYMENT */
$total = $rows['PRICE'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Status</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    background:url("images/carbg2.jpg") no-repeat center/cover;
    position:relative;
    padding:40px 0;
}

body::before{
    content:'';
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.65);
    z-index:-1;
}

.container{
    width:600px;
    max-width:90%;
    margin:auto;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(12px);
    border-radius:15px;
    padding:30px;
    text-align:center;
    color:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.6);
}

.header{
    margin-bottom:20px;
}

.header h2{
    color:#ff7200;
}

.car-img{
    width:220px;
    height:130px;
    object-fit:cover;
    border-radius:10px;
    margin:15px auto;
    display:block;
}

.info{
    text-align:left;
    margin-top:15px;
}

.info p{
    margin:10px 0;
}

/* 🔥 TOTAL PAYMENT STYLE */
.total{
    margin-top:15px;
    font-size:18px;
    font-weight:bold;
    color:#ff7200;
    text-align:center;
}

/* STATUS */
.status{
    display:inline-block;
    padding:5px 12px;
    border-radius:20px;
    margin-left:10px;
}

.approved{background:#4CAF50;}
.pending{background:#ff9800;}
.rejected{background:red;}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#ff7200;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
}

.btn:hover{
    background:#e65c00;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
    <h2>Booking Status</h2>
    <p>Hello, 
        <strong><?php echo htmlspecialchars($rows2['FNAME']." ".$rows2['LNAME']); ?></strong>
    </p>
</div>

<?php 
$image = !empty($rows3['CAR_IMG']) ? $rows3['CAR_IMG'] : 'default.png';
?>

<img src="images/<?php echo htmlspecialchars($image); ?>" 
     class="car-img"
     onerror="this.src='images/default.png'">

<div class="info">
    <p><strong>Car:</strong> <?php echo htmlspecialchars($rows3['CAR_NAME']); ?></p>
    <p><strong>Duration:</strong> <?php echo $rows['DURATION']; ?> days</p>

    <p>
        <strong>Status:</strong> 
        <span class="status <?php echo $statusClass; ?>">
            <?php echo $status; ?>
        </span>
    </p>
</div>

<div class="total">
    Total Payment: ₱<?php echo number_format($total, 2); ?>
</div>

<a href="cardetails.php" class="btn">Back to Home</a>

</div>

</body>
</html>