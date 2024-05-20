<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Manage Representatives</title>
</head>
<body> 
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper" id="vendorreps">';
    if((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false")) {
        $vendor = $_SESSION['vendorli'];
    ?>
        <form method="POST" class="signinform">
            <h2>Add Representative</h2>
            <input type="email" name="rep" placeholder="E-mail" required minlength="10" maxlength="40">
            <input type="password" name="pass" placeholder="Password" required minlength="10" maxlength="20">
            <input type="password" name="repass" placeholder="Re-enter Password" required minlength="10" maxlength="20">
            <input type="submit" name="add" value="Add">
        </form>
        <form method="POST">
            <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="remove"></th><th>Representative</th></tr></thead><tbody>
            <?php 
            getRepsTable($db, $vendor);
            ?>
            </tbody></table>
        </form>
        <?php 
        if(isset($_POST['add'])) {
            $rep = $_POST['rep'];
            $pass = $_POST['pass'];
            $repass = $_POST['repass'];
            if(validRep($db, $user, $pass, $repass) == "")
                addRep($db, $rep, $pass, $vendor);
            else {
                echo "<script>alert('".validRep($db, $user, $pass, $repass)."');</script>";
                echo "<script>window.location.href = 'manageReps.php';</script>";            }
        }
        if(isset($_POST['remove']) && isset($_POST['id'])) {
            $reps = $_POST['id'];
            removeReps($db, $reps);
        }
    } else {
        header("Location: ../publicside/signinpage.php");
    }
    ?>
    </div></div>
</body>
</html>