<?php
session_start();
require_once('connection.php');

/* PROTECT ADMIN PAGE */

if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

/* FETCH CARS */

$query = "SELECT * FROM cars ORDER BY CAR_ID DESC";
$result = mysqli_query($con, $query);

$totalCars = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible"
content="IE=edge">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>CaRs | Admin Vehicles</title>

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    min-height:100vh;

    background:
    linear-gradient(rgba(0,0,0,0.82),
    rgba(0,0,0,0.82)),
    url("images/carbg2.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    padding:25px;
    overflow-x:hidden;
}

.wrapper{
    width:100%;
    max-width:1500px;
    margin:auto;
}

/* NAVBAR */

.navbar{
    width:100%;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:16px 35px;

    background:rgba(10,10,10,0.82);

    backdrop-filter:blur(12px);

    border-radius:22px;

    border:1px solid rgba(255,255,255,0.05);

    margin-bottom:35px;

    position:relative;
    z-index:9999;
}

.logo{
    color:#ff7200;
    font-size:34px;
    font-weight:700;
}

.logo span{
    color:white;
}

.menu ul{
    display:flex;
    align-items:center;
    gap:14px;
    list-style:none;
}

.menu ul li a{
    text-decoration:none;
    color:#dddddd;
    font-size:14px;
    font-weight:500;
    padding:12px 18px;
    border-radius:14px;
    transition:0.3s ease;
}

.menu ul li a:hover,
.menu ul li a.active{
    background:#161616;
    color:#ff7200;
}

/* PROFILE */

.profile{
    position:relative;
}

.profile-btn{
    display:flex;
    align-items:center;
    gap:10px;

    padding:12px 20px;

    border-radius:16px;

    cursor:pointer;

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
}

.profile-btn:hover{
    transform:translateY(-2px);
}

/* DROPDOWN */

.dropdown{
    position:absolute;

    top:72px;
    right:0;

    width:240px;

    background:
    linear-gradient(
    180deg,
    rgba(22,22,22,0.97),
    rgba(12,12,12,0.97)
    );

    backdrop-filter:blur(14px);

    border-radius:24px;

    border:1px solid rgba(255,255,255,0.06);

    overflow:hidden;

    display:none;

    z-index:999999;

    box-shadow:
    0 20px 45px rgba(0,0,0,0.50);
}

.dropdown-header{
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,0.06);
}

.dropdown-header h3{
    color:white;
    font-size:16px;
    margin-bottom:5px;
}

.dropdown-header p{
    color:#aaaaaa;
    font-size:12px;
}

.dropdown a{
    display:flex;
    align-items:center;
    gap:12px;

    padding:17px 20px;

    text-decoration:none;

    color:#dddddd;

    font-size:14px;

    transition:0.3s ease;
}

.dropdown a:hover{
    background:rgba(255,114,0,0.12);
    color:#ff7200;
}

/* HEADER */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;

    gap:20px;

    margin-bottom:30px;

    flex-wrap:wrap;
}

.title h1{
    color:white;
    font-size:48px;
    margin-bottom:10px;
}

.title h1 span{
    color:#ff7200;
}

.title p{
    color:#cccccc;
    font-size:15px;
}

/* STATS */

.stats{
    display:flex;
    gap:20px;
}

.stat-card{
    min-width:220px;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(10px);

    border-radius:22px;

    padding:24px;

    border:1px solid rgba(255,255,255,0.05);

    color:white;
}

.stat-card h2{
    font-size:36px;
    margin-bottom:8px;
}

.stat-card p{
    color:#cccccc;
    font-size:14px;
}

/* CONTAINER */

.container{
    width:100%;

    background:
    linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
    );

    backdrop-filter:blur(12px);

    border-radius:28px;

    padding:30px;

    border:1px solid rgba(255,255,255,0.05);

    overflow:hidden;
}

/* TOP BAR */

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:25px;

    flex-wrap:wrap;

    gap:20px;
}

.top-bar h2{
    color:white;
    font-size:30px;
}

