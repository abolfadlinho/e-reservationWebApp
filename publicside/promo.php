<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Promo Applied</title>
</head>
<body>
    <div class="big-wrapper">
        <?php include "../restricted/config.php"; 
            if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") && (isset($_SESSION['promo'])) && ($_SESSION['promo'] != 0)) {

        ?>
        <div class="small-wrapper">
            <br><br>
            <h1>Promo Applied!</h1>
            <h2>You just saved <?php echo $_SESSION['promo']?> EGP</h2>
            <h3>Have fun!</h3>
            <br><br>
            <a href="myReservations.php"><button>My Reservations</button></a>
        </div>
        <?php } else {
            echo "<script>window.location.href = 'index.php';</script>";
        } ?>
    </div>
</body>
</html>