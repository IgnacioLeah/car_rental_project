<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>REGISTER | CaRs</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;

    /* 🚗 CAR BACKGROUND */
    background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70') no-repeat center center/cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
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

/* CARD */
.main{
    width:900px;
    height:520px;
    background:rgba(0,0,0,0.85);
    border-radius:12px;
    display:flex;
    justify-content:center;
    align-items:center;
    box-shadow:0 10px 40px rgba(0,0,0,0.6);
}

.password-box{
    position:relative;
}

.password-box input{
    width:100%;
    padding-right:40px; /* space for eye */
}

.password-box span{
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    font-size:18px;
}

.valid {
  color: limegreen;
  font-weight: bold;
}

.invalid {
  color: red;
}

.valid::before {
  content: "✔ ";
}

.invalid::before {
  content: "✖ ";
}

/* FORM */
.register{
    width:90%;
    color:#fff;
}

.register h2{
    text-align:center;
    margin-bottom:15px;
    color:#ff7200;
}

/* GRID FORM */
#register{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

/* INPUTS */
input{
    padding:10px;
    border:none;
    border-radius:5px;
    outline:none;
}

/* FULL WIDTH */
.full{
    grid-column:span 2;
}

/* GENDER */
.gender{
    grid-column:span 2;
    display:flex;
    justify-content:center;
    gap:20px;
}

/* BUTTON */
.btnn{
    grid-column:span 2;
    padding:10px;
    background:#ff7200;
    color:#fff;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.btnn:hover{
    background:#ff5500;
}

/* HOME BUTTON */
#back{
    position:absolute;
    top:20px;
    left:20px;
    background:#ff7200;
    border:none;
    padding:10px 15px;
    border-radius:5px;
}

#back a{
    color:#fff;
    text-decoration:none;
}

/* PASSWORD MESSAGE */
#message{
    position:absolute;
    bottom:20px;
    right:20px;
    width:250px;
    background:#fff;
    color:#000;
    padding:10px;
    border-radius:5px;
    display:none;
}

.valid{ color:green; }
.invalid{ color:red; }

</style>

</head>

<body>

<?php
require_once('connection.php');

if(isset($_POST['regs']))
{
    $fname=mysqli_real_escape_string($con,$_POST['fname']);
    $lname=mysqli_real_escape_string($con,$_POST['lname']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $lic=mysqli_real_escape_string($con,$_POST['lic']);
    $ph=mysqli_real_escape_string($con,$_POST['ph']);
    $pass=mysqli_real_escape_string($con,$_POST['pass']);
    $cpass=mysqli_real_escape_string($con,$_POST['cpass']);
    $gender=mysqli_real_escape_string($con,$_POST['gender']);

    $Pass=md5($pass);

    if(empty($fname)|| empty($lname)|| empty($email)|| empty($lic)|| empty($ph)|| empty($pass)|| empty($gender)){
        echo '<script>alert("Please fill all fields")</script>';
    }
    else{
        if($pass==$cpass){

            $check="SELECT * FROM users WHERE EMAIL='$email'";
            $res=mysqli_query($con,$check);

            if(mysqli_num_rows($res)>0){
                echo '<script>alert("Email already exists!")</script>';
                echo '<script>window.location.href="index.php"</script>';
            }
            else{
                $sql="INSERT INTO users (FNAME,LNAME,EMAIL,LIC_NUM,PHONE_NUMBER,PASSWORD,GENDER)
                VALUES('$fname','$lname','$email','$lic','$ph','$Pass','$gender')";

                if(mysqli_query($con,$sql)){
                    echo '<script>alert("Registration Successful!")</script>';
                    echo '<script>window.location.href="index.php"</script>';
                } else {
                    echo '<script>alert("Error occurred")</script>';
                }
            }
        }
        else{
            echo '<script>alert("Passwords do not match")</script>';
        }
    }
}
?>

<!-- HOME BUTTON -->

<button id="back"><a href="index.php">HOME</a></button>

<!-- CARD -->

<div class="main">
    <div class="register">
        <h2>Register Here</h2>

    <form id="register" method="POST">

      <input type="text" name="fname" placeholder="First Name" required>
      <input type="text" name="lname" placeholder="Last Name" required>

      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="lic" placeholder="License Number" required>

      <input type="tel" name="ph" placeholder="Phone Number" required>

      <!-- PASSWORD -->
      <div class="password-box">
          <input type="password" name="pass" id="psw" placeholder="Password" required>
          <span onclick="togglePassword('psw', this)">👁️</span>
      </div>

      <!-- CONFIRM PASSWORD -->
      <div class="password-box">
          <input type="password" name="cpass" id="cpsw" placeholder="Confirm Password" required>
          <span onclick="togglePassword('cpsw', this)">👁️</span>
      </div>

      <div class="gender">
          <label><input type="radio" name="gender" value="male"> Male</label>
          <label><input type="radio" name="gender" value="female"> Female</label>
      </div>

      <input type="submit" class="btnn" value="REGISTER" name="regs">

    </form>
  </div>
</div>

<!-- PASSWORD VALIDATION -->

<div id="message">
  <p id="letter" class="invalid">Lowercase letter</p>
  <p id="capital" class="invalid">Uppercase letter</p>
  <p id="number" class="invalid">Number</p>
  <p id="length" class="invalid">8 characters</p>
</div>

<script>

function togglePassword(id, icon){
    let input = document.getElementById(id);

    if(input.type === "password"){
        input.type = "text";
        icon.textContent = "🙈"; // closed eye
    } else {
        input.type = "password";
        icon.textContent = "👁️"; // open eye
    }
}  
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// show box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// hide box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// validation
myInput.onkeyup = function() {

  // LOWERCASE
  if(myInput.value.match(/[a-z]/g)) {
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }

  // UPPERCASE
  if(myInput.value.match(/[A-Z]/g)) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // NUMBER
  if(myInput.value.match(/[0-9]/g)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // LENGTH
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>

</body>
</html>
