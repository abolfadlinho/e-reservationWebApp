<?php 
include "restricted/config.php";
$_SESSION['adminli'] = "false";
$_SESSION['vendorli'] = "false";
$_SESSION['repli'] = "false";
$_SESSION['salesli'] = "false";
$_SESSION['userli'] = "false";
$_SESSION['rated'] = 0;
$_SESSION['promo'] = 0;
$done = true;
if($done)
    echo "<script>window.location.href = 'publicside/index.php';</script>";
?>