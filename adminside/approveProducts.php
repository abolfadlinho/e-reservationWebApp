<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Approve Products</title>
</head>
<body>
    <div class="big-wrapper">
<?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
        getProdNotAppr($db);
        if(isset($_POST['approve']) && isset($_POST['id'])) {
            $selected = $_POST['id'];
            approveProducts($db, $selected);
            $done = true;
            if($done) {
                echo '<script>alert("Product approved successfully!");</script>';
                echo '<script>window.location.href = "approveProducts.php";</script>';
            }
        }
        if(isset($_POST['reject']) && isset($_POST['id'])) {
            $selectedr = $_POST['id'];
            rejectProducts($db, $selectedr);
            $done = true;
            if($done) {
                echo '<script>alert("Product approved successfully!");</script>';
                echo '<script>window.location.href = "approveProducts.php";</script>';
            }
        }
    } else {
        $done = true;
        if($done)
            echo "<script>window.location.href = 'signinpage.php';</script>";
    }?>
    </div></div>
</body>
</html>