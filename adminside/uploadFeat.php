<?php 
    include "../restricted/config.php";
    $id = $_POST['idf'];
    $start = getCurrentDate();
    $file = $_FILES['cover'];
    if(validFeat($db, $id, $file) == "") {
        echo '<script>alert("Product featured successfully.");</script>';
        $img = uploadImgs('cover');
        addFeat($db, $id, $img, $start);
    } else {
        echo '<script>alert("' . validFeat($db, $id, $file) . '");</script>';
    }
    echo "<script>window.location.href = '../adminside/ourFinancials.php';</script>";
?>