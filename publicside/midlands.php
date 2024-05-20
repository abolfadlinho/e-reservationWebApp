<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Verify</title>
</head>
<body>
    <div class="big-wrapper">
        <?php 
        include "../restricted/config.php";
        if(isset($_SESSION['usernotverified'])) {
        $code = $_SESSION['code'];
        $number = $_SESSION['numbernotverified'];
        ?>
        <div class="small-wrapper">
            <form method="POST" class="signinform">
                <h2>Verify your account!</h2>
                <h3>A 6-character verification code has been sent to <?php echo $number ?> on WhatsApp.</h3>
                <h4>If you do not enter your verification code now you will need to contact 7agz in order to verify your account.</h4>
                <input type="text" name="code" placeholder="Verification Code" required minlength="6" maxlength="6">
                <input type="submit" name="submit" value="Verify">
            </form>
            <?php 
            if(isset($_POST['submit'])) {
                $codein = $_POST['code'];
                if(password_verify($codein, $code)) {
                    $user = $_SESSION['usernotverified'];
                    $db->query("UPDATE `users` SET `verified` = 1 WHERE `user` = '$user'");
                    $_SESSION['userli'] = $user;
                    echo "<script>alert('Account verified!');</script>";
                    $done = true;
                    $_SESSION['usernotverified'] = null;
                    if($done)
                        echo "<script>window.location.href = 'index.php';</script>";
                } else {
                    echo "<script>alert('Wrong code!');</script>";
                    echo "<script>window.location.href = 'midlands.php';</script>";
                }   
            }
            ?>
        </div>
        <?php 
        } else {
            echo "<script>window.location.href = 'index.php';</script>";
        }
        ?>
    </div>
</body>
</html>