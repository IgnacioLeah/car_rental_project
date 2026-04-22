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

/* BACKGROUND */
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:url("images/carbg2.jpg") no-repeat center/cover;
    position:relative;
}

/* DARK OVERLAY */
body::before{
    content:'';
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.65);
    z-index:-1;
}

/* MAIN CARD */
.container{
    width:600px;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(12px);
    border-radius:15px;
    padding:30px;
    text-align:center;
    color:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.6);
}

/* HEADER */
.header{
    margin-bottom:20px;
}

.header h2{
    color:#ff7200;
}

/* CAR IMAGE */
.car-img{
    width:220px;
    height:130px;
    object-fit:cover;
    border-radius:10px;
    margin:15px auto;
    display:block;
    box-shadow:0 5px 15px rgba(0,0,0,0.5);
}

/* INFO */
.info{
    text-align:left;
    margin-top:15px;
}

.info p{
    font-size:16px;
    margin:10px 0;
}

/* STATUS BADGE */
.status{
    display:inline-block;
    padding:5px 12px;
    border-radius:20px;
    font-size:14px;
    margin-left:10px;
}

.approved{
    background:#4CAF50;
}

.pending{
    background:#ff9800;
}

.rejected{
    background:red;
}

/* BUTTON */
.btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#ff7200;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#e65c00;
}
</style>
</head>

<body>

<?php
require_once('connection.php');
session_start();

$email = $_SESSION['email'];

$sql="SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC LIMIT 1";
$name = mysqli_query($con,$sql);
$rows=mysqli_fetch_assoc($name);

if($rows==null){
    echo "<script>alert('NO BOOKING FOUND'); window.location='cardetails.php';</script>";
}else{

$sql2="SELECT * FROM users WHERE EMAIL='$email'";
$name2 = mysqli_query($con,$sql2);
$rows2=mysqli_fetch_assoc($name2);

$car_id=$rows['CAR_ID'];
$sql3="SELECT * FROM cars WHERE CAR_ID='$car_id'";
$name3 = mysqli_query($con,$sql3);
$rows3=mysqli_fetch_assoc($name3);

/* STATUS CLASS */
$statusClass = "pending";
if($rows['BOOK_STATUS']=="APPROVED") $statusClass="approved";
if($rows['BOOK_STATUS']=="REJECTED") $statusClass="rejected";
?>

<div class="container">

<div class="header">
    <h2>Booking Status</h2>
    <p>Hello, <strong><?php echo $rows2['FNAME']." ".$rows2['LNAME']; ?></strong></p>
</div>

<!-- CAR IMAGE -->
<?php 
$image = !empty($rows3['CAR_IMG']) ? $rows3['CAR_IMG'] : 'default.png';
?>
<img src="images/<?php echo $image; ?>" class="car-img"
     onerror="this.src='images/default.png'">

<div class="info">
    <p><strong>Car:</strong> <?php echo $rows3['CAR_NAME']; ?></p>
    <p><strong>Duration:</strong> <?php echo $rows['DURATION']; ?> days</p>
    <p>
        <strong>Status:</strong> 
        <span class="status <?php echo $statusClass; ?>">
            <?php echo $rows['BOOK_STATUS']; ?>
        </span>
    </p>
</div>

<a href="cardetails.php" class="btn">Back to Home</a>

</div>

<?php } ?>

</body>
</html>