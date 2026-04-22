<?php
session_start();
require_once('connection.php');

/* 🔐 PROTECT ADMIN PAGE */
if(!isset($_SESSION['admin'])){
    header("Location: adminlogin.php");
    exit();
}

/* FETCH CARS */
$query = "SELECT * FROM cars";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMIN VEHICLES | CaRs</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* ✅ FIXED BODY */
body{
    min-height:100vh;
    overflow-y:auto;
    background:url("images/carbg2.jpg") no-repeat center/cover;
}

/* ✅ FIXED OVERLAY */
body::before{
    content:'';
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.65);
    z-index:-1;
}

/* NAVBAR */
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

/* PROFILE */
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

/* CONTAINER */
.container{
    width:90%;
    margin:30px auto;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(12px);
    padding:25px;
    border-radius:12px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h1{
    color:#fff;
}

/* ADD BUTTON */
.add{
    background:#ff7200;
    padding:10px 20px;
    border-radius:6px;
}

.add a{
    text-decoration:none;
    color:#fff;
    font-weight:bold;
}

/* TABLE WRAPPER */
.table-wrapper{
    max-height:400px;
    overflow-y:auto;
    border-radius:10px;
}

/* TABLE */
table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    background:#fff;
}

thead{
    background:#ff7200;
    color:#fff;
}

thead th{
    position:sticky;
    top:0;
    z-index:10;
    background:#ff7200;
}

th, td{
    padding:14px;
    text-align:center;
}

tbody tr:nth-child(even){
    background:#f8f8f8;
}

tbody tr:hover{
    background:#ffe4cc;
}

/* ✅ FIXED IMAGE */
.car-img{
    width:120px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
    background:#222;
}

/* DELETE BUTTON */
.delete-btn{
    background:red;
    color:#fff;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">CaRs Admin</div>

    <div class="menu">
        <ul>
            <li><a href="adminvehicle.php" class="active">Vehicles</a></li>
            <li><a href="adminusers.php">Users</a></li>
            <li><a href="admindash.php">Feedbacks</a></li>
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

<!-- CONTENT -->
<div class="container">

<div class="header">
    <h1>Car Management</h1>
    <div class="add">
        <a href="addcar.php">+ Add Car</a>
    </div>
</div>

<div class="table-wrapper">
<table>

<thead>
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Name</th>
    <th>Fuel</th>
    <th>Capacity</th>
    <th>Price</th>
    <th>Available</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
<?php while($res = mysqli_fetch_assoc($result)){ ?>
<tr>

<td><?php echo $res['CAR_ID']; ?></td>

<td>
<?php 
$image = !empty($res['CAR_IMG']) ? $res['CAR_IMG'] : 'default.png';
?>
<img class="car-img"
     src="images/<?php echo htmlspecialchars($image); ?>"
     onerror="this.src='images/default.png'">
</td>

<td><?php echo htmlspecialchars($res['CAR_NAME']); ?></td>
<td><?php echo htmlspecialchars($res['FUEL_TYPE']); ?></td>
<td><?php echo htmlspecialchars($res['CAPACITY']); ?></td>
<td><?php echo htmlspecialchars($res['PRICE']); ?></td>

<td><?php echo ($res['AVAILABLE']=='Y') ? 'YES' : 'NO'; ?></td>

<td>
<a class="delete-btn"
href="deletecar.php?id=<?php echo $res['CAR_ID']; ?>"
onclick="return confirm('Delete <?php echo htmlspecialchars($res['CAR_NAME']); ?>?')">
Delete
</a>
</td>

</tr>
<?php } ?>
</tbody>

</table>
</div>

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