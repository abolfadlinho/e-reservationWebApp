<?php
    include "../restricted/config.php";
    $vendor = $_POST['vendor'];
    $name  = removeQuotMarks($_POST['name']);
    $pass = $_POST['pass'];
    $repass = $_POST['repass'];
    $number = $_POST['number'];
    $location = $_POST['location'];
    $desc = removeQuotMarks($_POST['desc']);
    $rate = $_POST['rate'];
    $rent = $_POST['rent'];
    $nProd = $_POST['nProd'];
    $sales = $_POST['sales'];
    $file = $_FILES['logo'];
    $link = $_POST['link'];
    if(validVendor($db, $name, $pass, $repass, $file, $desc) == "") {
        $logo = uploadImgs('logo');
        addVendor($db, $vendor, $name, $pass, $number, $location, $desc, $rate, $rent, $nProd, $sales, $logo, $link);
        echo '<script>alert("Vendor added successfully.");</script>';
        echo '<script>window.location.href = "manageVendors.php";</script>';
    } else {
        echo '<script>alert("' . validVendor($db, $name, $pass, $repass, $file, $desc) . '");</script>';
        echo '<script>window.location.href = "manageVendors.php";</script>';
    }
?>