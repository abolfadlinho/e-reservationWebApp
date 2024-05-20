<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Manage Products</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper" id="vendorproducts">';
    if((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false")) {
        $vendor = $_SESSION['vendorli'];
        if(getVendorNumProdAv($db, $vendor) < getVendornProd($db, $vendor)) {
    ?>
        <form action="uploadProduct.php" method="POST" enctype="multipart/form-data" class="signinform">
            <h2>Add New Product</h2>
            <input type="text" placeholder="Title" name="title" required minlength="3" maxlength="40">
            <h6>*You cannot have two products with the same title.</h6>
            <input type="number" placeholder="Count" name="count" required step="1">
            <input type="number" placeholder="Price per Hour" name="pph" required step="0.1">
            <select name="cat" required>
                <option disabled selected value>--Select Category--</option>
                <option value="Padel">Padel</option>
                <option value="Football">Football</option>
                <option value="Workspaces">Workspaces</option>
                <option value="Venues">Venues</option>
            </select>
            <select name="opentime" required>
                <option disabled selected value>--Select FIRST possible slot--</option>
                <option value="0">12AM TO 1AM</option>
                <option value="1">1AM TO 2AM</option>
                <option value="2">2AM TO 3AM</option>
                <option value="3">3AM TO 4AM</option>
                <option value="4">4AM TO 5AM</option>
                <option value="5">5AM TO 6AM</option>
                <option value="6">6AM TO 7AM</option>
                <option value="7">7AM TO 8AM</option>
                <option value="8">8AM TO 9AM</option>
                <option value="9">9AM TO 10AM</option>
                <option value="10">10AM TO 11AM</option>
                <option value="11">11AM TO 12PM</option>
                <option value="12">12PM TO 1PM</option>
                <option value="13">1PM TO 2PM</option>
                <option value="14">2PM TO 3PM</option>
                <option value="15">3PM TO 4PM</option>
                <option value="16">4PM TO 5PM</option>
                <option value="17">5PM TO 6PM</option>
                <option value="18">6PM TO 7PM</option>
                <option value="19">7PM TO 8PM</option>
                <option value="20">8PM TO 9PM</option>
                <option value="21">9PM TO 10PM</option>
                <option value="22">10PM TO 11PM</option>
                <option value="23">11PM TO 12AM</option>
            </select>
            <select name="closetime" required>
                <option disabled selected value>--Select LAST possible slot--</option>
                <option value="0">12AM TO 1AM</option>
                <option value="1">1AM TO 2AM</option>
                <option value="2">2AM TO 3AM</option>
                <option value="3">3AM TO 4AM</option>
                <option value="4">4AM TO 5AM</option>
                <option value="5">5AM TO 6AM</option>
                <option value="6">6AM TO 7AM</option>
                <option value="7">7AM TO 8AM</option>
                <option value="8">8AM TO 9AM</option>
                <option value="9">9AM TO 10AM</option>
                <option value="10">10AM TO 11AM</option>
                <option value="11">11AM TO 12PM</option>
                <option value="12">12PM TO 1PM</option>
                <option value="13">1PM TO 2PM</option>
                <option value="14">2PM TO 3PM</option>
                <option value="15">3PM TO 4PM</option>
                <option value="16">4PM TO 5PM</option>
                <option value="17">5PM TO 6PM</option>
                <option value="18">6PM TO 7PM</option>
                <option value="19">7PM TO 8PM</option>
                <option value="20">8PM TO 9PM</option>
                <option value="21">9PM TO 10PM</option>
                <option value="22">10PM TO 11PM</option>
                <option value="23">11PM TO 12AM</option>
            </select>
            <h6>*If open 24h, choose close time to be equal to open time.</h6>
            <h6>*If close time is after 12AM just choose it that way.<br> Example: McDonalds opens at 8PM and closes at 2AM, McDonalds should choose FIRST possible slot as 8PM to 9PM and LAST possible slot as 1AM to 2AM.</h6>
            <textarea placeholder="Description" name="desc" required minlength="100" maxlength="1000"></textarea>
            <h6>*Descriptions cannot contain phone numbers.</h6><br>
            First image (This will be the Front image of your product) <input type="file" name="pic1" required>
            Second image <input type="file" name="pic2" required accept="image/jpeg, image/png">
            Third image <input type="file" name="pic3" required accept="image/jpeg, image/png">
            Fourth image <input type="file" name="pic4" required accept="image/jpeg, image/png">
            Fifth image <input type="file" name="pic5" required accept="image/jpeg, image/png">
            <h6>*Images must be .jpg , .jpeg or .png .</h6>
            <input type="submit" name="submit" value="Upload">
        </form>
        <?php 
        } else {
            echo "<h2>Maximum number of products available. Contact 7agz if you need more.</h2>";
        }
        ?>
        <form method="POST">
            <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="remove"><input type="submit" value="Hide" name="hide"></th><th>Title</th><th>Count</th><th>Total Revenue</th><th>Accepted</th></tr></thead><tbody>
            <?php 
            getProductsTable($db, $vendor);
            ?>
            </tbody></table>
        </form>
        <br><br>
        <form method="POST">
            <table class="rep-table"><thead><tr><th><input type="submit" value="Unhide" name="unhide"></th><th>Title</th><th>Count</th><th>Total Revenue</th></tr></thead><tbody>
            <?php 
            getHiddenProductsTable($db, $vendor);
            ?>
            </tbody></table>
        </form>
    <?php 
        if(isset($_POST['remove']) && isset($_POST['id'])) {
            foreach($_POST['id'] as $selected) {
                if(prodHasUpcomingReservations($db, $selected)) {
                    echo "<script>alert('Product has upcoming reservations. Cannot remove.');</script>";
                } else {
                    $allselected = $_POST['id'];
                    rejectProducts($db, $allselected);
                    foreach($allselected as $s)
                        $sqlr = $db->query("DELETE FROM `closed` WHERE `product_id` = '$s'");
                }
            }
            echo "<script>window.location.href = 'manageProducts.php';</script>";
        }
        if(isset($_POST['hide']) && isset($_POST['id'])) {
            if(prodHasUpcomingReservations($db, $_POST['id'])) {
                echo "<script>alert('Product has upcoming reservations. Cannot hide.');</script>";
            } else {
                foreach($_POST['id'] as $selected) {
                    if(prodAccepted($db, $selected))
                        $db->query("UPDATE `products` SET `hidden` = 2 WHERE `product_id` = '$selected'");
                    else {
                        echo "<script>alert('Cannot hide unaccepted products.');</script>";
                    }
                }
            }
            echo "<script>window.location.href = 'manageProducts.php';</script>";
        }
        if(isset($_POST['unhide']) && isset($_POST['id2'])) {
            foreach($_POST['id2'] as $selected) {
                $db->query("UPDATE `products` SET `hidden` = 0 WHERE `product_id` = '$selected'");
            }
        }
    } else {
        header("Location: ../publicside/signinpage.php");
    }
    ?>
    </div></div>
</body>
</html>