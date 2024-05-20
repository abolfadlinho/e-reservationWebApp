<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Rating Submitted</title>
</head>
<body>
    <div class="big-wrapper">
        <?php include "../restricted/config.php"; 
            if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") && (isset($_SESSION['rated'])) && ($_SESSION['rated'] != 0)) {

        ?>
        <div class="small-wrapper">
            <br><br>
            <img src="../media/tick.png" alt="tick" width="150px" height="150px">
            <h1>Rating Submitted!</h1>
            <h2>Thank you for your contribution</h2>
            <?php 
                if($_SESSION['rated'] < 3) {
                    echo "<h3>We are sorry for your bad experience, we will try to improve. Contact 7agz for complaints.</h3>";
                } else if($_SESSION['rated'] < 5) {
                    echo "<h3>We are glad you enjoyed your time, we will try to improve.</h3>";
                } else {
                    echo "<h3>We are glad you enjoyed your time, we will keep it up.</h3>";
                }
            ?>
            <br><br>
            <a href="myReservations.php"><button>My Reservations</button></a>
        </div>
        <?php } else {
            echo "<script>window.location.href = 'index.php';</script>";
        } ?>
    </div>
</body>
</html>