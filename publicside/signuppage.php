<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="big-wrapper">
    <?php include "../restricted/config.php";?>
    <div class="small-wrapper">
    <form method="POST" class="signinform">
        <h2>Sign up!</h2>
        <input type="text" name="fname" placeholder="First Name" required minlength="3" maxlength="20">
        <input type="text" name="lname" placeholder="Last Name" required minlength="3" maxlength="20">
        <h6>*Both First name and Last name can only contain alphabetical characters.</h6>
        <input type="email" name="user" placeholder="E-mail" required minlength="10" maxlength="40">
        <h6>*Can only be of the following domains: @yahoo.com, @gmail.com and @hotmail.com .</h6>
        <input type="text" name="number" placeholder="Phone Number" required minlength="11" maxlength="11">
        <h6>*11 digit format.</h6>
        <h6>*Can only start with 010, 011, 012 or 015.</h6>
        <input type="password" name="pass" placeholder="Password" required minlength="10" maxlength="20">
        <input type="password" name="rpass" placeholder="Confirm Password" required minlength="10" maxlength="20">
        <h6>*Must have at least 1 uppercase character, 1 lowercase character, a symbol and a digit.</h6>
        <h6>*Cannot be similar to email.</h6><br>
        I agree to the <a href="terms.php">Terms & Conditions</a><input type="checkbox" required> 
        <input type="submit" name="submit" value="Sign Up">
    </form>
    <?php 
    if(isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $rpass = $_POST['rpass'];
        $num = $_POST['number'];
        $ret = validSignUp($db, $pass, $rpass, $user, $num, $fname, $lname);
        if($ret == "") {
            addUser($db, $fname, $lname, $user, $pass, $rpass, $num);
            $_SESSION['userli'] != $user;
            $_SESSION['code'] = password_hash("123456", PASSWORD_DEFAULT);
            $_SESSION['usernotverified'] = $user;  
            $_SESSION['numbernotverified'] = $num; 
            $success = true;    
            if($success)
                echo "<script>window.location.href = 'midlands.php';</script>";
        } else {
            echo "<script>alert('". $ret . "');</script>";
            echo "<script>window.location.href = 'signuppage.php';</script>";
        }
    }
    ?>
    </div>
    </div>
</body>
</html>