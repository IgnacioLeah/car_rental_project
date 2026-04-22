<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMIN BOOKINGS | CaRs</title>

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

.menu ul li a:hover{
    color:#ff7200;
}

/* ACTIVE NAV */
.menu ul li a.active{
    color:#ff7200;
    border-bottom:2px solid #ff7200;
    padding-bottom:5px;
}

/* PROFILE */
.profile{
    position:relative;
    z-index:10000;
}

.profile-btn{
    background:#ff7200;
    color:#fff;
    padding:8px 15px;
    border-radius:6px;
    cursor:pointer;
}

/* DROPDOWN */
.dropdown{
    position:absolute;
    top:45px;
    right:0;
    background:#fff;
    width:150px;
    border-radius:6px;
    display:none;
    box-shadow:0 10px 20px rgba(0,0,0,0.3);
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
    width:95%;
    margin:25px auto;
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:20px;
    border-radius:10px;
}

/* HEADER */
.header{
    margin-bottom:20px;
}

.header h1{
    color:#fff;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:8px;
    overflow:hidden;
    font-size:14px;
}

thead{
    background:#ff7200;
    color:#fff;
}

th, td{
    padding:10px;
    text-align:center;
}

tbody tr:nth-child(even){
    background:#f3f3f3;
}

tbody tr:hover{
    background:#ffe0c2;
}

/* BUTTONS */
.btn{
    padding:6px 10px;
    border-radius:5px;
    text-decoration:none;
    color:#fff;
    font-size:13px;
}

.approve{
    background:green;
}

.approve:hover{
    background:darkgreen;
}

.return{
    background:#007bff;
}

.return:hover{
    background:#0056b3;
}

</style>

</head>

<body>

<?php
require_once('connection.php');
$query="SELECT * FROM booking ORDER BY BOOK_ID DESC";    
$queryy=mysqli_query($con,$query);
?>

<!-- NAVBAR -->

<div class="navbar">
    <div class="logo">CaRs Admin</div>

<div class="menu">
    <ul>
        <li><a href="adminvehicle.php">Vehicles</a></li>
        <li><a href="adminusers.php">Users</a></li>
        <li><a href="admindash.php">Feedbacks</a></li>
        <li><a href="adminbook.php" class="active">Bookings</a></li>
    </ul>
</div>

<!-- PROFILE -->
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
    <h1>Booking Requests</h1>
</div>

<table>
    <thead>
        <tr>
            <th>Car ID</th>
            <th>Email</th>
            <th>Place</th>
            <th>Date</th>
            <th>Duration</th>
            <th>Phone</th>
            <th>Destination</th>
            <th>Return</th>
            <th>Status</th>
            <th>Approve</th>
            <th>Returned</th>
        </tr>
    </thead>

<tbody>
<?php while($res=mysqli_fetch_array($queryy)){ ?>
    <tr>
        <td><?php echo $res['CAR_ID']; ?></td>
        <td><?php echo $res['EMAIL']; ?></td>
        <td><?php echo $res['BOOK_PLACE']; ?></td>
        <td><?php echo $res['BOOK_DATE']; ?></td>
        <td><?php echo $res['DURATION']; ?></td>
        <td><?php echo $res['PHONE_NUMBER']; ?></td>
        <td><?php echo $res['DESTINATION']; ?></td>
        <td><?php echo $res['RETURN_DATE']; ?></td>
        <td><?php echo $res['BOOK_STATUS']; ?></td>

        <td>
            <a class="btn approve"
               href="approve.php?id=<?php echo $res['BOOK_ID']; ?>">
               Approve
            </a>
        </td>

        <td>
            <a class="btn return"
               href="adminreturn.php?id=<?php echo $res['CAR_ID']; ?>&bookid=<?php echo $res['BOOK_ID']; ?>">
               Returned
            </a>
        </td>
    </tr>
<?php } ?>
</tbody>

</table>

</div>

<script>
function toggleMenu(){
    let menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

window.onclick = function(e){
    if (!e.target.closest('.profile')) {
        document.getElementById("dropdownMenu").style.display = "none";
    }
}
</script>

</body>
</html>