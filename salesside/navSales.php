<div class="nav-biggest">
<div class="top">
    <img src="../media/logo.PNG" alt="logo" class="logo">
</div>
<div class="small-wrapper">
<?php 
if($_SESSION['salesli'] != "false") {
    ?> 
    <form method="POST" action="../logout.php"><button name="logout">Log out</button></form>
    <?php
}
?>
</div>
</div>
