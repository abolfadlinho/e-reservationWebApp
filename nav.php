<div class="nav-biggest">
<div class="top">
	<!--<h1>Reservy</h1>-->
    <img src="../media/logo.PNG" alt="logo" class="logo">
</div>
<?php
if(((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") )) {
    if($_SESSION['userli'] != "false") {
        ?> 
        <nav class="nav">
        <a href="index.php" class="nav__link">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>
        <a href="myReservations.php" class="nav__link">
            <i class="material-icons nav__icon">list</i>
            <span class="nav__text">My Reservations</span>
        </a>
        <a href="menu.php" class="nav__link">
            <i class="material-icons nav__icon">menu</i>
            <span class="nav__text">More</span>
        </a>
    </nav>
        <?php
    }
    if(isset($_POST['logout'])) {
        $_SESSION['adminli'] = "false";
        $_SESSION['vendorli'] = "false";
        $_SESSION['repli'] = "false";
        $_SESSION['salesli'] = "false";
        $_SESSION['userli'] = "false";
        $done = true;
        if($done)
            echo "<script>window.location.href = 'index.php';</script>";
    }
} else {
    ?>
    <nav class="nav">
        <a href="../index.php" class="nav__link">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>
        <a href="signinpage.php" class="nav__link">
            <i class="material-icons nav__icon">add</i>
            <span class="nav__text">Sign in</span>
        </a>
        <a href="menu.php" class="nav__link">
            <i class="material-icons nav__icon">menu</i>
            <span class="nav__text">More</span>
        </a>
    </nav>
    <?php
}
?>
</div>
