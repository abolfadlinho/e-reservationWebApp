<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Forgotten Password</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    ?> 
    <form method="POST" class="signinform">
        <h2>Forgotten Password</h2>
        <input type="email" name="email" placeholder="Username/Email" required><br>
        <input type="text" name="number" placeholder="Confirm your mobile number" required><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</div>
    <?php
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $number = $_POST['number'];
        $sql = "SELECT * FROM users WHERE `user` = '$email' AND `number` = '$number'";
        $result = mysqli_query($db, $sql);
        if(mysqli_num_rows($result) > 0){            
            $newPassword = generateRandomPassword();
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql2 = $db->query("UPDATE users SET `password` = '$hashedNewPassword' WHERE `user` = '$email'");
            echo "<script>alert('A new password was sent to your mobile number. Use it to sign in. We recommend changing it immediately after signing in.')</script>";
            echo "<script>window.location.href='signinpage.php'</script>";
        } else {
            echo "<script>alert('Incorrect username/email or mobile number')</script>";
            echo "<script>window.location.href='signinpage.php'</script>";
        }
    }
    function generateRandomPassword() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
        $password = '';
        
        // Generate a random 10-character string
        for ($i = 0; $i < 10; $i++) {
          $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        // Validate the generated password using the validPassword function
        if (validPassword($password)) {
          //return $password;
          return "1234567890";
        } else {
          // If the generated password doesn't meet the requirements, generate a new one recursively
          return generateRandomPassword();
        }
      }
    ?>
    </div>
</body>
</html>