<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Manage Incentives</title>
</head>
<body>
    <div class="big-wrapper">
<?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">'; 
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
    ?>
        <form method="POST"  class="signinform">
            <h2>Add Promo code</h2>
            <input type="text" name="code" placeholder="Promo Code" minlength="6" maxlength="6">
            <select name="prod" required>
                <option disabled selected value>--Select product to have Promo code--</option>
                <?php 
                $prods = getProdSelect($db);
                echo (mysqli_num_rows($prods));
                while($p = $prods->fetch_assoc()) {
                    echo '<option value="' . $p['product_id'] . '">' . $p['title'] . ' by ' . getVendorName($db, $p['vendor']) . '</option>';
                }
                ?>
            </select>
            <input type="submit" value="Add" name="add">
        </form>
        <form method="POST"  class="signinform">
            <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="remove"></th><th>Promo Code</th><th>Vendor</th><th>Product Name</th><th>Start Date</th></tr></thead><tbody>
            <?php 
            getPromosTable($db);
            ?>
            </tbody></table>
        </form>
        <form action="uploadFeat.php" method="POST" enctype="multipart/form-data" class="signinform">
            <h2>Feature a product</h2>
            <select name="idf" required>
                <option disabled selected value>--Select product to be featured--</option>
                <?php 
                $prods = getProdSelect($db);
                echo (mysqli_num_rows($prods));
                while($p = $prods->fetch_assoc()) {
                    echo '<option value="' . $p['product_id'] . '">' . $p['title'] . ' by ' . getVendorName($db, $p['vendor']) . '</option>';
                }
                ?>
            </select>
            <input type="file" name="cover" accept="image/jpeg, image/png">
            <input type="submit" name="addf" value="Add">
        </form>
        <form method="POST" class="signinform">
            <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="removef"></th><th>Poster</th><th>Vendor</th><th>Product Name</th><th>Start Date</th></tr></thead><tbody>
            <?php 
            getFeatsTable($db);
            ?>
            </tbody></table>
        </form>
        <?php 
        if(isset($_POST['add'])) {
            $code = $_POST['code'];
            $id = $_POST['prod'];
            if(validPromoAdd($code) == "") {
                $start = getCurrentDate();
                addPromo($db, $id, $code, $start);
                echo '<script>alert("Promo code added successfully.");</script>';
                echo '<script>window.location.href = "manageIncentives.php";</script>';
            } else {
                echo '<script>alert("' . validPromoAdd($code) . '");</script>';
                echo '<script>window.location.href = "manageIncentives.php";</script>';
            }
            
        }
        if(isset($_POST['remove']) && isset($_POST['id'])) {
            $selected = $_POST['id'];
            removePromos($db, $selected);
        }
        if(isset($_POST['removef']) && isset($_POST['idf'])) {
            $selected = $_POST['idf'];
            removeFeats($db, $selected);
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