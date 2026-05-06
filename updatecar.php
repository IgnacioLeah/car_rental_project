<?php
require_once('connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $id = $_POST['car_id'];
    $name = $_POST['car_name'];
    $fuel = $_POST['fuel_type'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $available = $_POST['available'];

    $query = "UPDATE cars 
              SET 
              CAR_NAME='$name',
              FUEL_TYPE='$fuel',
              CAPACITY='$capacity',
              PRICE='$price',
              AVAILABLE='$available'
              WHERE CAR_ID='$id'";

    $result = mysqli_query($con, $query);

    if($result){
        echo "<script>
        alert('Car updated successfully!');
        window.location='adminvehicle.php';
        </script>";
    }
    else{
        echo "<script>
        alert('Update failed!');
        window.location='adminvehicle.php';
        </script>";
    }
}
?>