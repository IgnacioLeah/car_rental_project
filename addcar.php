<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT ADMIN PAGE */
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMINISTRATOR</title>

<style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* ✅ FIXED BACKGROUND */
body{
    min-height: 100vh;
    background: url("images/regs.jpg") no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* 🔥 DARK OVERLAY FOR BETTER LOOK */
body::before{
    content:'';
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.5);
    z-index:-1;
}

/* CONTAINER */
.main{
    width: 400px;
}

/* FORM BOX */
.register{
    background-color: rgba(0,0,0,0.7);
    padding: 25px;
    border-radius: 10px;
    color: #fff;
}

/* TITLE */
h2{
    text-align: center;
    margin-bottom: 15px;
}

/* INPUT */
input{
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: none;
}

/* BUTTON */
.btnn{
    width: 100%;
    height: 40px;
    background: #ff7200;
    border:none;
    margin-top: 20px;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    color:#fff;
}

.btnn:hover{
    background: #fff;
    color:#ff7200;
}

/* BACK BUTTON */
#back{
    position: absolute;
    top: 20px;
    left: 20px;
    background: #ff7200;
    border:none;
    padding:10px 20px;
    border-radius: 8px;
}

#back a{
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}
</style>
</head>

<body>

<button id="back"><a href="adminvehicle.php">HOME</a></button> 

<div class="main">
    <div class="register">
        <h2>Enter Details Of New Car</h2>

        <form action="upload.php" method="POST" enctype="multipart/form-data">

            <label>Car Name:</label>
            <input type="text" name="carname" placeholder="Enter Car Name" required>

            <label>Fuel Type:</label>
            <input type="text" name="ftype" placeholder="Enter Fuel Type" required>

            <label>Capacity:</label>
            <input type="number" name="capacity" min="1" placeholder="Enter Capacity" required>

            <label>Price:</label>
            <input type="number" name="price" min="1" placeholder="Enter Price (per day)" required>

            <label>Car Image:</label>
            <input type="file" name="image" required>

            <input type="submit" class="btnn" value="ADD CAR" name="addcar">

        </form>
    </div>
</div>

</body>
</html>