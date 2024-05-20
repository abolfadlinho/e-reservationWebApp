<div class="nav-biggest">
<div class="top">
    <img src="../media/logo.PNG" alt="logo" class="logo">
</div>
<div class="small-wrapper">

<?php 
if($_SESSION['repli'] != "false") {
    ?> 
    <a href="reps.php"><button>الرئيسية</button></a>
    <form method="POST" action="../logout.php"><button name="logout">تسجيل خروج</button></form>
    <?php
}
?>
</div>
</div>
