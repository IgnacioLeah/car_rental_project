<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $con = new mysqli("localhost", "root", "", "carproject");
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>