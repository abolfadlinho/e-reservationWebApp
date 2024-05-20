<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>My Reservations</title>
</head>
<body>
    <div class="big-wrapper">
    <?php include "../restricted/config.php" ?>
    <div class="small-wrapper">
    <?php
    if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false")) {
        $user = $_SESSION['userli'];
        echo "<h1>Upcoming Reservations</h1>";
        futureRes($db, $user);
        if(isset($_POST['apply'])) {
            $code = $_POST['code']; 
            $product = $_POST['apply'];
            $success = false;
            if(validPromo($db, $product, $code)) {
                $success = true;
                $discount = substr($code, 4, 2) / 100;
                $currentDate = getCurrentTimeSlot();
                $sql = $db->query("SELECT * FROM `reservations` WHERE ((`user` = '$user') AND (`product_id` = '$product') AND (`slot` > '$currentDate'))");
                $saved = 0;
                while($row = $sql->fetch_assoc()) {
                    $newPrice = $row['price_of_slot'] - ($discount * $row['price_of_slot']);
                    $id = $row['reservation_id'];
                    $saved += $discount * $row['price_of_slot'];
                    $db->query("UPDATE `reservations` SET `price_of_slot` = $newPrice, `promo_applied` = 1 WHERE `reservation_id` = '$id'");
                }
                $_SESSION['promo'] = $saved;
                echo "<script>window.location.href = 'promo.php';</script>";
            }
        }
        if(isset($_POST['cancel'])) {
            $resid = $_POST['cancel'];
            $slot = getFirstSlot($db, $resid);
            $successc = false;
            if(validCancellation($slot)) {
                $successc = true;
                $db->query("UPDATE `reservations` SET `cancelled` = 1 WHERE `reservation_id` = '$resid'");
                echo "<script>window.location.href = 'myReservations.php';</script>";
            }
        }
        userNoShow($db, $user);
        echo "<h1>Past Reservations</h1>";
        pastRes($db, $user);
        if(isset($_POST['1']) && !userIsBlocked($db, $user)) {
            $id = $_POST['1'];
            $db->query("UPDATE `reservations` SET `rating` = 1 WHERE `reservation_id` = '$id'");
            $_SESSION['rated'] = 1;
            if(isset($_SESSION['rated']))
                echo "<script>window.location.href = 'rated.php';</script>";
        }
        if(isset($_POST['2']) && !userIsBlocked($db, $user)) {
            $id = $_POST['2'];
            $db->query("UPDATE `reservations` SET `rating` = 2 WHERE `reservation_id` = '$id'");
            $_SESSION['rated'] = 2;
            if(isset($_SESSION['rated'])) {
                echo "<script>window.location.href = 'rated.php';</script>";
            }
        }
        if(isset($_POST['3']) && !userIsBlocked($db, $user)) {
            $id = $_POST['3'];
            $db->query("UPDATE `reservations` SET `rating` = 3 WHERE `reservation_id` = '$id'");
            $_SESSION['rated'] = 3;
            if(isset($_SESSION['rated'])) {
                echo "<script>window.location.href = 'rated.php';</script>";
            }
        }
        if(isset($_POST['4']) && !userIsBlocked($db, $user)) {
            $id = $_POST['4'];
            $db->query("UPDATE `reservations` SET `rating` = 4 WHERE `reservation_id` = '$id'");
            $_SESSION['rated'] = 4;
            if(isset($_SESSION['rated'])) {
                echo "<script>window.location.href = 'rated.php';</script>";
            }
        }
        if(isset($_POST['5']) && !userIsBlocked($db, $user)) {
            $id = $_POST['5'];
            $db->query("UPDATE `reservations` SET `rating` = 5 WHERE `reservation_id` = '$id'");   
            $_SESSION['rated'] = 5;
            if(isset($_SESSION['rated'])) {
                echo "<script>window.location.href = 'rated.php';</script>";
            }
        }
    } else {
        header("Location: signinpage.php");
    }
    echo '</div></div>';
    ?>
</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>