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
$sql="SELECT * FROM booking WHERE EMAIL='$email' ORDER BY BOOK_ID DESC LIMIT 1";
$cname = mysqli_query($con,$sql);
$data = mysqli_fetch_assoc($cname);

/* SAFETY CHECK */
if(!$data){
    header("Location: cardetails.php");
    exit();
}

$bid = $data['BOOK_ID'];
$_SESSION['bid'] = $bid;

/* PAYMENT PROCESS */
if(isset($_POST['pay'])){
  $cardno = $_POST['cardno'];
  $exp    = $_POST['exp'];
  $cvv    = $_POST['cvv'];
  $price  = $data['PRICE'];

  if(empty($cardno) || empty($exp) || empty($cvv)){
    echo "<script>alert('Please fill all fields');</script>";
  } else {

    $sql2="INSERT INTO payment (BOOK_ID,CARD_NO,EXP_DATE,CVV,PRICE) 
           VALUES('$bid','$cardno','$exp','$cvv','$price')";
    
    if(mysqli_query($con,$sql2)){
      header("Location: psucess.php");
      exit();
    } else {
      echo "<script>alert('Payment failed');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Form</title>

<style>
@import url("https://fonts.googleapis.com/css?family=Poppins&display=swap");

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:"Poppins", sans-serif;
}

body{
  height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  background:url("images/paym.jpg") no-repeat center center fixed;
  background-size:cover;
}

body::before{
  content:'';
  position:absolute;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.5);
  z-index:-1;
}

.wrapper{
  width:100%;
  max-width:1200px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:40px;
}

.payment{
  color:#fff;
  font-size:28px;
  font-weight:bold;
}

.card{
  width:500px;
  background:rgba(255,255,255,0.1);
  backdrop-filter:blur(12px);
  border-radius:15px;
  padding:30px;
}

.card__title{
  font-size:28px;
  color:#fff;
  margin-bottom:20px;
}

.card__row{
  display:flex;
  gap:10px;
  margin-bottom:20px;
}

.card__col{
  flex:1;
}

.card__label{
  color:#ccc;
  font-size:14px;
}

.card__input{
  width:100%;
  padding:10px;
  margin-top:5px;
  border:none;
  border-radius:8px;
  background:rgba(255,255,255,0.1);
  color:#fff;
}

.btn-group{
  display:flex;
  gap:10px;
  margin-top:20px;
}

.pay, .btn{
  flex:1;
  height:45px;
  border:none;
  border-radius:8px;
  font-size:16px;
  cursor:pointer;
  background:#ff7200;
  color:#fff;
}

.btn{
  background:#555;
}
</style>
</head>

<body>

<div class="wrapper">

<div class="payment">
  TOTAL PAYMENT: <br><br>
  ₱<?php echo number_format($data['PRICE'], 2); ?>
</div>

<div class="card">
<form method="POST">

<h1 class="card__title">Enter Payment Information</h1>

<div class="card__row">
<div class="card__col">
<label class="card__label">Card Number</label>
<input type="text" class="card__input" name="cardno"
maxlength="16"
oninput="this.value=this.value.replace(/[^0-9]/g,'')"
required>
</div>
</div>

<div class="card__row">
<div class="card__col">
<label class="card__label">Expiry Date</label>
<input type="text" class="card__input" name="exp"
placeholder="MM/YY"
maxlength="5"
required>
</div>

<div class="card__col">
<label class="card__label">CVV</label>
<input type="password" class="card__input" name="cvv"
maxlength="3"
oninput="this.value=this.value.replace(/[^0-9]/g,'')"
required>
</div>
</div>

<div class="btn-group">
<input type="submit" value="PAY NOW" class="pay" name="pay">
<button type="button" class="btn" onclick="window.location.href='cancelbooking.php'">CANCEL</button>
</div>

</form>
</div>

</div>

</body>
</html>