<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoty List</title>   
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
</head>
<body>
    <?php 
        include "../restricted/config.php"; 
        $cat = isset($_GET['cat'])?$_GET['cat']:"blank";
    ?>
    <div class="filters">
    <form method="POST">
        <h1><?php echo $cat ?></h1>
        <select name='order' required>
            <option disabled selected value>--Sorting--</option>
            <option value='rhl'>Rating</option>
            <option value='plh'>Price (Low to High)</option>
            <option value='phl'>Price (High to Low)</option>
        </select>
        <input type="submit" name="sort" value="Sort">
    </form>
    <form method="POST">
        <select name="area" required>
            <option disabled selected value>--Choose Location--</option>
            <?php 
            $areas = getAreas($db, $cat);
            foreach($areas as $area) {
                echo '<option value="'.$area.'">'.$area.'</option>';
            }
            ?>
        </select>
        <input type="submit" name="filter" value="Apply">
    </form>
    </div>
    <div class="listOfProducts">
    <?php
        if(isset($_POST['filter'])) {
            if(isset($_POST['area'])){
                $area = "&area=". $_POST['area'];
                header("Location: catList.php?cat=$cat$area");
            }
        }
        if(isset($_POST['order']) && $_POST['order'] == "rhl") {
            $arr = getCatRatingSorted($db, $cat);
            if(count($arr) > 0) {
                foreach($arr as $a) {
                    $prod = getProdDetails($db, $a[0]);
                    if((isset($_GET['area'])) && ($_GET['area'] != getVendorLocation($db, $prod['vendor']))) {
                        continue;
                    }
                    echo '<a href="product.php?id='.$prod['product_id'].'"><div class="product">';
                    echo '<img src="../'.$prod['pic1'].'" alt="product image" width="300px" height="200px">';
                    echo '<div class="productTitle">' . $prod['title'] . '</div>' ;
                    echo '<div class="productVendor">' . getVendorName($db, $prod['vendor']) . '<br>' ;
                    echo getVendorLocation($db, $prod['vendor']) . '</div>' ;
                    echo '<div class="productBottom"><div class="stars">';
                    $stars = (int) getProdRating($db, $prod['product_id']);
                    for($i = 0; $i < $stars; $i++) {
                        echo '<span class="fa fa-star"></span>';
                    }
                    echo '</div><button>'.$prod['pph'].' EGP/hour</button></div><hr></div></a>';
                }
            } else {
                echo "No products yet";
            }
        } else {
            $list = (isset($_POST['sort']))?(getCatSorted($db, $cat, $_POST['order'])):getCat($db, $cat);      
            if(mysqli_num_rows($list) > 0) {
                while($prod = $list->fetch_assoc()) {
                    if((isset($_GET['area'])) && ($_GET['area'] != getVendorLocation($db, $prod['vendor']))) {
                        continue;
                    }
                    echo '<a href="product.php?id='.$prod['product_id'].'"><div class="product">';
                    echo '<img src="../'.$prod['pic1'].'" alt="product image" width="300px" height="200px">';
                    echo '<div class="productTitle">' . $prod['title'] . '</div>' ;
                    echo '<div class="productVendor">' . getVendorName($db, $prod['vendor']) . '<br>' ;
                    echo getVendorLocation($db, $prod['vendor']) . '</div>' ;
                    echo '<div class="productBottom"><div class="stars">';
                    $stars = (int) getProdRating($db, $prod['product_id']);
                    for($i = 0; $i < $stars; $i++) {
                        echo '<span class="fa fa-star"></span>';
                    }
                    echo '</div><button>'.$prod['pph'].' EGP/hour</button></div><hr></div></a>';
                }
            } else {
                echo "No products yet";
            }
        }
        
    ?>
    </div>
</body>
</html>