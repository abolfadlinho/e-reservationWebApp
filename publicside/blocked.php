<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Blocked</title>
</head>
<body>
    <div class="big-wrapper">
        <?php include "../restricted/config.php"; 
            if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") && userIsBlocked($db, $_SESSION['userli'])) {

        ?>
        <div class="small-wrapper">
            <br><br>
            <h1>You are Blocked</h1>
            <h2>This account was blocked for not showing up at reservations multiple times.</h2>
            <h3>If you think this was a mistake contact 7agz</h3>
            <br><br>
            <a href="index.php"><button>Home</button></a>
        </div>
        <?php } else {
            echo "<script>window.location.href = 'index.php';</script>";
        } ?>
    </div>
</body>
</html>