.add-btn{
    display:flex;
    align-items:center;
    gap:10px;

    padding:14px 22px;

    border-radius:16px;

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
}

/* TABLE */

.table-wrapper{
    overflow:auto;
    border-radius:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    min-width:1100px;
}

thead{
    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;
}

th{
    padding:18px;
    font-size:14px;
}

td{
    padding:18px;
    text-align:center;
    font-size:14px;
    color:#333;
    border-bottom:1px solid #f1f1f1;
}

tbody tr:hover{
    background:#fff7f1;
}

/* IMAGE */

.car-img{
    width:130px;
    height:80px;

    object-fit:cover;

    border-radius:14px;

    display:block;
    margin:auto;

    background:#111;
}

/* STATUS */

.status{
    padding:8px 14px;

    border-radius:50px;

    font-size:12px;

    font-weight:600;

    display:inline-block;
}

.available{
    background:rgba(40,167,69,0.15);
    color:#28a745;
}

.not-available{
    background:rgba(220,53,69,0.15);
    color:#dc3545;
}

/* ACTIONS */

.actions{
    display:flex;
    justify-content:center;
    gap:10px;
}

/* BUTTONS */

.edit-btn{
    background:#007bff;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:12px;
    cursor:pointer;
}

.delete-btn{
    background:#dc3545;
    color:white;
    text-decoration:none;
    padding:10px 14px;
    border-radius:12px;
    cursor:pointer;
}

/* MODAL */

.modal{
    display:none;

    position:fixed;

    z-index:999999;

    left:0;
    top:0;

    width:100%;
    height:100%;

    background:rgba(0,0,0,0.75);

    padding:20px;

    overflow:auto;
}

.modern-modal{
    background:white;

    width:580px;

    max-width:100%;

    border-radius:32px;

    padding:35px;

    position:relative;

    margin:40px auto;

    animation:popup 0.3s ease;
}

@keyframes popup{

    from{
        transform:scale(0.8);
        opacity:0;
    }

    to{
        transform:scale(1);
        opacity:1;
    }
}

.modal-top{
    display:flex;
    align-items:center;
    gap:18px;
    margin-bottom:30px;
}

.modal-icon{
    width:80px;
    height:80px;

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

    font-size:30px;
}

.modal-text h2{
    color:#111;
    font-size:34px;
    margin-bottom:5px;
}

.modal-text p{
    color:#777;
    font-size:14px;
}

.close{
    position:absolute;

    top:20px;
    right:20px;

    width:42px;
    height:42px;

    border-radius:50%;

    background:#f1f1f1;

    display:flex;
    justify-content:center;
    align-items:center;

    cursor:pointer;
}

.image-preview-wrapper{
    width:100%;
    height:240px;

    border-radius:24px;

    overflow:hidden;

    margin-bottom:22px;

    background:#111;
}

.image-preview-wrapper img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.upload-box{
    margin-bottom:22px;
}

.upload-label{
    display:flex;
    align-items:center;
    gap:10px;

    color:#ff7200;

    font-size:14px;
    font-weight:600;

    margin-bottom:12px;
}

.upload-box input{
    width:100%;
    padding:14px;
    border-radius:16px;
    border:2px dashed #ccc;
}

.input-group{
    margin-bottom:18px;
}

.input-group label{
    display:flex;
    align-items:center;
    gap:10px;

    margin-bottom:10px;

    font-size:14px;
    font-weight:600;

    color:#333;
}

.input-group input,
.input-group select{
    width:100%;
    height:58px;

    padding:0 18px;

    border-radius:16px;

    border:1px solid #ddd;

    font-size:14px;
}

.modern-save-btn{
    width:100%;
    height:60px;

    border:none;

    border-radius:18px;

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
}

</style>

</head>

<body>

