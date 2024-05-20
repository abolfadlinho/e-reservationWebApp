<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Financials</title>
</head>
<body>
    <div class="big-wrapper">
    <?php 
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false")) {
        $vendor = $_SESSION['vendorli'];
        echo 'Last Collection was on: ' . convertToDate(getVendorLastCollect($db, $vendor));
        echo '<br>For help and assistance contact: 0100000000 or 7agz@gmail.com';
    ?>
    <h1>Last 6 month Performance</h1>
    <table class="rep-table"><thead><tr><th>Product</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>All Time Revenue</th></tr></thead><tbody>
    <?php 
    getFinancialsTable($db, $vendor);
    ?>
    </tbody></table>
    <h1>Promo Code Performance</h1>
    <?php 
    getPromoPerformance($db, $vendor);
    } else {
        header("Location: ../publicside/signinpage.php");
    }
    ?>
        </div>
    </div>
</body>
</html>