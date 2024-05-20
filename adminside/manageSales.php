<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Manage Salesmen</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
    ?>
        <!-- Add Salesman-->
        <form method="POST" class="signinform">
            <h2>Add New Salesmnn</h2>
            <input type="text" name="sales" placeholder="E-mail" required minlength="10" maxlength="40">
            <input type="text" name="name" placeholder="Name" required minlength="3" maxlength="40">
            <input type="password" name="pass" placeholder="Password" required minlength="10" maxlength="40">
            <input type="password" name="repass" placeholder="Re-enter Password" required minlength="10" maxlength="40">
            <input type="number" name="cut" placeholder="Cut" step="0.01"required>
            <input type="submit" name="add" value="Add">
        </form><hr>
        <!-- Modify Salesman-->
        <form method="POST" class="signinform">
            <h2>Modify Salesmen</h2>
            <select name="mod" required>
                <option disabled selected value>--Select Salesman--</option>
                <?php 
                $sales = getSalesSelect($db);
                while($s = $sales->fetch_assoc()) {
                    echo '<option value="' .$s['sales'] . '">' . $s['name'] . ', Old cut: ' . $s['cut'] . '</option>';
                }
                ?>
            </select>
            <input type="number" name="new_cut" placeholder="New Cut"  required step="0.01">
            <input type="submit" name="modify" value="Modify & Collect">
        </form><hr>
        <!-- Remove Salesman-->
        <form method="POST" class="signinform">
            <h2>Remove Salesmen</h2>
            <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="remove"></th><th>Name</th><th>Last Collect</th><th>Credit</th><th>Cut</th></tr></thead><tbody>
            <?php 
            getSalesTable($db);
            ?>
            </tbody></table>
        </form><hr>
        <!-- Set Day Off-->
        <form method="POST" class="signinform">
            <h2>Set Days Off</h2>
            <select name="prod" required>
                <option disabled selected value>--Select Product--</option>
                <?php 
                $prods = getProdSelect($db);
                echo (mysqli_num_rows($prods));
                while($p = $prods->fetch_assoc()) {
                    echo '<option value="' . $p['product_id'] . '">' . $p['title'] . ' by ' . getVendorName($db, $p['vendor']) . '</option>';
                }
                ?>
            </select>
            <div class="stars">
                <input type="text" minlength = "2" maxlength = "2" placeholder="Year YY" name="y">
                <input type="text" minlength = "2" maxlength = "2" placeholder="Month mm" name="m">
                <input type="text" minlength = "2" maxlength = "2" placeholder="Day dd" name="d">
            </div>
            <input type="submit" value="Set" name="set">
        </form><hr>
        <?php
        getDaysOffTable($db);
        echo "<hr>";
        getRepsOverviewTable($db);
        echo "<hr>";
        ?> 
            <form method="POST">
                <table class="rep-table"><thead><tr><th><input type="submit" value="Remove" name="removerep"></th><th>Representative</th><th>Vendor</th></tr></thead><tbody>
                <?php 
                getAllRepsTable($db);
                ?>
                </tbody></table>
            </form>
        <?php
        //Sales Part
        if(isset($_POST['add'])) {
            $sales = $_POST['sales'];
            $name = $_POST['name'];
            $pass = $_POST['pass'];
            $repass = $_POST['repass'];
            $cut = $_POST['cut'];
            if(validSales($db, $sales, $pass, $repass, $name, $cut) == "") {
                addSales($db, $sales, $name, $pass, $cut);
                echo "<script>alert('Salesman added successfully!');</script>";
                echo "<script>window.location.href = 'manageSales.php';</script>";
            } else {
                echo "<script>alert('" . validSales($db, $sales, $pass, $repass, $name, $cut) . "');</script>";
                echo "<script>window.location.href = 'manageSales.php';</script>";
            }
        }
        if(isset($_POST['remove']) && isset($_POST['id'])) {
            $selected = $_POST['id'];
            removeSales($db, $selected);
        }
        if(isset($_POST['modify'])) {
            $mod = $_POST['mod'];
            $newLC = getCurrentTimeSlot();
            $newCut = $_POST['new_cut'];
            if($newCut < 0 || $newCut > 1) {
                echo "<script>alert('Invalid cut!');</script>";
                echo "<script>window.location.href = 'manageSales.php';</script>";
            }
            modifySales($db, $mod, $newLC, $newCut);
            $done = true;
            if($done) {
                echo "<script>alert('Salesman modified successfully!');</script>";
                echo "<script>window.location.href = 'manageSales.php';</script>";
            }
        }
        if(isset($_POST['removerep']) && isset($_POST['id2'])) {
            $reps = $_POST['id'];
            removeReps($db, $reps);
            $done = true;
            if($done)
                echo "<script>window.location.href = 'forcedActions.php';</script>";
        }
        //Days Off Part
        if(isset($_POST['set'])) {
            $prod = $_POST['prod'];
            $y = $_POST['y'];
            $m = $_POST['m'];
            $d = $_POST['d'];
            $day = 20000000 + $y * 10000 + $m * 100 + $d;
            if(validDayOff($db, $prod, $y, $m , $y) =="") {
                $db->query("INSERT INTO `closed`(`product_id`, `day`) VALUES('$prod', '$day')");
                echo "<script>alert('Day off set successfully!');</script>";
            } else {
                echo "<script>alert('" . validDayOff($db, $prod, $y, $m , $y) . "');</script>";
            }
            echo "<script>window.location.href = 'manageSales.php';</script>";
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