<div class="wrapper">

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        Ca<span>Rs</span> Admin
    </div>

    <div class="menu">

        <ul>

            <li>
                <a href="adminvehicle.php"
                class="active">
                    Vehicles
                </a>
            </li>

            <li>
                <a href="adminusers.php">
                    Users
                </a>
            </li>

            <li>
                <a href="admindash.php">
                    Feedbacks
                </a>
            </li>

        </ul>

    </div>

    <!-- PROFILE -->

    <div class="profile">

        <div class="profile-btn"
        onclick="toggleMenu()">

            <i class="fa-solid fa-user-shield"></i>

            Admin

            <i class="fa-solid fa-angle-down"></i>

        </div>

        <div class="dropdown"
        id="dropdownMenu">

            <div class="dropdown-header">

                <h3>Administrator</h3>

                <p>Car Rental System</p>

            </div>

            <a href="#"
            onclick="confirmLogout()">

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </a>

        </div>

    </div>

</div>

<!-- HEADER -->

<div class="header">

    <div class="title">

        <h1>

            Vehicle <span>Management</span>

        </h1>

        <p>

            Manage all rental vehicles inside the system.

        </p>

    </div>

    <div class="stats">

        <div class="stat-card">

            <h2>

                <?php echo $totalCars; ?>

            </h2>

            <p>

                Total Cars

            </p>

        </div>

    </div>

</div>

<!-- CONTAINER -->

<div class="container">

    <div class="top-bar">

        <h2>
            Car Lists
        </h2>

        <a href="addcar.php"
        class="add-btn">

            <i class="fa-solid fa-plus"></i>

            Add Car

        </a>

    </div>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>Image</th>
                    <th>Name</th>
                    <th>Fuel</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php while($res = mysqli_fetch_assoc($result)){ ?>

            <?php

            $image = $res['CAR_IMG'];

            if(!empty($image) && file_exists("images/".$image)){
                $finalImage = "images/".$image;
            }
            else{
                $finalImage = "images/default.png";
            }

            ?>

            <tr>

                <td>

                    <img class="car-img"
                    src="<?php echo htmlspecialchars($finalImage); ?>">

                </td>

                <td>

                    <?php echo htmlspecialchars($res['CAR_NAME']); ?>

                </td>

                <td>

                    <?php echo htmlspecialchars($res['FUEL_TYPE']); ?>

                </td>

                <td>

                    <?php echo htmlspecialchars($res['CAPACITY']); ?>

                </td>

                <td>

                    ₱<?php echo number_format((float)$res['PRICE'], 2); ?>

                </td>

                <td>

                <?php if($res['AVAILABLE']=='Y'){ ?>

                    <span class="status available">

                        Available

                    </span>

                <?php }else{ ?>

                    <span class="status not-available">

                        Not Available

                    </span>

                <?php } ?>

                </td>

                <td>

                    <div class="actions">

                        <!-- EDIT -->

                        <button class="edit-btn"

                        onclick="openEditModal(
                        '<?php echo $res['CAR_ID']; ?>',
                        '<?php echo htmlspecialchars($res['CAR_NAME']); ?>',
                        '<?php echo htmlspecialchars($res['FUEL_TYPE']); ?>',
                        '<?php echo htmlspecialchars($res['CAPACITY']); ?>',
                        '<?php echo htmlspecialchars($res['PRICE']); ?>',
                        '<?php echo htmlspecialchars($res['AVAILABLE']); ?>',
                        '<?php echo htmlspecialchars($finalImage); ?>'
                        )">

                            <i class="fa-solid fa-pen"></i>

                        </button>

                        <!-- DELETE -->

                        <a class="delete-btn"

                        href="deletecar.php?id=<?php echo $res['CAR_ID']; ?>"

                        onclick="return confirmDelete('<?php echo htmlspecialchars($res['CAR_NAME']); ?>')">

                            <i class="fa-solid fa-trash"></i>

                        </a>

                    </div>

                </td>

            </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</div>

<!-- EDIT MODAL -->

