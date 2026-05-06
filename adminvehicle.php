<?php
session_start();
require_once('connection.php');

/* PROTECT ADMIN PAGE */
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

/* BODY */
body{
    min-height:100vh;
    overflow-y:auto;
    background:url("images/carbg2.jpg") no-repeat center/cover;
}

/* OVERLAY */
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
    overflow:hidden;
}

.dropdown a{
    display:block;
    padding:10px;
    color:#000;
    text-decoration:none;
}

.dropdown a:hover{
    background:#f1f1f1;
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

/* TABLE */
.table-wrapper{
    max-height:500px;
    overflow-y:auto;
    border-radius:10px;
}

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

/* IMAGE */
.car-img{
    width:120px;
    height:70px;
    object-fit:cover;
    border-radius:8px;
    background:#222;
    display:block;
    margin:auto;
}

/* BUTTONS */
.edit-btn{
    background:#007bff;
    color:#fff;
    border:none;
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    margin-right:5px;
}

.edit-btn:hover{
    background:#0056b3;
}

.delete-btn{
    background:red;
    color:#fff;
    padding:6px 12px;
    border-radius:6px;
    text-decoration:none;
}

.delete-btn:hover{
    background:darkred;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    z-index:999;
    left:0;
    top:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
}

.modal-content{
    background:#fff;
    width:450px;
    max-width:90%;
    margin:5% auto;
    padding:25px;
    border-radius:12px;
    position:relative;
    animation:popup .3s ease;
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

.modal-content h2{
    margin-bottom:20px;
    color:#ff7200;
}

.modal-content input,
.modal-content select{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:6px;
}

.save-btn{
    background:#28a745;
    color:#fff;
    border:none;
    padding:10px 20px;
    border-radius:6px;
    cursor:pointer;
    width:100%;
    font-size:16px;
}

.save-btn:hover{
    background:#218838;
}

.close{
    position:absolute;
    top:15px;
    right:20px;
    font-size:24px;
    cursor:pointer;
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
        </ul>
    </div>

    <div class="profile">
        <div class="profile-btn" onclick="toggleMenu()">
            👤 Admin ⬇️
        </div>

        <div class="dropdown" id="dropdownMenu">
            <a href="#" onclick="confirmLogout()">🚪 Logout</a>
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

$image = $res['CAR_IMG'];

if(!empty($image) && file_exists("images/".$image)){
    $finalImage = "images/".$image;
}
else if(!empty($image) && file_exists("uploads/".$image)){
    $finalImage = "uploads/".$image;
}
else{
    $finalImage = "images/default.png";
}

?>

<img class="car-img"
src="<?php echo htmlspecialchars($finalImage); ?>"
onerror="this.src='images/default.png';">

</td>

<td><?php echo htmlspecialchars($res['CAR_NAME']); ?></td>

<td><?php echo htmlspecialchars($res['FUEL_TYPE']); ?></td>

<td><?php echo htmlspecialchars($res['CAPACITY']); ?></td>

<td>₱<?php echo number_format($res['PRICE'],2); ?></td>

<td>
<?php echo ($res['AVAILABLE']=='Y') ? 'YES' : 'NO'; ?>
</td>

<td>

<!-- EDIT -->
<button class="edit-btn"
onclick="openEditModal(
'<?php echo $res['CAR_ID']; ?>',
'<?php echo htmlspecialchars($res['CAR_NAME']); ?>',
'<?php echo htmlspecialchars($res['FUEL_TYPE']); ?>',
'<?php echo htmlspecialchars($res['CAPACITY']); ?>',
'<?php echo htmlspecialchars($res['PRICE']); ?>',
'<?php echo htmlspecialchars($res['AVAILABLE']); ?>'
)">
Edit
</button>

<!-- DELETE -->
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

<!-- EDIT MODAL -->
<div id="editModal" class="modal">

<div class="modal-content">

<span class="close" onclick="closeModal()">&times;</span>

<h2>Edit Car</h2>

<form action="updatecar.php" method="POST">

<input type="hidden" name="car_id" id="edit_car_id">

<label>Car Name</label>
<input type="text" name="car_name" id="edit_car_name" required>

<label>Fuel Type</label>
<input type="text" name="fuel_type" id="edit_fuel" required>

<label>Capacity</label>
<input type="number" name="capacity" id="edit_capacity" required>

<label>Price</label>
<input type="number" step="0.01" name="price" id="edit_price" required>

<label>Available</label>
<select name="available" id="edit_available">
    <option value="Y">YES</option>
    <option value="N">NO</option>
</select>

<button type="submit" class="save-btn">
Save Changes
</button>

</form>

</div>
</div>

<script>

// PROFILE MENU
function toggleMenu(){

    let menu=document.getElementById("dropdownMenu");

    menu.style.display=
    (menu.style.display==="block")
    ?"none":"block";
}

// LOGOUT
function confirmLogout(){

    if(confirm("Are you sure you want to logout?")){
        window.location.href="index.php";
    }
}

// CLOSE DROPDOWN
window.onclick=function(e){

    if(!e.target.closest('.profile')){
        document.getElementById("dropdownMenu").style.display="none";
    }

    let modal=document.getElementById("editModal");

    if(e.target==modal){
        closeModal();
    }
}

// OPEN MODAL
function openEditModal(id,name,fuel,capacity,price,available){

    document.getElementById("editModal").style.display="block";

    document.getElementById("edit_car_id").value=id;
    document.getElementById("edit_car_name").value=name;
    document.getElementById("edit_fuel").value=fuel;
    document.getElementById("edit_capacity").value=capacity;
    document.getElementById("edit_price").value=price;
    document.getElementById("edit_available").value=available;
}

// CLOSE MODAL
function closeModal(){

    document.getElementById("editModal").style.display="none";
}

</script>

</body>
</html>