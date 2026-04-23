<?php
session_start();
require_once('../connection.php');

/* PROTECT PAGE */
if(!isset($_SESSION['email'])){
    header("Location: ../index.php");
    exit();
}

$email = $_SESSION['email'];

/* SUBMIT FEEDBACK */
if(isset($_POST['submit'])){
    $comment = mysqli_real_escape_string($con, $_POST['comment']);

    if(empty($comment)){
        echo "<script>alert('Please enter feedback');</script>";
    } else {
        $sql="INSERT INTO feedback (EMAIL, COMMENT) 
              VALUES('$email','$comment')";

        if(mysqli_query($con,$sql)){
            echo "<script>
                    alert('Feedback Sent Successfully!');
                    window.location='../cardetails.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Error submitting feedback');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback | CaRs</title>
    <link rel="stylesheet" href="Stylesheet.css">
</head>

<body class="feedback-body">

<a href="../cardetails.php" class="back-btn">← Back</a>

<div class="feedback-card">

    <h1>Give Your Feedback</h1>

    <form method="POST">

        <div class="input-group">
            <label>Email</label>
            <!-- ✅ SAFE OUTPUT -->
            <input type="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
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