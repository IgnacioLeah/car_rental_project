<?php
session_start();
require_once('connection.php');

/* CHECK LOGIN */
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

/* GET USER DATA */
$sql = "SELECT * FROM users WHERE EMAIL='$email'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($result);

/* SAFE CHECK */
if (!$user) {
    $fullname = "Unknown User";
} else {
    $fullname = $user['FNAME'] . " " . $user['LNAME'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CaRs | Contact</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial;}
body{background:linear-gradient(135deg,#1e3c72,#2a5298);}
.contact{min-height:100vh;padding:50px;display:flex;justify-content:center;align-items:center;}
.container{display:flex;gap:40px;width:100%;max-width:1100px;}
.contactInfo,.contactForm{width:50%;}
.box{display:flex;align-items:center;margin:10px 0;padding:15px;background:rgba(255,255,255,0.1);border-radius:10px;}
.icon{width:50px;height:50px;background:#00c6ff;display:flex;justify-content:center;align-items:center;border-radius:50%;color:#fff;margin-right:10px;}
.text h3{color:#00c6ff;}
.text p{color:#fff;}
.contactForm{padding:25px;background:rgba(255,255,255,0.1);border-radius:10px;}
.contactForm h2{color:#fff;margin-bottom:15px;}
.inputBox{margin-top:10px;position:relative;}
.inputBox input,.inputBox textarea{
    width:100%;
    padding:10px;
    border:none;
    background:rgba(255,255,255,0.2);
    color:#fff;
    border-radius:5px;
}
.inputBox span{
    position:absolute;
    left:10px;
    top:10px;
    color:#ccc;
    font-size:14px;
}
.inputBox input[type="submit"]{
    background:#00c6ff;
    cursor:pointer;
}
.home-btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 20px;
    background:#ff7b00;
    color:#fff;
    text-decoration:none;
    border-radius:5px;
}
</style>
</head>

<body>

<section class="contact">

<div class="container">

    <!-- LEFT -->
    <div class="contactInfo">

        <div class="box">
            <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="text">
                <h3>Address</h3>
                <p>Cebu City, Philippines</p>
            </div>
        </div>

        <div class="box">
            <div class="icon"><i class="fas fa-phone-alt"></i></div>
            <div class="text">
                <h3>Phone</h3>
                <p>+63 912 345 6789</p>
            </div>
        </div>

        <div class="box">
            <div class="icon"><i class="fas fa-envelope"></i></div>
            <div class="text">
                <h3>Email</h3>
                <p>contact@cars.com</p>
            </div>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="contactForm">
        <form onsubmit="sendMsg(event)">
            <h2>Send Message</h2>

            <!-- FULLNAME -->
            <div class="inputBox">
                <input type="text" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
            </div>

            <!-- EMAIL -->
            <div class="inputBox">
                <input type="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>

            <!-- MESSAGE -->
            <div class="inputBox">
                <textarea required></textarea>
            </div>

            <div class="inputBox">
                <input type="submit" value="Send">
            </div>

            <a href="cardetails.php" class="home-btn">Go To Home</a>
        </form>
    </div>

</div>

</section>

<script>
function sendMsg(e){
    e.preventDefault();
    alert("Message sent! (Frontend only)");
}
</script>

</body>
</html>