<div id="editModal" class="modal">

    <div class="modern-modal">

        <span class="close"
        onclick="closeModal()">

            <i class="fa-solid fa-xmark"></i>

        </span>

        <div class="modal-top">

            <div class="modal-icon">

                <i class="fa-solid fa-car-side"></i>

            </div>

            <div class="modal-text">

                <h2>Edit Vehicle</h2>

                <p>Update vehicle information.</p>

            </div>

        </div>

        <form action="updatecar.php"
        method="POST"
        enctype="multipart/form-data">

            <input type="hidden"
            name="car_id"
            id="edit_car_id">

            <div class="image-preview-wrapper">

                <img id="previewImage"
                src="images/default.png">

            </div>

            <div class="upload-box">

                <label class="upload-label">

                    <i class="fa-solid fa-image"></i>

                    Upload New Image

                </label>

                <input type="file"
                name="car_image"
                accept="image/*"
                onchange="previewCarImage(event)">

            </div>

            <div class="input-group">

                <label>

                    <i class="fa-solid fa-car"></i>

                    Car Name

                </label>

                <input type="text"
                name="car_name"
                id="edit_car_name"
                required>

            </div>

            <div class="input-group">

                <label>

                    <i class="fa-solid fa-gas-pump"></i>

                    Fuel Type

                </label>

                <input type="text"
                name="fuel_type"
                id="edit_fuel"
                required>

            </div>

            <div class="input-group">

                <label>

                    <i class="fa-solid fa-users"></i>

                    Capacity

                </label>

                <input type="number"
                name="capacity"
                id="edit_capacity"
                required>

            </div>

            <div class="input-group">

                <label>

                    <i class="fa-solid fa-money-bill-wave"></i>

                    Price

                </label>

                <input type="number"
                step="0.01"
                name="price"
                id="edit_price"
                required>

            </div>

            <div class="input-group">

                <label>

                    <i class="fa-solid fa-circle-check"></i>

                    Availability

                </label>

                <select name="available"
                id="edit_available">

                    <option value="Y">YES</option>
                    <option value="N">NO</option>

                </select>

            </div>

            <button type="submit"
            class="modern-save-btn">

                <i class="fa-solid fa-floppy-disk"></i>

                Save Changes

            </button>

        </form>

    </div>

</div>

<script>

/* PROFILE MENU */

function toggleMenu(){

    let menu =
    document.getElementById(
    "dropdownMenu"
    );

    menu.style.display =
    (menu.style.display==="block")
    ? "none"
    : "block";
}

/* LOGOUT */

function confirmLogout(){

    if(confirm(
    "Are you sure you want to logout?"
    )){

        window.location.href =
        "index.php";
    }
}

/* DELETE CONFIRM */

function confirmDelete(carName){

    return confirm(
    "Are you sure you want to delete "
    + carName + "?"
    );
}

/* OPEN MODAL */

function openEditModal(
id,
name,
fuel,
capacity,
price,
available,
image
){

    document.getElementById(
    "editModal"
    ).style.display = "block";

    document.getElementById(
    "edit_car_id"
    ).value = id;

    document.getElementById(
    "edit_car_name"
    ).value = name;

    document.getElementById(
    "edit_fuel"
    ).value = fuel;

    document.getElementById(
    "edit_capacity"
    ).value = capacity;

    document.getElementById(
    "edit_price"
    ).value = price;

    document.getElementById(
    "edit_available"
    ).value = available;

    document.getElementById(
    "previewImage"
    ).src = image;
}

/* CLOSE MODAL */

function closeModal(){

    document.getElementById(
    "editModal"
    ).style.display = "none";
}

/* IMAGE PREVIEW */

function previewCarImage(event){

    let image =
    document.getElementById(
    "previewImage"
    );

    image.src =
    URL.createObjectURL(
    event.target.files[0]
    );
}

/* CLOSE DROPDOWN */

window.onclick = function(e){

    if(!e.target.closest('.profile')){

        document.getElementById(
        "dropdownMenu"
        ).style.display = "none";
    }

    let modal =
    document.getElementById(
    "editModal"
    );

    if(e.target == modal){

        closeModal();
    }
}

</script>

</body>
</html>