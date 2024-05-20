<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Representative Page</title>
</head>
<body>
    <div class="list-wrapper">
        <?php include "../restricted/config.php"; ?>
        <div class="small-wrapper">
        <?php 
        if((isset($_SESSION['repli'])) && ($_SESSION['repli'] != "false")) {
            $rep = $_SESSION['repli'];
            getRepProducts($db, $rep);
        } else {
            header("Location: ../publicside/signinpage.php");
        }
        ?>
    </div>
    </div>
</body>
</html>