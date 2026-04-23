<?php
require_once('connection.php');
session_start();

/* 🔐 PROTECT */
if(!isset($_SESSION['bid'])){
    header("Location: cardetails.php");
    exit();
}

$bid = $_SESSION['bid'];

/* CANCEL */
if(isset($_POST['cancelnow'])){
    mysqli_query($con,"DELETE FROM booking WHERE BOOK_ID='$bid'");
    header("Location: cardetails.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cancel Booking</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* 🔥 BACKGROUND */
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:url("images/carbg2.jpg") no-repeat center/cover;
    position:relative;
}

/* OVERLAY */
body::before{
    content:'';
    position:fixed;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
    z-index:-1;
}

/* CARD */
.container{
    width:500px;
    max-width:90%;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:40px;
    text-align:center;
    color:#fff;
    box-shadow:0 15px 40px rgba(0,0,0,0.6);
    animation:fadeIn 0.5s ease;
}

/* TITLE */
.container h1{
    font-size:22px;
    margin-bottom:30px;
    line-height:1.5;
}

/* ICON */
.icon{
    font-size:60px;
    margin-bottom:20px;
}

/* BUTTON GROUP */
.btn-group{
    display:flex;
    gap:15px;
    justify-content:center;
}

/* BUTTONS */
.btn{
    flex:1;
    padding:12px;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}

/* CANCEL */
.cancel{
    background:#ff3b3b;
    color:#fff;
}

.cancel:hover{
    background:#e60000;
}

/* GO BACK */
.back{
    background:#ff7200;
    color:#fff;
}

.back:hover{
    background:#e65c00;
}

/* ANIMATION */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}
</style>
</head>

<body>

<div class="container">

<div class="icon">⚠️</div>

<h1>Are you sure you want to cancel your booking?</h1>

<form method="POST">

<div class="btn-group">

<button type="submit" name="cancelnow" class="btn cancel">
    Yes, Cancel
</button>

<button type="button" class="btn back" onclick="window.location.href='payment.php'">
    Go to Payment
</button>

</div>

</form>

</div>

</body>
</html>