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
    $bplace = $_POST['place'];
    $bdate = $_POST['date'];
    $rdate = $_POST['rdate'];
    $phno = $_POST['ph'];
    $des = $_POST['des'];

    /* AUTO COMPUTE DURATION */
    $duration = (strtotime($rdate) - strtotime($bdate)) / (60*60*24);

    if($duration > 0){

        $price = ($duration * $carprice);

        $sql = "INSERT INTO booking 
        (CAR_ID,EMAIL,BOOK_PLACE,BOOK_DATE,DURATION,PHONE_NUMBER,DESTINATION,PRICE,RETURN_DATE) 
        VALUES ('$carid','$uemail','$bplace','$bdate','$duration','$phno','$des','$price','$rdate')";

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
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}

body{
    min-height:100vh;
    background:url("images/book.jpg") no-repeat center center fixed;
    background-size:cover;
}

body::before{
    content:'';
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.75);
    z-index:-1;
}

.navbar{
    display:flex;
    justify-content:space-between;
    padding:20px 50px;
    background:rgba(0,0,0,0.7);
}

.logo{color:#ff7200;font-size:28px;}

.menu ul{display:flex;gap:25px;list-style:none;}

.menu a{color:#fff;text-decoration:none;font-weight:bold;}

.container{
    width:900px;
    margin:40px auto;
    background:rgba(0,0,0,0.65);
    border-radius:15px;
    padding:30px;
    color:#fff;
}

.car-preview{text-align:center;margin-bottom:20px;}

.car-preview img{
    width:240px;height:150px;
    object-fit:cover;border-radius:10px;
}

.container h1{
    text-align:center;
    color:#ff7200;
    margin-bottom:20px;
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
    display:flex;
    justify-content:center; /* CENTER BUTTON */
}

input{
    padding:10px;
    border:none;
    border-radius:8px;
    background:rgba(255,255,255,0.1);
    color:#fff;
}

.btn{
    padding:12px 40px; /* wider button */
    background:#ff7200;
    border:none;
    border-radius:8px;
    color:#fff;
    cursor:pointer;
    font-size:16px;
}

.btn:hover{
    background:#e65c00;
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
</div>

<!-- FORM -->
<div class="container">

<div class="car-preview">
<?php 
$image = !empty($car['CAR_IMG']) ? $car['CAR_IMG'] : 'default.png';
?>
<img src="images/<?php echo $image; ?>" onerror="this.src='images/default.png'">
</div>

<h1>Book <?php echo $car['CAR_NAME']; ?></h1>

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

<!-- AUTO DURATION -->
<div class="form-group">
<label>Duration (Auto)</label>
<input type="number" id="duration" readonly>
</div>

<!-- EDITABLE PHONE -->
<div class="form-group">
<label>Phone</label>
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

<div class="form-group">
<label>Destination</label>
<input type="text" name="des" required>
</div>

<div class="form-group">
<label>Return Date</label>
<input type="date" name="rdate" id="rfield" required>
</div>

<!-- CENTER BUTTON -->
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

/* AUTO CALCULATE DURATION */
document.getElementById("rfield").addEventListener("change", calculateDays);
document.getElementById("datefield").addEventListener("change", calculateDays);

function calculateDays(){
    let start = document.getElementById("datefield").value;
    let end = document.getElementById("rfield").value;

    if(start && end){
        let d1 = new Date(start);
        let d2 = new Date(end);

        let diff = (d2 - d1) / (1000 * 60 * 60 * 24);

        if(diff > 0){
            document.getElementById("duration").value = diff;
        } else {
            document.getElementById("duration").value = "";
        }
    }
}
</script>

</body>
</html>