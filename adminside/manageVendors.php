<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Manage Vendors</title>
</head>
<body>
    <div class="big-wrapper">
<?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
    ?>
        <form action="uploadVendor.php" method="POST" enctype="multipart/form-data" class="signinform">
            <h2>Add Vendors</h2>
            <input type="email" placeholder="Vendor E-mail" name="vendor" required minlength="10" maxlength="40">
            <h6>*Can only be of the following domains: @yahoo.com, @gmail.com and @hotmail.com .</h6>
            <input type="text" placeholder="Name" name="name" required minlength="3" maxlength="40">
            <input type="password" placeholder="Password" name="pass" required minlength="10" maxlength="20">
            <input type="password" placeholder="Re-enter Password" name="repass" required minlength="10" maxlength="20">
            <h6>*Must have at least 1 uppercase character, 1 lowercase character, a symbol and a digit.</h6>
            <h6>*Cannot be similar to email.</h6><br>
            <input type="text" placeholder="Phone Number" name="number" required minlength="11" maxlength="11">
            <h6>*11 digit format.</h6>
            <h6>*Can only start with 010, 011, 012 or 015.</h6>
            <input type="text" placeholder="Location" name="location" required minlength="4" maxlength="40">
            <textarea placeholder="Description" name="desc" required minlength="100" maxlength="1000"></textarea>
            <h6>*Description cannot contain phone numbers.</h6>
            <input type="number" placeholder="Rate" name="rate" required step="0.01">
            <input type="number" placeholder="Rent" name="rent" required step="10">
            <input type="number" placeholder="Number of Products Allowed" name="nProd" required step="1">
            <select name="sales" required>
                <option disabled selected value>--Select Salesman--</option>
                <?php 
                $sales = getSalesSelect($db);
                while($s = $sales->fetch_assoc()) {
                    echo '<option value="' . $s['sales'] . '">' . $s['name'] . '</option>';
                }
                ?>
            </select>
            Attach logo<input type="file" name="logo" required accept="image/jpeg, image/png">
            <input type="text" placeholder="Location Link" name="link" required>
            <h6>*Make sure it is correct link.</h6>
            <input type="submit" name="submit" value="Upload">
        </form>
        <form method="POST">
            <?php 
            getVendorsTable($db);
            ?>
        </form>
    <?php 
        if(isset($_POST['remove']) && isset($_POST['id'])) {
            $selected = $_POST['id'];
            removeVendors($db, $selected);
        }
        if(isset($_POST['hide']) && isset($_POST['id'])) {
            $selectedh = $_POST['id'];
            //check if each selected vendor has future reservations
            hideVendorProducts($db, $selectedh);
        }
        if(isset($_POST['collect'])) {
            $vendor_id = $_POST['collect'];
            updateVendorCollect($db, $vendor_id);
        }
    } else {
        $done = true;
        if($done)
            echo "<script>window.location.href = 'signinpage.php';</script>";
    }
    ?> 
    </div></div>
</body>
</html>