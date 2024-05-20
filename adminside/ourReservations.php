<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>All Time Reservations</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
        ?> 
        <form method="POST">
            <input type="submit" name="export" value="Export to Excel" class="exportbtn">
        </form>
        <?php
        if(isset($_POST["export"])){
            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=reservationsreport.xls');
        }
        ourReservations($db);
    } else {
        header("Location: signinpage.php");
    }
    ?>
    </div></div>
</body>
</html>