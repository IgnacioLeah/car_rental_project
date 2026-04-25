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
$sql = "SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC";
$result = mysqli_query($con,$sql);

if(!$result){
    die("Query Error: " . mysqli_error($con));
}

/* NO BOOKINGS */
if(mysqli_num_rows($result) == 0){
    echo "<script>alert('NO BOOKINGS FOUND'); window.location='cardetails.php';</script>";
    exit();
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
    padding:40px 0;
}

body::before{
    content:'';
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.65);
    z-index:-1;
}

/* GRID CONTAINER */
.wrapper{
    width:90%;
    margin:auto;
}

.header{
    text-align:center;
    margin-bottom:30px;
    color:#fff;
}

.header h2{
    color:#ff7200;
}

/* CARD */
.card{
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(10px);
    border-radius:12px;
    padding:20px;
    margin-bottom:20px;
    display:flex;
    gap:20px;
    align-items:center;
    color:#fff;
}

/* IMAGE */
.car-img{
    width:180px;
    height:110px;
    object-fit:cover;
    border-radius:10px;
}

/* INFO */
.info{
    flex:1;
}

/* STATUS */
.status{
    padding:5px 12px;
    border-radius:20px;
    margin-left:10px;
    font-size:13px;
}

.approved{background:#4CAF50;}
.pending{background:#ff9800;}
.rejected{background:red;}

/* TOTAL */
.total{
    font-weight:bold;
    color:#ff7200;
    margin-top:8px;
}

/* BUTTON */
.btn{
    display:block;
    width:200px;
    margin:30px auto;
    text-align:center;
    padding:10px;
    background:#ff7200;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
}
</style>
</head>

<body>

<div class="wrapper">

<div class="header">
    <h2>My Bookings</h2>
    <p>Hello, <strong><?php echo $user['FNAME']." ".$user['LNAME']; ?></strong></p>
</div>

<?php while($rows = mysqli_fetch_assoc($result)){ 

    /* GET CAR */
    $car_id = $rows['CAR_ID'];
    $carQuery = mysqli_query($con,"SELECT * FROM cars WHERE CAR_ID='$car_id'");
    $car = mysqli_fetch_assoc($carQuery);

    /* STATUS */
    $status = $rows['BOOK_STATUS'] ?? "PENDING";
    $statusClass = "pending";
    if($status=="APPROVED") $statusClass="approved";
    if($status=="REJECTED") $statusClass="rejected";

    $image = !empty($car['CAR_IMG']) ? $car['CAR_IMG'] : 'default.png';
?>

<div class="card">

    <img src="images/<?php echo htmlspecialchars($image); ?>" 
         class="car-img"
         onerror="this.src='images/default.png'">

    <div class="info">
        <p><strong>Car:</strong> <?php echo $car['CAR_NAME']; ?></p>
        <p><strong>Duration:</strong> <?php echo $rows['DURATION']; ?> days</p>

        <p>
            <strong>Status:</strong>
            <span class="status <?php echo $statusClass; ?>">
                <?php echo $status; ?>
            </span>
        </p>

        <div class="total">
            Total: ₱<?php echo number_format($rows['PRICE'], 2); ?>
        </div>
    </div>

</div>

<?php } ?>

<a href="cardetails.php" class="btn">Back to Home</a>

</div>

</body>
</html>