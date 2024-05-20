<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Sign in</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
        include "../restricted/config.php";
        if(((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false") ) || ((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false") ) || ((isset($_SESSION['repli'])) && ($_SESSION['repli'] != "false") ) || ((isset($_SESSION['salesli'])) && ($_SESSION['salesli'] != "false") ) || ((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") )) {
            $_SESSION['adminli'] = "false";
            $_SESSION['vendorli'] = "false";
            $_SESSION['repli'] = "false";
            $_SESSION['salesli'] = "false";
            $_SESSION['userli'] = "false";
            header("Location: ../publicside/index.php");
            exit();
        }
    ?>
    <div class="small-wrapper">
    <form method="POST" class="signinform">
        <h2>Sign in!</h2>
        <input type="email" name="id" placeholder="E-mail" minlength="10" maxlength="40">
        <input type="password" name="pass" placeholder="Password" minlength="10" maxlength="20">
        <input type="submit" name="signin" value="Sign in">
        <a href="neseit.php">Forgot Password?</a><br>
        New to our site? <a href="signuppage.php">Sign up</a>
    </form>
    <?php

    if(isset($_POST['signin'])) {
        if(isset($_SESSION['loginattemptshamada'])) {
            if($_SESSION['loginattemptshamada'] >= 3) {
                echo "<script>alert('Too many login attempts!');</script>";
                exit();
            }
        }
        $id = $_POST['id'];
        $pass = $_POST['pass'];
        $usql = $db->query("SELECT `password` FROM `users` WHERE `user` = '$id' AND `verified` = 1 LIMIT 1");
        $ssql = $db->query("SELECT `password` FROM `sales` WHERE `sales` = '$id' LIMIT 1");
        $rsql = $db->query("SELECT `password` FROM `reps` WHERE `id` = '$id' LIMIT 1");
        $vsql = $db->query("SELECT `password` FROM `vendors` WHERE `vendor` = '$id' LIMIT 1");
        $asql = $db->query("SELECT `password` FROM `admins` WHERE `id` = '$id' LIMIT 1");
        if(mysqli_num_rows($usql) > 0) {
            $row = $usql->fetch_assoc();
            if(password_verify($pass, $row['password'])) {
                $_SESSION['loginattemptshamada'] = 0;
                $_SESSION['adminli'] = "false";
                $_SESSION['vendorli'] = "false";
                $_SESSION['repli'] = "false";
                $_SESSION['salesli'] = "false";
                $_SESSION['userli'] = $id;
                header("Location: index.php");
                exit();
            } else {
                if(isset($_SESSION['loginattemptshamada'])) {
                    $_SESSION['loginattemptshamada']++;
                } else {
                    $_SESSION['loginattemptshamada'] = 1;
                }
                echo "<script>alert('Wrong password');</script>";
                echo "<script>window.location.href='signinpage.php';</script>";
            }
        } else {
            if(mysqli_num_rows($ssql) > 0) {
                $row = $ssql->fetch_assoc();
                if(password_verify($pass, $row['password'])) {
                    $_SESSION['loginattemptshamada'] = 0;
                    $_SESSION['adminli'] = "false";
                    $_SESSION['vendorli'] = "false";
                    $_SESSION['repli'] = "false";
                    $_SESSION['salesli'] = $id;
                    $_SESSION['userli'] = "false";
                    header("Location: ../salesside/sales.php");
                    exit();
                } else {
                    if(isset($_SESSION['loginattemptshamada'])) {
                        $_SESSION['loginattemptshamada']++;
                    } else {
                        $_SESSION['loginattemptshamada'] = 1;
                    }
                    echo "<script>alert('Wrong password');</script>";
                    echo "<script>window.location.href='signinpage.php';</script>";
                }
            } else {
                if(mysqli_num_rows($rsql) > 0) {
                    $row = $rsql->fetch_assoc();
                    if(password_verify($pass, $row['password'])) {
                        $_SESSION['loginattemptshamada'] = 0;
                        $_SESSION['adminli'] = "false";
                        $_SESSION['vendorli'] = "false";
                        $_SESSION['repli'] = $id;
                        $_SESSION['salesli'] = "false";
                        $_SESSION['userli'] = "false";
                        header("Location: ../repside/reps.php");
                        exit();
                    } else {
                        if(isset($_SESSION['loginattemptshamada'])) {
                            $_SESSION['loginattemptshamada']++;
                        } else {
                            $_SESSION['loginattemptshamada'] = 1;
                        }
                        echo "<script>alert('Wrong password');</script>";
                        echo "<script>window.location.href='signinpage.php';</script>";
                    }
                } else {
                    if(mysqli_num_rows($vsql) > 0) {
                        $row = $vsql->fetch_assoc();
                        if(password_verify($pass, $row['password'])) {
                            $_SESSION['loginattemptshamada'] = 0;
                            $_SESSION['adminli'] = "false";
                            $_SESSION['vendorli'] = $id;
                            $_SESSION['repli'] = "false";
                            $_SESSION['salesli'] = "false";
                            $_SESSION['userli'] = "false";
                            header("Location: ../vendorside/vendorFinancials.php");
                            exit();
                        } else {
                            if(isset($_SESSION['loginattemptshamada'])) {
                                $_SESSION['loginattemptshamada']++;
                            } else {
                                $_SESSION['loginattemptshamada'] = 1;
                            }
                            echo "<script>alert('Wrong password');</script>";
                            echo "<script>window.location.href='signinpage.php';</script>";
                        }
                    } else {
                        if(mysqli_num_rows($asql) > 0) {
                            $row = $asql->fetch_assoc();
                            if(password_verify($pass, $row['password'])) {
                                $_SESSION['loginattemptshamada'] = 0;
                                $_SESSION['adminli'] = $id;
                                $_SESSION['vendorli'] = "false";
                                $_SESSION['repli'] = "false";
                                $_SESSION['salesli'] = "false";
                                $_SESSION['userli'] = "false";
                                header("Location: ../adminside/ourFinancials.php");
                                exit();
                            }  else {
                                if(isset($_SESSION['loginattemptshamada'])) {
                                    $_SESSION['loginattemptshamada']++;
                                } else {
                                    $_SESSION['loginattemptshamada'] = 1;
                                }
                                echo "<script>alert('Wrong password');</script>";
                                echo "<script>window.location.href='signinpage.php';</script>";
                            }
                        } else {
                            echo "<script>alert('Wrong Credentials');</script>";
                            echo "<script>window.location.href='signinpage.php';</script>";
                        }
                    }
                }
            }
        }
    }
    ?>
    </div>
    </div>
</body>
</html>