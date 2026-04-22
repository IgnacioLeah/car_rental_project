<?php 
session_start();
require_once('connection.php');

/* 🔐 PROTECT PAGE */
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
$email = mysqli_fetch_assoc($cname);

/* GET USER INFO */
$value = $_SESSION['email'];
$sql = "SELECT * FROM users WHERE EMAIL='$value'";
$name = mysqli_query($con,$sql);
$rows = mysqli_fetch_assoc($name);

$uemail = $rows['EMAIL'];
$carprice = $email['PRICE'];

/* BOOKING PROCESS */
if(isset($_POST['book'])){
    $bplace = $_POST['place'];
    $bdate = date('Y-m-d',strtotime($_POST['date']));
    $dur = $_POST['dur'];
    $phno = $_POST['ph'];
    $des = $_POST['des'];
    $rdate = date('Y-m-d',strtotime($_POST['rdate']));

    if($bdate < $rdate){

        $price = ($dur * $carprice);

        $sql = "INSERT INTO booking 
        (CAR_ID,EMAIL,BOOK_PLACE,BOOK_DATE,DURATION,PHONE_NUMBER,DESTINATION,PRICE,RETURN_DATE) 
        VALUES ('$carid','$uemail','$bplace','$bdate','$dur','$phno','$des','$price','$rdate')";

        mysqli_query($con,$sql);

        header("Location: payment.php");
        exit();

    } else {
        echo "<script>alert('Invalid return date');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Booking</title>

<style>
/* ✅ YOUR ORIGINAL DESIGN */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    background:url("images/book.jpg") no-repeat center center fixed;
    background-size:cover;
    position:relative;
}

body::before{
    content:'';
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.75);
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
    gap:25px;
    list-style:none;
}

.menu a{
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

.menu a:hover{
    color:#ff7200;
}

.circle{
    width:40px;
    border-radius:50%;
}

.container{
    width:900px;
    margin:40px auto;
    background:rgba(0,0,0,0.65);
    backdrop-filter:blur(12px);
    border-radius:15px;
    padding:30px;
    color:#fff;
}

.car-preview{
    text-align:center;
    margin-bottom:20px;
}

.car-preview img{
    width:240px;
    height:150px;
    object-fit:cover;
    border-radius:10px;
}

.container h1{
    text-align:center;
    margin-bottom:25px;
    color:#ff7200;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.full{
    grid-column:span 2;
}

label{
    margin-bottom:5px;
    font-size:14px;
    color:#ccc;
}

input{
    padding:10px;
    border:none;
    border-radius:8px;
    background:rgba(255,255,255,0.1);
    color:#fff;
}

.btn{
    width:100%;
    padding:12px;
    background:#ff7200;
    border:none;
    border-radius:8px;
    color:#fff;
    font-size:16px;
    cursor:pointer;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">CaRs</div>

    <div class="menu">
        <ul>
            <li><a href="cardetails.php">Home</a></li>
            <li><a href="bookinstatus.php">Status</a></li>
        </ul>
    </div>

    <img src="images/profile.png" class="circle">
</div>

<!-- FORM -->
<div class="container">

<div class="car-preview">
<?php 
$image = !empty($email['CAR_IMG']) ? $email['CAR_IMG'] : 'default.png';
?>
<img src="images/<?php echo $image; ?>" onerror="this.src='images/default.png'">
</div>

<h1>Book <?php echo $email['CAR_NAME']; ?></h1>

<form method="POST">

<div class="form-grid">

<div class="form-group">
<label>Booking Place</label>
<input type="text" name="place" required>
</div>

<div class="form-group">
<label>Booking Date</label>
<input type="date" name="date" id="datefield" required>
</div>

<div class="form-group">
<label>Duration</label>
<input type="number" name="dur" min="1" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="ph" maxlength="11" required>
</div>

<div class="form-group">
<label>Destination</label>
<input type="text" name="des" required>
</div>

<div class="form-group">
<label>Return Date</label>
<input type="date" name="rdate" id="rfield" required>
</div>

<div class="full">
<button type="submit" name="book" class="btn">Book Now</button>
</div>

</div>

</form>
</div>

<script>
let today = new Date().toISOString().split('T')[0];
document.getElementById("datefield").setAttribute("min", today);
document.getElementById("rfield").setAttribute("min", today);
</script>

</body>
</html>