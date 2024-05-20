<?php 
    include "../restricted/config.php";
    $title = removeQuotMarks($_POST['title']);
    $vendor = $_SESSION['vendorli'];
    $count = $_POST['count'];
    $pph = $_POST['pph'];
    $cat = $_POST['cat'];
    $closetime = $_POST['closetime'];
    $opentime = $_POST['opentime'];
    $desc = removeQuotMarks($_POST['desc']);

    $file1 = $_FILES['pic1'];
    $file2 = $_FILES['pic2'];
    $file3 = $_FILES['pic3'];
    $file4 = $_FILES['pic4'];
    $file5 = $_FILES['pic5'];

    if(validUploadProduct($db, $title, $vendor, $count, $pph, $cat, $closetime, $opentime, $desc, $file1, $file2, $file3, $file4, $file5) == ""){
        $pic1 = uploadImgs('pic1');
        $pic2 = uploadImgs('pic2');
        $pic3 = uploadImgs('pic3');
        $pic4 = uploadImgs('pic4');
        $pic5 = uploadImgs('pic5');
        addProduct($db, $title, $vendor, $count, $pph, $cat, $closetime, $opentime, $desc, $pic1, $pic2, $pic3, $pic4, $pic5);
        echo "<script>alert('Product added successfully!');</script>";
        echo "<script>window.location.href='manageProducts.php';</script>";
    } else {
        echo "<script>alert('" . validUploadProduct($db, $title, $vendor, $count, $pph, $cat, $closetime, $opentime, $desc, $file1, $file2, $file3, $file4, $file5) . "');</script>";
        echo "<script>window.location.href='manageProducts.php';</script>";
    }
?>