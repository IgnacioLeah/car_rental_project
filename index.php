<?php
require_once('connection.php');
session_start();  

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    if(empty($email) || empty($pass))
    {
        echo '<script>alert("Please fill all fields")</script>';
    }
    else{
        $query = "SELECT * FROM users WHERE EMAIL='$email'";
        $res = mysqli_query($con, $query);

        if($row = mysqli_fetch_assoc($res)){
            $db_password = $row['PASSWORD'];

            if(md5($pass) == $db_password)
            {
                $_SESSION['email'] = $email;
                header("location: cardetails.php");
                exit();
            }
            else{
                echo '<script>alert("Wrong password")</script>';
            }
        }
        else{
            echo '<script>alert("Email not found")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>CAR RENTAL</title>

<link rel="stylesheet" href="css/style.css">

<script>
function preventBack() {
    window.history.forward(); 
}
setTimeout("preventBack()", 0);
window.onunload = function () { null };
</script>

<style>
.password-box{
    position: relative;
    width: 100%;
}

.toggle-icon{
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%) scale(0.3);
    cursor: pointer;
    opacity: 0.7;
}

.toggle-icon:hover{
    opacity: 1;
}
</style>

</head>

<body>

<div class="hai">

<!-- NAVBAR -->
<div class="navbar">
    <div class="icon">
        <!-- 🔥 SECRET CLICK AREA -->
        <h2 class="logo" onclick="secretAdmin()">CaRs</h2>
    </div>

    <div class="menu">
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="aboutus.html">ABOUT</a></li>
            <li><a href="services.html">SERVICES</a></li>
            <li><a href="contactus.html">CONTACT</a></li>
            <!-- ❌ ADMIN BUTTON REMOVED -->
        </ul>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    <h1>Rent Your <br><span>Dream Car</span></h1>

    <p class="par">
        Live the life of Luxury.<br>
        Just rent a car of your wish from our vast collection.<br>
        Enjoy every moment with your family<br>
        Join us to make this family vast.
    </p>

    <button class="cn"><a href="register.php">JOIN US</a></button>

    <!-- LOGIN FORM -->
    <div class="form">
        <h2>Login Here</h2>

        <form method="POST"> 

            <input type="email" name="email" placeholder="Enter Email Here" required>

            <div class="password-box">
                <input type="password" name="pass" id="password" placeholder="Enter Password Here" required>

                <span class="toggle-icon" onclick="togglePassword()" id="toggleIcon">
                    👁️
                </span>
            </div>

            <input class="btnn" type="submit" value="Login" name="login">

        </form>

        <p class="link">
            Don't have an account?<br>
            <a href="register.php">Sign up</a> here
        </p>
    </div>
</div>

</div>

<script>
function togglePassword() {
    let pass = document.getElementById("password");
    let icon = document.getElementById("toggleIcon");

    if(pass.type === "password"){
        pass.type = "text";
        icon.innerHTML = "🙈";
    } else {
        pass.type = "password";
        icon.innerHTML = "👁️";
    }
}

/* SECRET ADMIN ACCESS */
let clickCount = 0;

function secretAdmin(){
    clickCount++;

    if(clickCount === 5){
        window.location.href = "adminlogin.php";
    }

    setTimeout(() => {
        clickCount = 0;
    }, 2000);
}
</script>

</body>
</html>