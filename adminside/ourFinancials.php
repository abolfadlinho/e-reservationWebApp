<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Our Financials</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
        echo '<table class="rep-table"><thead><th>Vendor</th><th>Last Collect</th><th>Credit</th></thead><tbody>';
        $sql = $db->query("SELECT * FROM `vendors`");
        $totalv = 0;
        while($row = $sql->fetch_assoc()) {
            $totalv += getVendorBalance($db, $row['vendor']);
            echo '<tr><td>' . $row['name'] . '</td><td>' . convertToDate($row['last_collect']) . '</td><td>+' . getVendorBalance($db, $row['vendor']) . '</td></td></tr>';
        }
        echo "</tbody></table><br><h6>*These numbers exclude: featuring fees, extra products fees and all expenses</h6>";
        echo "<h2>Revenue from Rate: " . $totalv . " EGP</h2>";
        echo '<table class="rep-table"><thead><th>Salesman</th><th>Last Collect</th><th>Credit</th></thead><tbody>';
        $sql2 = $db->query("SELECT * FROM `sales`");
        $totals = 0;
        while($row2 = $sql2->fetch_assoc()) {
            $totals += getSalesTotalCollect($db, $row2['sales']);
            echo '<tr><td>' . $row2['name'] . '</td><td>' . convertToDate($row2['last_collect']) . '</td><td>-' . getSalesTotalCollect($db, $row2['sales']) . '</td></tr>';
        }
        echo "</tbody></table><h2>Amount owed to Salesmen for Rate: " . $totals . " EGP</h2>";
        echo "<h2>Total our Rate Cut: " . ($totalv - $totals) . " EGP</h2>";
        ?> 
        <table class="rep-table">
            <thead><th>Vendor</th><th>Last Collect</th><th>Total Rent Owed</th><th>Salesman</th><th>Salesman Cut</th><th>Our Cut</th></thead>
            <tbody>
                <?php 
                $sql3 = $db->query("SELECT * FROM `vendors`");
                $totalRent = 0;
                $totalSalesmanRentCut = 0;
                $totalOurRentCut = 0;
                while($row3 = $sql3->fetch_assoc()) {
                    $totalVendorRent = $row3['rent'] * getMonthsSinceCollect($row3['last_collect']);
                    $salesmanRentCut = getSalesCutPer($db, $row3['sales'])*$totalVendorRent;
                    $ourRentCut = $totalVendorRent - $salesmanRentCut;
                    $totalRent += $totalVendorRent;
                    $totalSalesmanRentCut += $salesmanRentCut;
                    $totalOurRentCut += $ourRentCut;
                    echo "<tr><td>" . $row3['name'] . "</td><td>" . convertToDate($row3['last_collect']) . "</td><td>" . $totalVendorRent . "</td><td>" . getSalesName($db, $row3['sales']) . "</td><td>" . $salesmanRentCut . "</td><td>" . $ourRentCut . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <h2>Total Rent Owed: <?php echo $totalRent; ?> EGP</h2>
        <h2>Total Salesman Rent Cut: <?php echo $totalSalesmanRentCut; ?> EGP</h2>
        <h2>Total Our Rent Cut: <?php echo $totalOurRentCut; ?> EGP</h2><hr>
        <h2>Total Revenue: <?php echo ($totalv + $totalRent); ?> EGP</h2>
        <h2>Total Salesman Cut: <?php echo ($totalSalesmanRentCut + $totals); ?> EGP</h2>
        <h2>Total Our Cut: <?php echo ($totalv - $totals + $totalOurRentCut); ?> EGP</h2>
        
        <?php
    } else {
        header("Location: signinpage.php");
    }    
    ?>
    </div></div>
</body>
</html>