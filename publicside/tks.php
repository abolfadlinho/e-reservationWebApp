<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Change My Password</title>
</head>
<body>
    <div class="biggest-wrapper">
    <?php 
    include "../restricted/config.php";
    $user = "";
    $type = "";
    if(((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false") )) {
        $user = $_SESSION['adminli'];
        $type = "admin";
    } elseif (((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false") )) {
        $user = $_SESSION['vendorli'];
        $type = "vendor";
    } elseif (((isset($_SESSION['repli'])) && ($_SESSION['repli'] != "false") )) {
        $user = $_SESSION['repli'];
        $type = "rep";
    } elseif (((isset($_SESSION['salesli'])) && ($_SESSION['salesli'] != "false") )) {
        $user = $_SESSION['salesli'];
        $type = "sales";
    } elseif (((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") )) {
        $user = $_SESSION['userli'];
        $type = "user";
    } else {
        echo "<script>window.location.href='menu.php'</script>";
    }
    ?>
    <br><br>
    <div class="small-wrapper">
        <form method="POST" class="signinform">
            <h2>Change Password</h2>
            <input type="password" name="old" placeholder="Old Password" required minlength="10" maxlength="20">
            <input type="password" name="pass" placeholder="New Password" required minlength="10" maxlength="20">
            <input type="password" name="repass" placeholder="Re-enter New Password" required minlength="10" maxlength="20">
            <input type="submit" name="submit" value="Change Password">
        </form>
    </div>
    <?php
    if($type != "") {
        if(isset($_POST['submit'])) {
            $old = $_POST['old'];
            $pass = $_POST['pass'];
            $repass = $_POST['repass'];
            switch ($type):
                case "admin": $sql = $db->query("SELECT `password` FROM `admins` WHERE `id` ='$user'"); break;
                case "vendor": $sql = $db->query("SELECT `password` FROM `vendors` WHERE `vendor` ='$user'"); break;
                case "rep": $sql = $db->query("SELECT `password` FROM `reps` WHERE `id` ='$user'"); break;
                case "sales": $sql = $db->query("SELECT `password` FROM `sales` WHERE `sales` ='$user'"); break;
                case "user": $sql = $db->query("SELECT `password` FROM `users` WHERE `user` ='$user'"); break;
            endswitch;
            $row = $sql->fetch_assoc();
            if(password_verify($old, $row['password']) && ($pass == $repass) && validPassword($pass) && ($old != $pass)) {
                switch ($type):
                    case "admin": $sql = $db->query("UPDATE `admins` SET `password` = '".password_hash($pass, PASSWORD_DEFAULT)."' WHERE `id` ='$user'"); break;
                    case "vendor": $sql = $db->query("UPDATE `vendors` SET `password` = '".password_hash($pass, PASSWORD_DEFAULT)."' WHERE `vendor` ='$user'"); break;
                    case "rep": $sql = $db->query("UPDATE `reps` SET `password` = '".password_hash($pass, PASSWORD_DEFAULT)."' WHERE `id` ='$user'"); break;
                    case "sales": $sql = $db->query("UPDATE `sales` SET `password` = '".password_hash($pass, PASSWORD_DEFAULT)."' WHERE `sales` ='$user'"); break;
                    case "user": $sql = $db->query("UPDATE `users` SET `password` = '".password_hash($pass, PASSWORD_DEFAULT)."' WHERE `user` ='$user'"); break;
                endswitch;
                echo "<script>alert('Password Changed Successfully!')</script>";
                switch ($type):
                    case "admin": echo "<script>window.location.href='../adminSide/ourFinancials.php'</script>"; break;
                    case "vendor": echo "<script>window.location.href='../vendorside/vendorFinancials.php'</script>"; break;
                    case "rep": echo "<script>window.location.href='../repside/rep.php'</script>"; break;
                    case "sales": echo "<script>window.location.href='../salesside/sales.php'</script>"; break;
                    case "user": echo "<script>window.location.href='index.php'</script>"; break;
                endswitch;
            } else {
                echo "<script>alert('Password Change Failed!')</script>";
            }

        }
        echo '</div>';
    } else 
        echo "<script>window.location.href='index.php'</script>";
    ?>
</body>
</html>