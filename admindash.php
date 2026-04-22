<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMIN FEEDBACKS | CaRs</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* BACKGROUND */
body{
    height:100vh;
    overflow:hidden;
    background:url("../images/carbg2.jpg") no-repeat center/cover;
}

/* OVERLAY */
body::before{
    content:'';
    position:absolute;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    z-index:-1;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px 50px;
    background:rgba(0,0,0,0.7);
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

/* PROFILE */
.profile{
    position:relative;
}

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

/* DASHBOARD */
.dashboard{
    display:flex;
    gap:20px;
    justify-content:center;
    margin:20px;
}

.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:15px;
    border-radius:10px;
    width:220px;
    text-align:center;
    color:#fff;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card img{
    width:100%;
    height:120px;
    object-fit:cover;
    border-radius:8px;
    margin-bottom:10px;
}

.card h3{
    color:#ff7200;
}

/* CONTAINER */
.container{
    width:90%;
    margin:20px auto;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:20px;
    border-radius:10px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:8px;
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

</style>

</head>

<body>

<?php
require_once('connection.php');

/* FEEDBACK DATA */
$feedbackQuery="SELECT * FROM feedback";
$feedbackData=mysqli_query($con,$feedbackQuery);

$topCarsQuery = "
SELECT cars.CAR_NAME, cars.CAR_IMG, COUNT(booking.CAR_ID) as total
FROM booking
JOIN cars ON booking.CAR_ID = cars.CAR_ID
GROUP BY booking.CAR_ID
ORDER BY total DESC
LIMIT 3
";

$topCars=mysqli_query($con,$topCarsQuery);
?>

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
        <a href="index.php">Logout</a>
    </div>
</div>

</div>

<!-- DASHBOARD -->

<div class="dashboard">
<?php while($row=mysqli_fetch_assoc($topCars)){ ?>
    <div class="card">

        <!-- IMAGE -->
        <?php
            $image = !empty($row['CAR_IMG']) ? $row['CAR_IMG'] : 'default.png';
            ?>

            <img src="../images/<?php echo $image; ?>" 
                alt="Car Image"
                onerror="this.src='../images/default.png'">

        <!-- NAME -->
        <h3><?php echo $row['CAR_NAME']; ?></h3>

        <!-- BOOKINGS -->
        <p>⭐ Booked: <?php echo $row['total']; ?> times</p>

    </div>
<?php } ?>

</div>

<!-- FEEDBACK TABLE -->

<div class="container">
    <h1 style="color:#fff; margin-bottom:15px;">Feedback Management</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Comment</th>
        </tr>
    </thead>

    <tbody>
    <?php while($res=mysqli_fetch_array($feedbackData)){ ?>
        <tr>
            <td><?php echo $res['FED_ID']; ?></td>
            <td><?php echo $res['EMAIL']; ?></td>
            <td><?php echo $res['COMMENT']; ?></td>
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