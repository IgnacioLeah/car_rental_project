<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMIN USERS | CaRs</title>

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

/* DARK OVERLAY */
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

/* MAIN CONTAINER */
.container{
    width:90%;
    margin:30px auto;
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

tbody tr:hover{
    background:#ffe0c2;
}

/* DELETE BUTTON */
.delete-btn{
    background:red;
    color:#fff;
    padding:6px 10px;
    border-radius:5px;
    text-decoration:none;
}

.delete-btn:hover{
    background:darkred;
}

</style>

</head>

<body>

<?php
require_once('connection.php');
$query="SELECT * FROM users";
$queryy=mysqli_query($con,$query);
?>

<!-- NAVBAR -->

<div class="navbar">
    <div class="logo">CaRs Admin</div>

<div class="menu">
    <ul>
        <li><a href="adminvehicle.php">Vehicles</a></li>
        <li><a href="adminusers.php" class="active">Users</a></li>
        <li><a href="admindash.php">Feedbacks</a></li>
    </ul>
</div>

<!-- PROFILE -->
<div class="profile">
    <div class="profile-btn" onclick="toggleMenu()">👤 Admin ⬇️</div>

    <div class="dropdown" id="dropdownMenu">
            <a href="#" onclick="confirmLogout()">🚪 Logout</a>
    </div>
</div>

</div>

<!-- CONTENT -->

<div class="container">

<div class="header">
    <h1>User Management</h1>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
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
            <td><?php echo $res['FNAME']." ".$res['LNAME']; ?></td>
            <td><?php echo $res['EMAIL']; ?></td>
            <td><?php echo $res['LIC_NUM']; ?></td>
            <td><?php echo $res['PHONE_NUMBER']; ?></td>
            <td><?php echo $res['GENDER']; ?></td>
            <td>
                <a class="delete-btn" 
                   href="deleteuser.php?id=<?php echo $res['EMAIL']; ?>" 
                   onclick="return confirmDelete('<?php echo $res['FNAME']." ".$res['LNAME']; ?>')">
                    Delete
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

</div>

<!-- SCRIPTS -->

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

function confirmDelete(name){
    return confirm("Are you sure you want to delete user " + name + "?");
}

/* ✅ LOGOUT CONFIRM */
function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "index.php";
    }
}
</script>

</body>
</html>