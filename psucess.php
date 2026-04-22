<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Success</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

/* 🔥 FULL BACKGROUND */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:url("images/ps.png") no-repeat center/cover;
    position:relative;
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

/* GLASS CARD */
.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(15px);
    padding:50px 40px;
    border-radius:15px;
    text-align:center;
    color:#fff;
    box-shadow:0 10px 30px rgba(0,0,0,0.6);
    animation:fadeIn 0.8s ease;
}

/* CHECK ICON */
.circle{
    width:150px;
    height:150px;
    border-radius:50%;
    background:rgba(255,255,255,0.1);
    margin:0 auto 20px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.checkmark{
    font-size:70px;
    color:#4CAF50;
}

/* TEXT */
h1{
    font-size:32px;
    margin-bottom:10px;
    color:#4CAF50;
}

p{
    font-size:16px;
    color:#ddd;
    margin-bottom:25px;
}

/* BUTTON */
.btn{
    display:inline-block;
    padding:12px 25px;
    background:#ff7200;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

.btn:hover{
    background:#e65c00;
    transform:scale(1.05);
}

/* ANIMATION */
@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}
</style>
</head>

<body>

<div class="card">

    <div class="circle">
        <div class="checkmark">✓</div>
    </div>

    <h1>Payment Successful</h1>

    <p>Your booking has been confirmed.<br>
    Thank you for choosing our service!</p>

    <a href="cardetails.php" class="btn">Browse Cars</a>

</div>

</body>
</html>