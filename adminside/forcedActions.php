<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forced Actions</title>
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="big-wrapper">
        <?php 
        include "../restricted/config.php" ;
        if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
        ?>
        <div class="small-wrapper">
            <!--Form to remove reps-->
            <form method="POST">
                <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="remove"></th><th>Representative</th><th>Vendor</th></tr></thead><tbody>
                <?php 
                getAllRepsTable($db);
                ?>
                </tbody></table>
            </form>
        </div>
        <?php 
        if(isset($_POST['remove']) && isset($_POST['id'])) {
            $reps = $_POST['id'];
            removeReps($db, $reps);
            $done = true;
            if($done)
                echo "<script>window.location.href = 'forcedActions.php';</script>";
        }
        } else {
            $done = true;
            if($done)
                echo "<script>window.location.href = 'signinpage.php';</script>";
        }
        ?>
    </div>
</body>
</html>