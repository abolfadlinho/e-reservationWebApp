<div class="nav-biggest">
<div class="top">
    <img src="../media/logo.PNG" alt="logo" class="logo">
</div>
<?php
if($_SESSION['adminli'] != "false") {
    ?> 
    <div class="side-nav">
        <li>
            <a href="manageVendors.php"><ul>Manage Vendors</ul></a>
            <a href="approveProducts.php"><ul>Approve Products</ul></a>
            <a href="manageSales.php"><ul>Manage Salesmen, Days Off & Reps</ul></a>
            <a href="manageIncentives.php"><ul>Manage Incentives</ul></a>
            <a href="ourReservations.php"><ul>Our Reservations</ul></a>
            <a href="ourFinancials.php"><ul>Our Financials</ul></a>
            <a href="viewUsers.php"><ul>View Users</ul></a>
            <a href="forcedActions.php"><ul>Forced Actions</ul></a>
            <a href="../publicside/tks.php"><ul>Change My Password</ul></a>
            <ul><form method="POST" action="../logout.php"><button name="logout">Log out</button></form></ul>
        </li>
    </div>
    <?php
}
?>
</div>
