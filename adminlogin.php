<?php
require_once('connection.php');
session_start();

if(isset($_POST['adlog'])){
    $id = $_POST['adid'];
    $pass = $_POST['adpass'];

    if(empty($id) || empty($pass))
    {
        echo '<script>alert("please fill the blanks")</script>';
    }
    else{
        $query = "SELECT * FROM admin WHERE ADMIN_ID='$id'";
        $res = mysqli_query($con, $query);

        if($row = mysqli_fetch_assoc($res)){
            $db_password = $row['ADMIN_PASSWORD'];

            if($pass == $db_password){
                $_SESSION['admin'] = $id;
                header("Location: admindash.php");
                exit();
            } else {
                echo '<script>alert("Invalid Credentials")</script>';
            }

        } else {
            echo '<script>alert("Invalid Credentials")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN LOGIN</title>

    <script>
        function preventBack() {
            window.history.forward(); 
        }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script>

    <style>
    body{
        width: 90%;
        background-image: url("images/adminbg2.jpg");
        background-repeat: no-repeat;
        overflow:hidden;
        background-position: center;
        background-size: cover;
        height: 95vh;
    }

    .form{
        width: 300px;
        height: 300px;
        background: linear-gradient(to top, rgba(0,0,0,0.8)50%,rgba(0,0,0,0.8)50%);
        position: absolute;
        top:200px;
        left:800px;
        border-radius: 10px;
        padding: 20px;
    }

    .form h2{
        width:90%;
        text-align: center;
        color: orange;
        font-size: 22px;
        background-color: white;
        border-radius: 10px;
        margin: 2px;
        padding: 8px;
    }

    .h{
        width: 100%;
        height: 75px;
        background: transparent;
        border-bottom: 1px solid #ff7200;
        border: none;
        color:#fff;
        font-size: 15px;
        margin-top: 30px;
    }

    .h:focus{ outline: none; }

    ::placeholder{ color:#fff; }

    .btnn{
        width: 300px;
        height: 40px;
        background: #ff7200;
        border:none;
        margin-top: 70px;
        font-size: 18px;
        border-radius: 10px;
        cursor: pointer;
        color:#fff;
    }

    .btnn:hover{
        background: #fff;
        color:#ff7200;
    }

    .helloadmin{
        width: 1500px;
        height: 100%;
        margin-top: 60px;
        text-align: center;
    }

    .helloadmin h1{
        margin-top: 650px;
        margin-left: 425px;
        font-size: 50px;
        color: white;
    }

    .back{
        position: absolute;
        top: 40px;
        left: 20px;
        width: 150px;
        height: 40px;
        background: #ff7200;
        border:none;
        font-size: 16px;
        border-radius: 10px;
        cursor: pointer;
        color:#fff;
    }

    .back a{
        text-decoration: none;
        color: #fff;
        font-weight: bold;
    }

    .back:hover{
        background:#fff;
    }

    .back:hover a{
        color:#ff7200;
    }

    .password-box{
        position: relative;
    }

    .password-box input{
        width: 100%;
        padding-right: 40px;
    }

    .password-box span{
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
    </style>
</head>

<body>

<button class="back"><a href="index.php">Go To Home</a></button>

<div class="helloadmin">
    <h1>HELLO ADMIN!</h1>
</div>

<form class="form" method="POST">
    <h2>Admin Login</h2>

    <input class="h" type="text" name="adid" placeholder="Enter admin name" required>

    <div class="password-box">
        <input class="h" type="password" name="adpass" id="adpass" placeholder="Enter admin password" required>
        <span onclick="togglePassword('adpass', this)">👁️</span>
    </div>

    <input type="submit" class="btnn" value="LOGIN" name="adlog">
</form>

<script>
function togglePassword(id, icon){
    let input = document.getElementById(id);

    if(input.type === "password"){
        input.type = "text";
        icon.textContent = "🙈";
    } else {
        input.type = "password";
        icon.textContent = "👁️";
    }
}
</script>

</body>
</html>