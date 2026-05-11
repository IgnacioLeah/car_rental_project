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

<meta http-equiv="X-UA-Compatible"
content="IE=edge">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>CaRs | Add Vehicle</title>

<!-- GOOGLE FONT -->

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<!-- FONT AWESOME -->

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

/* BODY */

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    padding:30px;

    background:
    linear-gradient(rgba(0,0,0,0.82),
    rgba(0,0,0,0.82)),
    url("images/regs.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    overflow-x:hidden;
}

/* BACK BUTTON */

.back-btn{

    position:fixed;

    top:25px;
    left:25px;

    display:flex;
    align-items:center;

    gap:10px;

    padding:14px 22px;

    border-radius:18px;

    text-decoration:none;

    color:white;

    font-size:14px;
    font-weight:600;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    box-shadow:
    0 10px 25px rgba(255,114,0,0.25);

    transition:0.3s ease;

    z-index:999;
}

.back-btn:hover{

    transform:translateY(-3px);
}

/* MAIN CARD */

.card{

    width:100%;
    max-width:650px;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(18px);

    border-radius:32px;

    padding:40px;

    border:1px solid rgba(255,255,255,0.06);

    box-shadow:
    0 20px 45px rgba(0,0,0,0.45);
}

/* HEADER */

.card-header{

    display:flex;
    align-items:center;

    gap:18px;

    margin-bottom:35px;
}

/* ICON */

.icon-box{

    width:85px;
    height:85px;

    border-radius:24px;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    font-size:34px;

    box-shadow:
    0 12px 30px rgba(255,114,0,0.30);
}

/* TITLE */

.header-text h1{

    color:white;

    font-size:34px;

    margin-bottom:8px;
}

.header-text p{

    color:#cccccc;

    font-size:14px;

    line-height:1.7;
}

/* IMAGE PREVIEW */

.preview-box{

    width:100%;
    height:260px;

    border-radius:24px;

    overflow:hidden;

    background:#111;

    margin-bottom:25px;

    border:2px dashed rgba(255,255,255,0.10);
}

.preview-box img{

    width:100%;
    height:100%;

    object-fit:cover;
}

/* INPUT GROUP */

.input-group{

    margin-bottom:22px;
}

/* LABEL */

.input-group label{

    display:flex;
    align-items:center;

    gap:10px;

    color:white;

    margin-bottom:12px;

    font-size:14px;

    font-weight:600;
}

/* INPUT */

.input-group input{

    width:100%;

    height:58px;

    padding:0 18px;

    border:none;

    outline:none;

    border-radius:18px;

    background:rgba(255,255,255,0.08);

    color:white;

    font-size:14px;

    border:1px solid transparent;

    transition:0.3s ease;
}

.input-group input:focus{

    border-color:#ff7200;
}

/* FILE INPUT */

.file-input{

    padding:16px !important;

    height:auto !important;

    cursor:pointer;
}

/* PLACEHOLDER */

input::placeholder{

    color:#aaaaaa;
}

/* BUTTON */

.submit-btn{

    width:100%;

    height:62px;

    border:none;

    border-radius:20px;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    display:flex;
    justify-content:center;
    align-items:center;

    gap:12px;

    margin-top:10px;

    transition:0.3s ease;

    box-shadow:
    0 12px 30px rgba(255,114,0,0.28);
}

.submit-btn:hover{

    transform:translateY(-3px);
}

/* RESPONSIVE */

@media(max-width:700px){

    body{

        padding:15px;
    }

    .card{

        padding:25px;
    }

    .card-header{

        flex-direction:column;

        text-align:center;
    }

    .header-text h1{

        font-size:28px;
    }

    .preview-box{

        height:220px;
    }

    .back-btn{

        top:15px;
        left:15px;

        padding:12px 18px;
    }
}

</style>

</head>

<body>

<!-- BACK -->

<a href="adminvehicle.php"
class="back-btn">

    <i class="fa-solid fa-arrow-left"></i>

    Back

</a>

<!-- CARD -->

<div class="card">

    <!-- HEADER -->

    <div class="card-header">

        <div class="icon-box">

            <i class="fa-solid fa-car-side"></i>

        </div>

        <div class="header-text">

            <h1>Add New Vehicle</h1>

            <p>

                Enter complete vehicle details and upload
                a high quality car image.

            </p>

        </div>

    </div>

    <!-- FORM -->

    <form action="upload.php"
    method="POST"
    enctype="multipart/form-data">

        <!-- IMAGE PREVIEW -->

        <div class="preview-box">

            <img id="previewImage"
            src="images/default.png"
            alt="Preview">

        </div>

        <!-- CAR NAME -->

        <div class="input-group">

            <label>

                <i class="fa-solid fa-car"></i>

                Car Name

            </label>

            <input type="text"
            name="carname"
            placeholder="Enter car name"
            required>

        </div>

        <!-- FUEL -->

        <div class="input-group">

            <label>

                <i class="fa-solid fa-gas-pump"></i>

                Fuel Type

            </label>

            <input type="text"
            name="ftype"
            placeholder="Enter fuel type"
            required>

        </div>

        <!-- CAPACITY -->

        <div class="input-group">

            <label>

                <i class="fa-solid fa-users"></i>

                Capacity

            </label>

            <input type="number"
            name="capacity"
            min="1"
            placeholder="Enter seating capacity"
            required>

        </div>

        <!-- PRICE -->

        <div class="input-group">

            <label>

                <i class="fa-solid fa-money-bill-wave"></i>

                Rental Price

            </label>

            <input type="number"
            name="price"
            min="1"
            placeholder="Enter price per day"
            required>

        </div>

        <!-- IMAGE -->

        <div class="input-group">

            <label>

                <i class="fa-solid fa-image"></i>

                Car Image

            </label>

            <input type="file"
            name="image"
            class="file-input"
            accept="image/*"
            onchange="previewCar(event)"
            required>

        </div>

        <!-- BUTTON -->

        <button type="submit"
        class="submit-btn"
        name="addcar">

            <i class="fa-solid fa-plus"></i>

            Add Vehicle

        </button>

    </form>

</div>

<script>

/* IMAGE PREVIEW */

function previewCar(event){

    let image =
    document.getElementById(
    "previewImage"
    );

    image.src =
    URL.createObjectURL(
    event.target.files[0]
    );
}

</script>

</body>
</html>