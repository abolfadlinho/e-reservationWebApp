<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>More</title>
</head>
<body>
        <?php include "../restricted/config.php"; ?>
        <div class="small-wrapper">
            <br><br>
            <a href="customerservice.php">Customer Service</a><hr>
            <a href="aboutus.php">About Us</a><hr>
            <a href="contactus.php">Contact Us</a><hr>
            <a href="faq.php">FAQ</a><hr>
            <a href="privacy.php">Privacy Policy</a><hr>
            <a href="terms.php">Terms & Conditions</a><hr>
            <?php if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false")){ ?>
                <a href="../logout.php">Logout</a><hr>
                <a href="tks.php">Change my Password</a>
                <?php if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") && userIsBlocked($db, $_SESSION['userli'])) 
                    echo '<br><h6>You are blocked from making reservations due to not showing on multiple occassions.</h6>'; ?>
            <?php } ?>
        </div>
</body>
</html>