<div class="nav-biggest">
<div class="top">
	<!--<h1>Reservy</h1>-->
    <img src="../media/logo.PNG" alt="logo" class="logo">
</div>
<?php 
if($_SESSION['vendorli'] != "false") {
    ?> 
    <div class="side-nav">
        <li>
            <a href="manageProducts.php"><ul>Manage Products</ul></a>
            <a href="manageReps.php"><ul>Manage Representatives</ul></a>
            <a href="vendorFinancials.php"><ul>View Financials</ul></a>
            <a href="../publicside/tks.php"><ul>Change My Password</ul></a>
            <ul><form method="POST"><button name="logout">Log out</button></form></ul>
        </li>
    </div>
    <?php
    if(isset($_POST['logout'])) {
        $_SESSION['adminli'] = "false";
        $_SESSION['vendorli'] = "false";
        $_SESSION['repli'] = "false";
        $_SESSION['salesli'] = "false";
        $_SESSION['userli'] = "false";
        header("Location: ../index.php");
    }
}
?>
</div>