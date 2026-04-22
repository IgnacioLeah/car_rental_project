<!DOCTYPE html>
<html>
<head>
    <title>Feedback | CaRs</title>
    <link rel="stylesheet" href="Stylesheet.css">
</head>

<body class="feedback-body">

<?php
require_once('../connection.php');
session_start();

$email = $_SESSION['email'];

if(isset($_POST['submit'])){
    $comment=mysqli_real_escape_string($con,$_POST['comment']);
    $sql="INSERT INTO feedback (EMAIL,COMMENT) VALUES('$email','$comment')";
    mysqli_query($con,$sql);

    echo "<script>alert('Feedback Sent Successfully!'); window.location='../cardetails.php';</script>";
}
?>

<a href="../cardetails.php" class="back-btn">← Back</a>

<div class="feedback-card">

    <h1>Give Your Feedback</h1>

    <form method="POST">

        <div class="input-group">
            <label>Email</label>
            <input type="email" value="<?php echo $email; ?>" disabled>
        </div>

        <div class="input-group">
            <label>Your Feedback</label>
            <textarea name="comment" placeholder="Write something..." required></textarea>
        </div>

        <button type="submit" name="submit">Submit</button>

    </form>

</div>

</body>
</html>