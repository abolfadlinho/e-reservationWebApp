<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change My Password</title>
</head>
<body>
    <?php 
    include "../restricted/config.php";
    if(((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false") ) || ((isset($_SESSION['repli'])) && ($_SESSION['repli'] != "false") ) || ((isset($_SESSION['salesli'])) && ($_SESSION['salesli'] != "false") ) || ((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") ) || ((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false") )) {
        ?> 
        <form method="POST">
            <input type="password" name="old" placeholder="Old Password" required minlength="10" maxlength="20">
            <input type="password" name="new" placeholder="New Password" required minlength="10" maxlength="20">
            <input type="password"name="re" placeholder="Re-enter New Password" required minlength="10" maxlength="20">
            <input type="submit" value="Change" name="change" required>
        </form>
        <?php
        if(isset($_POST['change'])) {
            $old = $_POST['old'];
            $new = $_POST['new'];
            $re = $_POST['re'];
            if($_SESSION['adminli'] != "false") {
                $id = $_SESSION['adminli'];
                changeMyPassword($db, "admins", $old, $new, $re, $id);
            }
            if($_SESSION['vendorli'] != "false") {
                $id = $_SESSION['vendorli'];
                changeMyPassword($db, "vendors", $old, $new, $re, $id);
            }
            if($_SESSION['repli'] != "false") {
                $id = $_SESSION['repli'];
                changeMyPassword($db, "reps", $old, $new, $re, $id);
            }
            if($_SESSION['salesli'] != "false") {
                $id = $_SESSION['salesli'];
                changeMyPassword($db, "sales", $old, $new, $re, $id);
            }
            if($_SESSION['userli'] != "false") {
                $id = $_SESSION['userli'];
                changeMyPassword($db, "users", $old, $new, $re, $id);
            }
        }
    } else {
        header("Location: signinpage.php");
    }
    ?>
</body>
</html>