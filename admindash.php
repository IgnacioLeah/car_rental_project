<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT ADMIN PAGE */
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

/* FEEDBACK DATA */
$feedbackQuery = "SELECT * FROM feedback";
$feedbackData = mysqli_query($con, $feedbackQuery);

/* TOP CARS */
$topCarsQuery = "
SELECT cars.CAR_NAME, cars.CAR_IMG, COUNT(booking.CAR_ID) as total
FROM booking
JOIN cars ON booking.CAR_ID = cars.CAR_ID
GROUP BY booking.CAR_ID
ORDER BY total DESC
LIMIT 3
";
$topCars = mysqli_query($con, $topCarsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMIN FEEDBACKS | CaRs</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}

body{
    min-height:100vh;
    overflow-y:auto;
    background:url("images/carbg2.jpg") no-repeat center/cover;
}

body::before{
    content:'';
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:-1;
}

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    background:rgba(0,0,0,0.8);
}

.logo{
    color:#ff7200;
    font-size:28px;
    font-weight:bold;
}

.menu ul{
    display:flex;
    gap:30px;
}

.menu ul li{
    list-style:none;
}

.menu ul li a{
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

.menu ul li a.active{
    color:#ff7200;
    border-bottom:2px solid #ff7200;
}

.profile{position:relative;}

.profile-btn{
    background:#ff7200;
    color:#fff;
    padding:8px 15px;
    border-radius:6px;
    cursor:pointer;
}

.dropdown{
    position:absolute;
    top:45px;
    right:0;
    background:#fff;
    width:150px;
    border-radius:6px;
    display:none;
}

.dropdown a{
    display:block;
    padding:10px;
    color:#000;
    text-decoration:none;
}

.dropdown a:hover{
    background:#f3f3f3;
}

.dashboard{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    justify-content:center;
    margin:30px;
}

.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:15px;
    border-radius:10px;
    width:220px;
    text-align:center;
    color:#fff;
}

.card img{
    width:100%;
    height:120px;
    object-fit:cover;
    border-radius:8px;
    margin-bottom:10px;
    background:#222;
}

.card h3{
    color:#ff7200;
}

.container{
    width:90%;
    margin:30px auto;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:20px;
    border-radius:10px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:8px;
    overflow:hidden;
}

thead{
    background:#ff7200;
    color:#fff;
}

th, td{
    padding:12px;
    text-align:center;
}

tbody tr:nth-child(even){
    background:#f3f3f3;
}

td{
    max-width:300px;
    word-wrap:break-word;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">CaRs Admin</div>

    <div class="menu">
        <ul>
            <li><a href="adminvehicle.php">Vehicles</a></li>
            <li><a href="adminusers.php">Users</a></li>
            <li><a href="admindash.php" class="active">Feedbacks</a></li>
            <li><a href="adminbook.php">Bookings</a></li>
        </ul>
    </div>

    <div class="profile">
        <div class="profile-btn" onclick="toggleMenu()">👤 Admin ⬇️</div>
        <div class="dropdown" id="dropdownMenu">
            <a href="index.php">🚪 Logout</a>
        </div>
    </div>
</div>

<!-- DASHBOARD -->
<div class="dashboard">
<?php while($row = mysqli_fetch_assoc($topCars)){ ?>
    <div class="card">

        <?php 
        $image = !empty($row['CAR_IMG']) ? $row['CAR_IMG'] : 'default.png';
        ?>

        <img src="images/<?php echo htmlspecialchars($image); ?>"
             onerror="this.src='images/default.png'">

        <h3><?php echo htmlspecialchars($row['CAR_NAME']); ?></h3>
        <p>⭐ Booked: <?php echo $row['total']; ?> times</p>

    </div>
<?php } ?>
</div>

<!-- FEEDBACK TABLE -->
<div class="container">
    <h1 style="color:#fff;">Feedback Management</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Comment</th>
            </tr>
        </thead>

        <tbody>
        <?php if(mysqli_num_rows($feedbackData) > 0){ ?>
            <?php while($res = mysqli_fetch_assoc($feedbackData)){ ?>
                <tr>
                    <td><?php echo $res['FED_ID']; ?></td>
                    <td><?php echo htmlspecialchars($res['EMAIL']); ?></td>
                    <td><?php echo htmlspecialchars($res['COMMENT']); ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="3">No feedback found</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
function toggleMenu(){
    let menu=document.getElementById("dropdownMenu");
    menu.style.display=(menu.style.display==="block")?"none":"block";
}

window.onclick=function(e){
    if(!e.target.closest('.profile')){
        document.getElementById("dropdownMenu").style.display="none";
    }
}
</script>

</body>
</html>