<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Sales Portal</title>
</head>
<body>
    <div class="list-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['salesli'])) && ($_SESSION['salesli'] != "false")) {
        $sales = $_SESSION['salesli'];
        echo "Your last collect was on ". convertToDate(getSalesLastCollect($db, $sales));
        echo "<br><br>Your credit is ". getSalesTotalCollect($db, $sales) . " EGP";
    ?>
    <br><br>
    <h2>Users</h2>
    <table class="rep-table">
        <thead><th>Vendor</th><th>Phone Number</th><th>E-mail</th></thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM vendors";
                $result = mysqli_query($db, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr><td>' . $row['name'] . '</td><td>' . $row['number'] . '</td><td>' . $row['vendor'] . '</td></tr>';
                }
            ?>
        </tbody>
    </table>
    <br><br>
    <h2>Vendors</h2>
    <table class="rep-table">
        <thead></th><th>Name</th><th>Phone Number</th><th>E-mail</th></thead>
            <tbody>
                <?php
                    $sql2 = "SELECT * FROM users";
                    $result2 = mysqli_query($db, $sql2);
                    while($row2 = mysqli_fetch_assoc($result2)) {
                        echo '<tr><td>' . $row2['fname'] . " " . $row2['lname'] . '</td><td>' . $row2['number'] . '</td><td>' . $row2['user'] . '</td></tr>';
                    }
                ?>
            </tbody>
    </table>
    <br><br>
    <h2>Reservations</h2>
    <table class="rep-table">
        <thead><th>User</th><th>Vendor</th><th>No Show</th><th>Cancelled</th><th>Promo code Applied</th><th>Product</th><th>Slots</th><th>Fee</th></thead>
        <tbody>
            <?php
                getMonitoringReservations($db)
            ?>
        </tbody>
    </table>
    </div></div>
    <?php 
    } else {
        header("Location: ../publicside/signinpage.php");
    }
    ?> 
</body>
</html>