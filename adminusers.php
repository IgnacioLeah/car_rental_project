<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT ADMIN PAGE */

if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

/* FETCH USERS */

$query = "SELECT * FROM users ORDER BY FNAME ASC";
$queryy = mysqli_query($con,$query);

$totalUsers = mysqli_num_rows($queryy);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible"
content="IE=edge">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>CaRs | Admin Users</title>

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

/* WRAPPER */

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

/* LOGO */

.logo{

    color:#ff7200;

    font-size:34px;

    font-weight:700;
}

.logo span{

    color:white;
}

/* MENU */

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

/* PROFILE BUTTON */

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

    animation:dropdownFade 0.25s ease;
}

/* ANIMATION */

@keyframes dropdownFade{

    from{
        opacity:0;
        transform:translateY(-10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* DROPDOWN HEADER */

.dropdown-header{

    padding:20px;

    border-bottom:
    1px solid rgba(255,255,255,0.06);

    background:
    rgba(255,255,255,0.03);
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

/* DROPDOWN LINKS */

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

    background:
    rgba(255,114,0,0.12);

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

/* TITLE */

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

/* TABLE HEAD */

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

    text-transform:uppercase;

    letter-spacing:1px;
}

/* TABLE BODY */

td{

    padding:18px;

    text-align:center;

    font-size:14px;

    color:#333;

    border-bottom:1px solid #f1f1f1;
}

tbody tr{

    transition:0.3s ease;
}

tbody tr:hover{

    background:#fff7f1;
}

/* USER AVATAR */

.user-avatar{

    width:55px;
    height:55px;

    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    margin:auto;

    background:
    linear-gradient(
    135deg,
    #ff7200,
    #ff9500
    );

    color:white;

    font-size:20px;
    font-weight:600;
}

/* GENDER */

.gender{

    padding:8px 14px;

    border-radius:50px;

    font-size:12px;

    font-weight:600;

    display:inline-block;
}

.male{

    background:rgba(0,123,255,0.15);

    color:#007bff;
}

.female{

    background:rgba(255,20,147,0.15);

    color:#ff1493;
}

/* ACTIONS */

.actions{

    display:flex;
    justify-content:center;

    gap:10px;
}

/* DELETE BUTTON */

.delete-btn{

    background:#dc3545;

    color:white;

    text-decoration:none;

    padding:10px 16px;

    border-radius:12px;

    cursor:pointer;

    transition:0.3s ease;

    display:flex;
    align-items:center;

    gap:8px;
}

.delete-btn:hover{

    background:#b02a37;
}

/* RESPONSIVE */

@media(max-width:950px){

    .navbar{

        flex-direction:column;

        gap:18px;
    }

    .menu ul{

        flex-wrap:wrap;

        justify-content:center;
    }

    .header{

        flex-direction:column;

        align-items:flex-start;
    }

    .title h1{

        font-size:38px;
    }
}

@media(max-width:650px){

    body{

        padding:12px;
    }

    .navbar{

        padding:18px;
    }

    .title h1{

        font-size:30px;
    }

    .container{

        padding:18px;
    }
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
                <a href="adminvehicle.php">

                    Vehicles

                </a>
            </li>

            <li>
                <a href="adminusers.php"
                class="active">

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

        <!-- DROPDOWN -->

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

            User <span>Management</span>

        </h1>

        <p>

            Manage registered users inside the rental system.

        </p>

    </div>

    <div class="stats">

        <div class="stat-card">

            <h2>

                <?php echo $totalUsers; ?>

            </h2>

            <p>

                Total Users

            </p>

        </div>

    </div>

</div>

<!-- CONTAINER -->

<div class="container">

    <div class="top-bar">

        <h2>

            Registered Users

        </h2>

    </div>

    <!-- TABLE -->

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>User</th>
                    <th>Email</th>
                    <th>License</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

            <?php while($res=mysqli_fetch_array($queryy)){ ?>

            <tr>

                <td>

                    <div class="user-avatar">

                        <?php
                        echo strtoupper(
                        substr(
                        $res['FNAME'],
                        0,
                        1
                        ));
                        ?>

                    </div>

                    <br>

                    <?php
                    echo $res['FNAME']
                    ." ".
                    $res['LNAME'];
                    ?>

                </td>

                <td>

                    <?php echo $res['EMAIL']; ?>

                </td>

                <td>

                    <?php echo $res['LIC_NUM']; ?>

                </td>

                <td>

                    <?php echo $res['PHONE_NUMBER']; ?>

                </td>

                <td>

                <?php if(
                strtolower($res['GENDER']) == 'male'
                ){ ?>

                    <span class="gender male">

                        Male

                    </span>

                <?php }else{ ?>

                    <span class="gender female">

                        Female

                    </span>

                <?php } ?>

                </td>

                <td>

                    <div class="actions">

                        <a class="delete-btn"

                        href="deleteuser.php?id=<?php echo $res['EMAIL']; ?>"

                        onclick="return confirmDelete('<?php echo $res['FNAME']." ".$res['LNAME']; ?>')">

                            <i class="fa-solid fa-trash"></i>

                            Delete

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

/* CLOSE DROPDOWN */

window.onclick = function(e){

    if(!e.target.closest('.profile')){

        document.getElementById(
        "dropdownMenu"
        ).style.display = "none";
    }
}

/* DELETE CONFIRM */

function confirmDelete(name){

    return confirm(
    "Are you sure you want to delete user "
    + name + "?"
    );
}

/* LOGOUT CONFIRM */

function confirmLogout(){

    if(confirm(
    "Are you sure you want to logout?"
    )){

        window.location.href =
        "index.php";
    }
}

</script>

</body>
</html>