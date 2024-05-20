<?php
    /*require_once 'vendor/autoload.php'; // Include the Twilio PHP SDK

    use Twilio\Rest\Client;
    
    $accountSid = 'ACe1ae9d7010152a8574336c41bc2635cc';
    $authToken = 'accd39bb264c8b2c26978e77ee6ce75c';
    $twilio = new Client($accountSid, $authToken);*/
    
    $user = 'root';
    $pass = '';
    $db = 'db';
    $db = new mysqli('127.0.0.1:3306', $user, $pass, $db) or die("Error, database not connected");
    session_start();
    if(((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false") )) {
        include "../adminside/navAdmin.php";
    } elseif (((isset($_SESSION['vendorli'])) && ($_SESSION['vendorli'] != "false") )) {
        include "../vendorside/navVendor.php";
    } elseif (((isset($_SESSION['repli'])) && ($_SESSION['repli'] != "false") )) {
        include "../repside/navRep.php";
    } elseif (((isset($_SESSION['salesli'])) && ($_SESSION['salesli'] != "false") )) {
        include "../salesside/navSales.php";
    } elseif (((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false") ) && (!isset($_SESSION['usernotverified']))) {
        include "../nav.php";
    } else {
        if(!isset($_SESSION['usernotverified']))
            include "../nav.php";
    }
    /*General*/
    function binToYesNo($n) {
        return ($n == 0)?"No":"Yes";
    }
    function getAccepted($n) {
        return ($n == 0)?"Accepted":"Not Accepted Yet";
    }
    function uploadImgs($img) {
        $img_name = $_FILES[$img]['name'];
        $img_size = $_FILES[$img]['size'];
        $tmp_name = $_FILES[$img]['tmp_name'];
        $error = $_FILES[$img]['error'];
        if($error === 0) {
            if($img_size > 200000) {
                echo "<script>alert('Image too large')</script>";
                echo "<script>window.location.href='manageProducts.php'</script>";
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "png", "jpeg");
                if(in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                    $img_upload_path = 'media/'.$new_img_name;
                    $uploading_path = "../" . $img_upload_path;
                    move_uploaded_file($tmp_name, $uploading_path);
                    return $img_upload_path;
                } else {
                    echo "<script>alert('Error: File type not allowed')</script>";
                    echo "<script>window.location.href='manageProducts.php'</script>";
                }
            }
        } else {
            echo "<script>alert('Error: Error occured in attaching file')</script>";
            echo "<script>window.location.href='manageProducts.php'</script>";
        }
    }
    function deleteFromMedia($img) {
        if(!unlink("../" . $img)) {
            echo "Error deleting image";
        }
    }

    function getCurrentTimeSlot() {
        date_default_timezone_set("Africa/Cairo");
        return substr(("". date("Ymd") . date("H")), 2);
    }
    function getCurrentDate() {
        date_default_timezone_set("Africa/Cairo");
        return substr(("". date("Ymd")), 2);
    }
    function convertToDate($num) {
        $str = "";
        if($num == "0")
            $str = 0;
        else 
            $str = "20".substr($num, 0, 2)."/".substr($num, 2, 2)."/".substr($num, 4, 2);
        $dateObj = DateTime::createFromFormat('Y/m/d', $str);
        return $dateObj ? $dateObj->format('d/m/Y') : null;
    }
    function convertSlotTo24($slot) {
        switch($slot) {
            case 0:
                return "12AM to 1AM";
            case 1:
                return "1AM to 2AM"; 
            case 2:
                return "2AM to 3AM"; 
            case 3:
                return "3AM to 4AM"; 
            case 4:
                return "4AM to 5AM"; 
            case 5:
                return "5AM to 6AM"; 
            case 6:
                return "6AM to 7AM"; 
            case 7:
                return "7AM to 8AM"; 
            case 8:
                return "8AM to 9AM"; 
            case 9:
                return "9AM to 10AM"; 
            case 10:
                return "10AM to 11AM";
            case 11:
                return "11AM to 12PM"; 
            case 12:
                return "12PM to 1PM";
            case 13:
                return "1PM to 2PM"; 
            case 14:
                return "2PM to 3PM"; 
            case 15:
                return "3PM to 4PM"; 
            case 16:
                return "4PM to 5PM"; 
            case 17:
                return "5PM to 6PM"; 
            case 18:
                return "6PM to 7PM"; 
            case 19:
                return "7PM to 8PM"; 
            case 20:
                return "8PM to 9PM"; 
            case 21:
                return "9PM to 10PM"; 
            case 22:
                return "10PM to 11PM";
            case 23:
                return "11PM to 12AM";
            default:
                return "Unknown";                                                                                                                                                                                    
        }
    }
    function convertFullSlotToDateTime($num) {
        $year = substr($num, 0, 2);
        $month = substr($num, 2, 2);
        $day = substr($num, 4, 2);
        $slot = convertSlotTo24(substr($num, 6, 2));
        return $slot . " " . $day . "/" . $month . "/" . $year;
    }
    function changeMyPassword($db, $table, $old, $new, $re, $id) {
        if(($old != $new) && ($new == $re)) {
            $usql = $db->query("SELECT `password` FROM `users` WHERE `user` = '$id' LIMIT 1");
            $ssql = $db->query("SELECT `password` FROM `sales` WHERE `sales` = '$id' LIMIT 1");
            $rsql = $db->query("SELECT `password` FROM `reps` WHERE `id` = '$id' LIMIT 1");
            $vsql = $db->query("SELECT `password` FROM `vendors` WHERE `vendor` = '$id' LIMIT 1");
            $asql = $db->query("SELECT `password` FROM `admins` WHERE `id` = '$id' LIMIT 1");
            $hash = password_hash($new, PASSWORD_DEFAULT);
            switch($table) {
                case "users":
                    $row = $usql->fetch_assoc();
                    if(password_verify($old, $row['password'])) {
                        $db->query("UPDATE `users` SET `password` = '$hash' WHERE `user` = '$id'");
                    }
                    break;
                case "sales":
                    $row = $ssql->fetch_assoc();
                    if(password_verify($old, $row['password'])) {
                        $db->query("UPDATE `saless` SET `password` = '$hash' WHERE `sales` = '$id'");
                    }
                    break;
                case "reps":
                    $row = $rsql->fetch_assoc();
                    if(password_verify($old, $row['password'])) {
                        $db->query("UPDATE `reps` SET `password` = '$hash' WHERE `id` = '$id'");
                    }
                    break;
                case "vendors":
                    $row = $usql->fetch_assoc();
                    if(password_verify($old, $row['password'])) {
                        $db->query("UPDATE `vendors` SET `password` = '$hash' WHERE `vendor` = '$id'");
                    }
                    break;
                case "admins":
                    $row = $asql->fetch_assoc();
                    if(password_verify($old, $row['password'])) {
                        $db->query("UPDATE `admins` SET `password` = '$hash' WHERE `id` = '$id'");
                    }
                    break;
                default: break;
            }
        }
    }
    function getMonthsSinceCollect($lastcollect) {
        $currentSlot = getCurrentTimeSlot();
        //current slot is in the format YYMMDDHH and last collect is in the format YYMMDDHH, get the months between them
        $currentYear = substr($currentSlot, 0, 2);
        $currentMonth = substr($currentSlot, 2, 2);
        $lastYear = substr($lastcollect, 0, 2);
        $lastMonth = substr($lastcollect, 2, 2);
        $months = 0;
        if($currentYear == $lastYear) {
            $months = $currentMonth - $lastMonth;
        } else {
            $months = (12 - $lastMonth) + $currentMonth;
        }
        return $months;
    }

    function incrementDate($i) {
        date_default_timezone_set("Africa/Cairo");
        $currentDate = date("Y-m-d");
        $inc = "+".$i." day";
        $date = strtotime($inc, strtotime($currentDate));
        return substr(("". date("Ymd", $date)), 2);   
    }
    function decrementDate($i) {
        date_default_timezone_set("Africa/Cairo");
        $currentDate = date("Y-m-d");
        $inc = "-".$i." day";
        $date = strtotime($inc, strtotime($currentDate));
        return substr(("". date("Ymd", $date)), 2);   
    }
    function getDayFromNow($i) {
        switch($i) {
            case 0:
                echo "Today, ";
                break;
            case 1:
                echo "Tomorrow, ";
                break;
            default: 
                echo "";
        }
        $currentDate = date("Y-m-d");
        $inc = "+".$i." day";
        $date = strtotime($inc, strtotime($currentDate));
        echo date("d/m/Y", $date);
        return date("Ymd", $date);
    }
    function getDayFromNowar($i) {
        switch($i) {
            case 0:
                echo "اليوم, ";
                break;
            case 1:
                echo "غدا, ";
                break;
            default: 
                echo "";
        }
        $currentDate = date("Y-m-d");
        $inc = "+".$i." day";
        $date = strtotime($inc, strtotime($currentDate));
        echo date("d/m/Y", $date);
        return date("Ymd", $date);
    }
    
    function ourReservations($db) {
        $sql = $db->query("SELECT * FROM `reservations` WHERE `non` = 0 ORDER BY `reservation_id` DESC");
        echo '<table class="rep-table"><thead><th>id</th><th>Slot</th><th>Vendor</th><th>User</th><th>Product</th><th>Category</th><th>Cancelled</th><th>No Show</th><th>Promo Applied</th><th>Rating</th><th>Price</th><th>Paid Online</th></thead><tbody>';
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td>' . $row['reservation_id'] . '</td><td>' . convertFullSlotToDateTime($row['slot']) . '</td><td>' . getVendorName($db, getProductVendor($db, $row['product_id'])) . '</td><td>' . $row['user'] . '</td><td>' . getProdTitle($db, $row['product_id']) . '</td><td>' . getProductCat($db, $row['product_id']) . '</td><td>' . binToYesNo($row['cancelled']) . '</td><td>' . binToYesNo($row['no_show']) . '</td><td>' . binToYesNo($row['promo_applied']) . '</td><td>' . $row['rating'] . '</td><td>' . $row['price_of_slot'] . '</td><td>' . binToYesNo($row['paid_online'])  . '</td></tr>';
        }
        echo "</tbody></table>";
    }
    /*Adders*/
    function addVendor($db, $vendor, $name, $pass, $number, $location, $desc, $rate, $rent, $nProd, $sales, $logo, $location_link) {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $db->query("INSERT INTO `vendors`(`vendor`, `name`, `password`, `number`, `location`, `desc`, `rate`, `rent`, `nProd`, `sales`, `logo`, `location_link`) VALUES('$vendor', '$name', '$pass', '$number', '$location', '$desc', '$rate', '$rent', '$nProd', '$sales', '$logo', '$location_link')");
    }
    function addProduct($db, $title, $vendor, $count, $pph, $cat, $closetime, $opentime, $desc, $pic1, $pic2, $pic3, $pic4, $pic5) {
        $db->query("INSERT INTO `products`(`title`, `vendor`, `count`, `pph`, `cat`, `closetime`, `opentime`, `hidden`, `desc`, `pic1`, `pic2`, `pic3`, `pic4`, `pic5`) VALUES('$title', '$vendor', '$count', '$pph', '$cat', '$closetime', '$opentime', 1, '$desc', '$pic1', '$pic2', '$pic3', '$pic4', '$pic5')");
    }
    function addFeat($db, $id, $img, $start) {
        $db->query("INSERT INTO `feats`(`product_id`, `cover`, `start_date`) VALUES ('$id', '$img', '$start')");
    }
    function addPromo($db, $id, $code, $start) {
        $db->query("INSERT INTO `promos`(`product_id`, `code`, `start_date`) VALUES('$id', '$code', '$start')");
    }
    function addRep($db, $rep, $pass, $vendor) {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $db->query("INSERT INTO `reps`(`id`, `password`, `vendor`) VALUES('$rep', '$pass', '$vendor')");
    }
    function addSales($db, $sales, $name, $pass, $cut) {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $db->query("INSERT INTO `sales`(`sales`, `name`, `password`, `last_collect`, `cut`) VALUES('$sales', '$name', '$pass', 0, '$cut')");
    }
    function addUser($db, $fname, $lname, $user, $pass, $rpass, $num) {
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $db->query("INSERT INTO `users`(`user`, `password`, `fname`, `lname`, `number`) VALUES('$user', '$pass', '$fname', '$lname', '$num')");
    }

    function approveProducts($db, $selected) {
        foreach($selected as $s) {
            $db->query("UPDATE `products` SET `hidden` = 0 WHERE `product_id` = '$s'");
        }
    }
    /*Removers*/
    function removeVendors($db, $selected) {
        foreach($selected as $row) {
            if(vendorHasNoFutureReservations($db, $row)) {
                removeVendorProducts($db, $row);
                $db->query("DELETE FROM `vendors` WHERE `vendor` = '$row'");
            } else 
                echo "<script>alert('Vendor has future reservations.');</script>";
        }
    }
    function removeSales($db, $selected) {
        foreach($selected as $row) {
            $db->query("DELETE FROM `sales` WHERE `sales` = '$row'");
        }
    }
    function removeReps($db, $selected) {
        foreach($selected as $row) {
            $db->query("DELETE FROM `reps` WHERE `id` = '$row'");
        }
    }
    function removePromos($db, $selected) {
        foreach($selected as $s) {
            $db->query("DELETE FROM `promos` WHERE `code` = '$s'");
        }
    }
    function removeFeats($db, $selected) {
        foreach($selected as $s) {
            getAndDeleteFeatImg($db, $id);
            $db->query("DELETE FROM `feats` WHERE `product_id` = '$s'");
        }
    }

    function removeVendorProducts($db, $vendor) {
        $db->query("DELETE FROM `products` WHERE `vendor` = '$vendor'");
    }
    function hideVendorProducts($db, $vendor) {
        foreach($vendor as $v) {
            $db->query("UPDATE `products` SET `hidden` = 1 WHERE `vendor` = '$v'");
        }
    }
    function rejectProducts($db, $selected) {
        foreach($selected as $s) {
            $sql = $db->query("SELECT * FROM `products` WHERE `product_id` = '$s'");
            if($row = $sql->fetch_assoc()) {
                deleteFromMedia($row['pic1']);
                deleteFromMedia($row['pic2']);
                deleteFromMedia($row['pic3']);
                deleteFromMedia($row['pic4']);
                deleteFromMedia($row['pic5']);
            }
            $db->query("DELETE FROM `products` WHERE `product_id` = '$s'");
        }
    }
    /*Modifiers*/
    function modifySales($db, $id, $LC, $cut) {
        $db->query("UPDATE `sales` SET `last_collect` = '$LC', `cut` = '$cut' WHERE `sales` = '$id'");
    }
    /*Vendor Getters*/
    function getVendorName($db, $vendor) {
        $sql = $db->query("SELECT `name` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['name'];
        }
    }
    function getVendorLocation($db, $vendor) {
        $sql = $db->query("SELECT `location` FROM `vendors` WHERE `vendor` = '$vendor'");
        $row = $sql->fetch_assoc();
        return $row['location'];
    }
    function getVendorDesc($db, $vendor) {
        $sql = $db->query("SELECT `desc` FROM `vendors` WHERE `vendor` = '$vendor'");
        $row = $sql->fetch_assoc();
        return $row['desc'];
    }
    function getVendorRate($db, $vendor) {
        $sql = $db->query("SELECT `rate` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['rate'];
        }
    }
    function getVendorRent($db, $vendor) {
        $sql = $db->query("SELECT `rent` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['rent'];
        }
    }
    function getVendorLastCollect($db, $vendor) {
        $sql = $db->query("SELECT `last_collect` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['last_collect'];
        }
    }
    function getVendornProd($db, $vendor) {
        $sql = $db->query("SELECT `nProd` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['nProd'];
        }
    }
    function getVendorSales($db, $vendor) {
        $sql = $db->query("SELECT `sales` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['sales'];
        }
    }
    function getVendorLogo($db, $vendor) {
        $sql = $db->query("SELECT `logo` FROM `vendors` WHERE `vendor` = '$vendor'");
        if($row = $sql->fetch_assoc()) {
            return $row['logo'];
        }
    }
    function getVendorLocationLink($db, $vendor) {
        $sql = $db->query("SELECT `location_link` FROM `vendors` WHERE `vendor` = '$vendor'");
        $row = $sql->fetch_assoc();
        return $row['location_link'];
    }

    function getVendorDetails($db, $id) {
        $sql = $db->query("SELECT * FROM `vendors` WHERE `vendor` = '$id' LIMIT 1");
        return $sql->fetch_assoc();
    }
    function getVendorsTable($db) {
        echo '<table class="rep-table"><thead><th><input type="submit" value="Remove" name="remove"><br><input type="submit" value="Hide" name="hide"><th>Name</th></th><th>E-mail</th><th>Number</th><th>Last Collect</th><th>Balance</th><th>Rent</th><th>Rate</th><th>Non</th><th>Salesman</th><th>Number Of Products</th><th>Number Of Products Allowed</th><th></th></thead><tbody>';
        $sql = $db->query("SELECT * FROM `vendors`");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id[]" value="' . $row['vendor'] . '"></td><td>' . $row['name'] . '</td><td>' . $row['vendor'] . '</td><td>' . $row['number'] . '</td><td>' . convertToDate($row['last_collect']) . '</td><td>' . getVendorBalance($db, $row['vendor']) . '</td><td>' . $row['rent'] . '</td><td>' . $row['rate']. '</td><td>' . getVendorNumNonReservations($db, $row['vendor']) . '</td><td>' . $row['sales'] . '</td><td>' . getVendorNumProdAv($db, $row['vendor']) . '</td><td>' . $row['nProd'] . '</td><td><a href="modify.php?xyz=v' . $row['vendor'] . '">Modify</a><br><br><button name="collect" value="' . $row['vendor'] . '">Collect</button></td></tr>';
        }
        echo "</tbody></table>";
    }
    function getVendorBalance($db, $vendor) {
        $sum = 0;
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor'");
        $last_collect = getVendorLastCollect($db, $vendor);
        while($row = $sql->fetch_assoc()) {
            $sum += getProductSum($db, $row['product_id'], $last_collect);
        }
        $rate = getVendorRate($db, $vendor);
        return $sum * $rate / 100;
    }
    function getVendorOtherProds($db, $vendor, $id) {
        $sql = $db->query("SELECT * FROM `products` WHERE ((`vendor` = '$vendor') AND (`product_id` != '$id') AND (`hidden` = 0))");
        if(mysqli_num_rows($sql) > 0){
            echo '<h1>Other Products from' . getVendorName($db, $vendor) . '</h1>';
            echo '<div class="listOfProducts">';
            while($row = $sql->fetch_assoc()) {
                echo '<a href="product.php?id='.$row['product_id'].'"><div class="product">';
                    echo '<img src="../'.$row['pic1'].'" alt="product image" width="300px" height="200px">';
                    echo '<div class="productTitle">' . $row['title'] . '</div>' ;
                    echo '<div class="productVendor">' . getVendorName($db, $row['vendor']) . '<br>' ;
                    echo getVendorLocation($db, $row['vendor']) . '</div>' ;
                    echo '<div class="productBottom"><div class="stars">';
                    $stars = (int) getProdRating($db, $row['product_id']);
                    for($i = 0; $i < $stars; $i++) {
                        echo '<span class="fa fa-star"></span>';
                    }
                    echo '</div><button>'.$row['pph'].' EGP/hour</button></div><hr></div></a>';
            }
            echo '</div><br><br><br>';
        } else {
            echo "<br><br><br><br><br>";
        }
    }
    function getVendorNumProdAv($db, $vendor) {
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor'");
        return mysqli_num_rows($sql);
    }
    function getVendorNumNonReservations($db, $vendor) {
        $sql1 = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor'");
        $num = 0;
        while($row1 = $sql1->fetch_assoc()) {
            $sql2 = $db->query("SELECT * FROM `reservations` WHERE `product_id` = '" . $row1['product_id'] . "' AND `non` = 0 GROUP BY `reservation_id`");
            $num += mysqli_num_rows($sql2);
        }
        return $num;
    }
    function updateVendorCollect($db, $vendor) {
        $now = getCurrentTimeSlot();
        $db->query("UPDATE `vendors` SET `last_collect` = '$now' WHERE `vendor` = '$vendor'");
        $done = true;
        if($done)
            echo "<script>window.location.href = 'manageVendors.php';</script>";
    }
    function getFinancialsTable($db, $vendor) {
        $currentMonth = substr(getCurrentDate(), 2, 2);
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor'");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td>' . getProdTitle($db, $row['product_id']) . '</td><td>' .  getProductSuminMonth($db, $row['product_id'], $currentMonth) . '</td><td>' .  getProductSuminMonth($db, $row['product_id'], $currentMonth - 1) . '</td><td>' .  getProductSuminMonth($db, $row['product_id'], $currentMonth - 2) . '</td><td>' .  getProductSuminMonth($db, $row['product_id'], $currentMonth - 3) . '</td><td>' .  getProductSuminMonth($db, $row['product_id'], $currentMonth - 4) . '</td><td>' .  getProductSuminMonth($db, $row['product_id'], $currentMonth - 5) . '</td><td>' . getProductSum($db, $row['product_id'], -1) . '</td></tr>';
        }
    }
    /*Product Getters*/
    function getProdTitle($db, $id) {
        $sql = $db->query("SELECT `title` FROM `products` WHERE `product_id` = '$id' LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            return $row['title'];
        }
        return "(Removed Product)";
    }
    function getProductVendor($db, $id) {
        $sql = $db->query("SELECT `vendor` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['vendor'];
        }
    }
    function getProductCount($db, $id) {
        $sql = $db->query("SELECT `count` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['count'];
        }
    }
    function getProductPPH($db, $id) {
        $sql = $db->query("SELECT `pph` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['pph'];
        }
    }
    function getProductCat($db, $id) {
        $sql = $db->query("SELECT `cat` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['cat'];
        }
    }
    function getProductClose($db, $id) {
        $sql = $db->query("SELECT `closetime` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['closetime'];
        }
    }
    function getProductOpen($db, $id) {
        $sql = $db->query("SELECT `opentime` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['opentime'];
        }
    }
    function getProductDesc($db, $id) {
        $sql = $db->query("SELECT `desc` FROM `products` WHERE `product_id` = '$id'");
        if($row = $sql->fetch_assoc()) {
            return $row['desc'];
        }
    }

    function getProdRating($db, $prod) {
        $sql = $db->query("SELECT `rating` FROM `reservations` WHERE ((`product_id` = '$prod') AND (`cancelled` = 0) AND (`non` = 0) AND (`no_show` != 1) AND (`rating` != 0)) GROUP BY `reservation_id`");
        $count = mysqli_num_rows($sql);
        $total = 0;
        while($row = $sql->fetch_assoc()) {
            $total += $row['rating'];
        }
        if($count != 0) {
            return $total / $count;
        }
        return 0;
    }
    function getProdDetails($db, $id) {
        $sql = $db->query("SELECT * FROM `products` WHERE `product_id` = $id LIMIT 1");
        return $sql->fetch_assoc();
    }
    function getProdNotAppr($db) {
        $sql = $db->query("SELECT * FROM `products` WHERE `hidden` = 1");
        if(mysqli_num_rows($sql) > 0) {
            echo '<form method="POST" class="signinform" id="prodselect"><input type="submit" name="approve" value="Approve"><input type="submit" class="red" name="reject" value="Reject"><hr>';
            while($row = $sql->fetch_assoc()) {
                echo '<input type="checkbox" name="id[]" value="' . $row['product_id'] . '">' . $row['title'] . "<br>Vendor: " . getVendorName($db, $row['vendor']) . " (" . $row['vendor'] . ")<br>Count: " . $row['count'] . "<br>PPH: " . $row['pph'] . "<br>Category: " . $row['cat'] . "<br>Open time: " . $row['opentime'] . " Close time: " . $row['closetime'] . "<br>Description: " . $row['desc'];
                echo '<div class="stars"><a href="../'.$row['pic1'].'"><img src="../'.$row['pic1'].'" width="150px" height="150px""></a>'.'<a href="../'.$row['pic2'].'"><img src="../'.$row['pic2'].'" width="150px" height="150px""></a>'.'<a href="../'.$row['pic3'].'"><img src="../'.$row['pic3'].'" width="150px" height="150px""></a>'.'<a href="../'.$row['pic4'].'"><img src="../'.$row['pic4'].'" width="150px" height="150px""></a>'.'<a href="../'.$row['pic5'].'"><img src="../'.$row['pic5'].'" width="150px" height="150px""></a></div>';
                echo '<br><a href="modify.php?xyz=p'.$row['product_id'].'">Modify</a><hr>';
            }
            echo '</form>';
        } else {
            echo "No products to view";
        }
    }
    function getProductSum($db, $id, $last_collect) {
        $currentTime = getCurrentTimeSlot();
        $sql = $db->query("SELECT `price_of_slot` FROM `reservations` WHERE ((`product_id` = '$id') AND (`slot` > '$last_collect') AND (`slot` < '$currentTime') AND (`cancelled` = 0) AND (`non` = 0) AND (`paid_online` = 0) AND (`no_show` != 1))");
        $sum = 0;
        while($row = $sql->fetch_assoc()) {
            $sum += $row['price_of_slot'];
        }
        return $sum;
    }
    function getProdSelect($db) {
        $sql = $db->query("SELECT * FROM `products` WHERE `hidden` = 0");
        return $sql;
    }
    function getProductsTable($db, $vendor) {
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor' AND `hidden` != 2");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id[]" value="' . $row['product_id'] . '"></td><td>' . $row['title'] . '</td><td>' . $row['count'] . '</td><td>' . getProductSum($db, $row['product_id'], getVendorLastCollect($db, $vendor)) . '</td><td>' . getAccepted($row['hidden']) . '</td></tr>';
        }
    }
    function getHiddenProductsTable($db, $vendor) {
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor' AND `hidden` = 2");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id2[]" value="' . $row['product_id'] . '"></td><td>' . $row['title'] . '</td><td>' . $row['count'] . '</td><td>' . getProductSum($db, $row['product_id'], getVendorLastCollect($db, $vendor)) . '</td></tr>';
        }
    }
    function getProductSuminMonth($db, $product, $month) {
        $sql = $db->query("SELECT * FROM `reservations` WHERE (`product_id` = '$product' AND `cancelled` = 0 AND `non` = 0 AND `no_show` != 1)");
        $month = ($month <= 0)?($month += 12):($month);
        $sum = 0;
        while($row = $sql->fetch_assoc()) {
            if($month == substr($row['slot'], 2, 2) && $row['slot'] < getCurrentTimeSlot()) {
                $sum += $row['price_of_slot'];
            }
        }
        return $sum;
    }
    /*Sales Getters*/
    function getSalesLastCollect($db, $sales) {
        $sql = $db->query("SELECT `last_collect` FROM `sales` WHERE `sales` = '$sales'");
        if($row = $sql->fetch_assoc()) {
            return $row['last_collect'];
        }
    }
    function getSalesCutPer($db, $sales) {
        $sql = $db->query("SELECT `cut` FROM `sales` WHERE `sales` = '$sales'");
        if($row = $sql->fetch_assoc()) {
            return $row['cut'];
        }
    }
    function getSalesTotalCollect($db, $sales) {
        $sql = $db->query("SELECT * FROM `vendors` WHERE `sales` = '$sales'");
        $last_collect = getSalesLastCollect($db, $sales);
        $total = 0;
        while($row = $sql->fetch_assoc()) {
            $cut = $row['rate'];
            $vendor = $row['vendor'];
            $salesCut = getSalesCutPer($db, $sales);
            $total += getSalesCut($db, $vendor, $cut, $last_collect, $salesCut);
        }
        return $total;
    }
    function getSalesCut($db, $vendor, $cut, $last_collect, $salesCut) {
        $sql = $db->query("SELECT `product_id` FROM `products` WHERE `vendor` = '$vendor'");
        $sum = 0;
        while($row = $sql->fetch_assoc()) {
            $id = $row['product_id'];
            $sum += getProductSum($db, $id, $last_collect);
        }
        return $sum*$cut*$salesCut/100;
        
    }
    function getSalesTable($db) {
        $sql = $db->query("SELECT * FROM `sales`");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id[]" value="' . $row['sales'] . '"></td><td>' . $row['name'] . '</td><td>' . convertToDate($row['last_collect']) . '</td><td>' . getSalesTotalCollect($db, $row['sales']) . '</td><td>' . $row['cut']  . '</td></tr>';
        }
    }
    function getSalesSelect($db) {
        $sql = $db->query("SELECT * FROM `sales`");
        return $sql;
    }
    function getSalesName($db, $id) {
        $sql = $db->query("SELECT `name` FROM `sales` WHERE `sales` = '$id' LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            return $row['name'];
        }
    }
    /*Rep Getters*/
    function getRepVendor($db, $rep) {
        $sql = $db->query("SELECT `vendor` FROM `reps` WHERE `id` = '$rep' LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            return $row['vendor'];
        }
    }
    function getRepProducts($db, $rep) {
        $vendor = getRepVendor($db, $rep);
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor' AND `hidden` != 1");
        if(mysqli_num_rows($sql) > 0){
            while($row = $sql->fetch_assoc()) {
                echo '<a href="repProduct.php?id='.$row['product_id'].'"><img src="'.$row['pic1'].'" alt="">';
                echo $row['title'] . '<br>';
                echo $row['pph']." EGP/hour </a><hr>";
            }
        } else {
            echo "No other Products";
        }
    }
    function getRepsTable($db, $vendor) {
        $sql = $db->query("SELECT `id` FROM `reps` WHERE `vendor` = '$vendor'");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id[]" value="' . $row['id'] . '"></td><td>' . $row['id'] . '</td><tr>';
        }
    }
    function getAllRepsTable($db) {
        $sql = $db->query("SELECT * FROM `reps`");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id2[]" value="' . $row['id'] . '"></td><td>' . $row['id'] . '</td><td> ' . $row['vendor'] . '<tr>';
        }
    }
    function getRepResTable($db, $id) {
        $currentSlot = getCurrentTimeSlot();
        $sql = $db->query("SELECT * FROM `reservations` WHERE ((`cancelled` = 0) AND (`product_id` = '$id') AND (`no_show` != 2)) ORDER BY `reservation_id` DESC, `slot` DESC");
        $rid = -1;
        $total = 0;
        echo '<table class="rep-table"><thead><th>الاسم</th><th>الرقم</th><th>العمليات</th><th>الساعات</th><th>المطلوب تحصيله</th></thead><tbody>';
        while($row = $sql->fetch_assoc()) {
            if($rid == -1) {
                if($row['non'] == 1) {
                    if(strlen($row['user']) == 0) {
                        echo '<tr><td>لا يوجد اسم</td><td>لا يوجد رقم</td><td>';
                    } else {
                        echo '<tr><td>' . getPartBeforeHash($row['user']) . '</td><td>' . getPartAfterHash($row['user']) . '</td><td>';
                    }
                } else {
                    echo '<tr><td>' . getUserName($db, $row['user']) . '</td><td>' . getUserPhone($db, $row['user']) . '</td><td>';
                }
                echo '<form method="POST">';
                if($currentSlot > $row['slot'] && $row['no_show'] == 0 && $row['non'] == 0) {
                    echo '<button class="green" name="paid" value="' . $row['reservation_id'] . '">تم الدفع</button>';
                    echo '<button class="red" name="noshow" value="' . $row['reservation_id'] . '">لم يحضر</button>';
                }
                if($row['non'] == 1) {
                    echo '<button name="cancel" value="' . $row['reservation_id'] . '">الغاء الحجز</button>';
                }
                if(pastMoreThanTwoDays($row['slot']) && $row['no_show'] == 0) {
                    $db->query("UPDATE `reservations` SET `no_show` = '2' WHERE `reservation_id` = '" . $row['reservation_id'] . "'");
                }
                echo '</form></td>';
                echo '<td>' . convertFullSlotToDateTime($row['slot']) . '<br>';
                $rid = $row['reservation_id'];
                $total += $row['price_of_slot'];
            } else {
                if($rid == $row['reservation_id']) {
                    echo '<br>' . convertFullSlotToDateTime($row['slot']) . '<br>';
                    $total += $row['price_of_slot'];
                } else {
                    echo '</td><td>' . $total . ' EGP</td></tr>';
                    if($row['non'] == 1) {
                        if(strlen($row['user']) == 0) {
                            echo '<tr><td>لا يوجد اسم</td><td>لا يوجد رقم</td><td>';
                        } else {
                            echo '<tr><td>' . getPartBeforeHash($row['user']) . '</td><td>' . getPartAfterHash($row['user']) . '</td><td>';
                        }
                    } else {
                        echo '<tr><td>' . getUserName($db, $row['user']) . '</td><td>' . getUserPhone($db, $row['user']) . '</td><td>';
                    }
                    echo '<form method="POST">';
                    if($currentSlot > $row['slot'] && $row['no_show'] == 0 && $row['non'] == 0) {
                        echo '<button class="green" name="paid" value="' . $row['reservation_id'] . '">تم الدفع</button>';
                        echo '<button class="red" name="noshow" value="' . $row['reservation_id'] . '">لم يحضر</button>';
                    }
                    if($row['non'] == 1) {
                        echo '<button name="cancel" value="' . $row['reservation_id'] . '">الغاء الحجز</button>';
                    }
                    if(pastMoreThanTwoDays($row['slot']) && $row['no_show'] == 0) {
                        $db->query("UPDATE `reservations` SET `no_show` = '2' WHERE `reservation_id` = '" . $row['reservation_id'] . "'");
                    }
                    echo '</form></td>';
                    echo '<td>' . convertFullSlotToDateTime($row['slot']) . '<br>';
                    $rid = $row['reservation_id'];
                    $total = $row['price_of_slot'];
                }
            }
        }
        if($rid != -1) {
            echo '</td><td>' . $total . ' EGP</td></tr></tbody></table>';
        } else {
            echo "</tbody></table><br>   لا يوجد حجوزات";
        }
    }
    function getRepsOverviewTable($db) {
        $sql = $db->query("SELECT * FROM `vendors`");
        echo '<table class="rep-table"><thead><th>Vendor</th><th>No of Reps.</th></thead><tbody>';
        while($row = $sql->fetch_assoc()) {
            echo "<tr><td>" . $row['name'] . "</td><td>" . getRepsCountOfVendor($db, $row['vendor']) . "</td></tr>";
        }
        echo "</tbody></table>";
    }
    function getRepsCountOfVendor($db, $vendor) {
        $sql = $db->query("SELECT `id` FROM `reps` WHERE `vendor` = '$vendor'");
        return mysqli_num_rows($sql);
    }
    /*Users*/
    function getUserName($db, $id) {
        $sql = $db->query("SELECT `fname` FROM `users` WHERE `user` = '$id'");
        $row = $sql->fetch_assoc();
        return $row['fname'];
    }
    function getUserPhone($db, $id) {
        $sql = $db->query("SELECT `number` FROM `users` WHERE `user` = '$id'");
        $row = $sql->fetch_assoc();
        return $row['number'];
    }
    /*Category List Functions*/
    function getCat($db, $cat) {
        $sql = $db->query("SELECT * FROM `products` WHERE ((`cat` = '$cat') AND (`hidden` = 0))");
        return $sql;
    }
    function getCatSorted($db, $cat, $sort) {
        if($sort == "plh") {
            $sql = $db->query("SELECT * FROM `products` WHERE (`cat` = '$cat') ORDER BY `pph` ASC");
        } else {
            if($sort == "phl") {
                $sql = $db->query("SELECT * FROM `products` WHERE (`cat` = '$cat') ORDER BY `pph` DESC");
            } else {
                $sql = orderByRating($db, $cat);
            }
        }
        return $sql;
    }
    function getCatRatingSorted($db, $cat) {
        $arr = array();
        $sql = $db->query("SELECT `product_id` FROM `products` WHERE `cat` = '$cat' AND `hidden` = 0");
        while($row = $sql->fetch_assoc()) {
            $prod = $row['product_id'];
            $rating = getProdRating($db, $prod);
            array_push($arr, array($prod, $rating));
        }
        usort($arr, fn($a, $b) => $b[1] <=> $a[1]);
        return $arr;
    }
    function orderByRating($db, $cat) {
    }
    function getAreas($db , $cat) {
        $arr = array();
        $sql = $db->query("SELECT `vendor` FROM `products` WHERE `cat` = '$cat'");
        while($row = $sql->fetch_assoc()) {
            $loc = getVendorLocation($db, $row['vendor']);
            if(in_array($loc, $arr)) {
                continue;
            } else {
                array_push($arr, $loc);
            }
        }
        return $arr;
    }
    /*Incentives (Featuring and Promos)*/ 
    function getAndDeleteFeatImg($db, $id) {
        $sql = $db->query("SELECT `img` FROM `feats` WHERE `product_id` = $id LIMIT 1");
        $row = $sql->fetch_assoc();
        $img = $row['img'];
        deleteFromMedia($img);
    }
    function getFeatured($db) {
        $sql = $db->query("SELECT * FROM `feats` ORDER BY `start_date` DESC");
        return $sql;
    }
    function getPromosTable($db) {
        $sql = $db->query("SELECT * FROM `promos`");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="id[]" value="' . $row['code'] . '"></td><td>' . $row['code'] . '</td><td>' . getProdTitle($db, $row['product_id']) . '</td><td>' . getVendorName($db, getProductVendor($db, $row['product_id'])) . '</td><td>' . convertToDate($row['start_date']) . '</td><tr>';
        }
    }
    function getFeatsTable($db) {
        $sql = $db->query("SELECT * FROM `feats`");
        while($row = $sql->fetch_assoc()) {
            echo '<tr><td><input type="checkbox" name="idf[]" value="' . $row['product_id'] . '"></td><td><img src="../' . $row['cover'] . '" width="150px" length="150px"></td><td>' . getProdTitle($db, $row['product_id']) . '</td><td>' . getVendorName($db, getProductVendor($db, $row['product_id'])) . '</td><td>' . convertToDate($row['start_date']) . '</td><tr>';
        }
    }
    function getPromoPerformance($db, $vendor) {
        $sql = $db->query("SELECT * FROM `products` WHERE `vendor` = '$vendor'");
        while($row = $sql->fetch_assoc()) {
            $prod = $row['product_id'];
            $sql2 = $db->query("SELECT * FROM `promos` WHERE `product_id` = '$prod'");
            while($col = $sql2->fetch_assoc()) {
                $start = $col['start_date'] * 100;
                echo $col['code'] . ": Since applying the promo code you got a revenue of: " . getProductSum($db, $prod, $start) . " EGP";
            }
        }
    }
    /*Reservations*/
    function getFirstSlot($db, $id) {
        $sql = $db->query("SELECT `slot` FROM `reservations` WHERE (`reservation_id` = '$id' AND `cancelled` = 0 AND `non` = 0) ORDER BY `slot` ASC LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            return $row['slot'];
        }
    }
    function validCancellation($slot) {
        date_default_timezone_set("Africa/Cairo");
        $newDate = date('ymdH', strtotime(' + 4 hours'));
        if($newDate >= $slot) {
            return false;
        }
        return true;
    }
    function futureRes($db, $user) {
        $currentSlot = getCurrentTimeSlot();
        $sql = $db->query("SELECT * FROM `reservations` WHERE ((`cancelled` = 0) AND (`user` = '$user') AND (`slot` > '$currentSlot')) ORDER BY `reservation_id` ASC, `slot`");
        $rid = -1;
        $total = 0;
        while($row = $sql->fetch_assoc()) {
            if($rid == -1) {
                echo '<a href="product.php?id=' . $row['product_id'] . '">' . getProdTitle($db, $row['product_id']) . "</a><br>";
                echo '<a href="' . getVendorLocationLink($db, getProductVendor($db, $row['product_id'])) . '"><button type="button">
                <i class="fas fa-map-pin"></i>
            </button></a>';
                if(promoApplicable($db, $row['product_id']) && $row['promo_applied'] == 0) {
                    echo '<form method="POST"><input type="text" name="code" placeholder="Promo Code" required><button name="apply" value="' . $row['product_id'] . '">Apply</button></form>';
                }
                if(validCancellation($row['slot'])) {
                    echo '<form method="POST"><button name="cancel" value="' . $row['reservation_id'] . '">Cancel</button></form>';
                }
                echo convertFullSlotToDateTime($row['slot']) . "<br>";
                $rid = $row['reservation_id'];
                $total += $row['price_of_slot'];
            } else {
                if($rid == $row['reservation_id']) {
                    echo convertFullSlotToDateTime($row['slot']) . "<br>";
                    $total += $row['price_of_slot'];
                } else {
                    echo $total . ' EGP<br><br>';
                    echo '<a href="product.php?id=' . $row['product_id'] . '">' . getProdTitle($db, $row['product_id']) . "</a><br>";
                    echo '<a href="' . getVendorLocationLink($db, getProductVendor($db, $row['product_id'])) . '"><button type="button">
                    <i class="fas fa-map-pin"></i>
                </button></a>';
                    if(promoApplicable($db, $row['product_id']) && $row['promo_applied'] == 0) {
                        echo '<form method="POST"><input type="text" name="code" placeholder="Promo Code" required><button name="apply" value="' . $row['product_id'] . '">Apply</button></form>';
                    }
                    if(validCancellation($row['slot'])) {
                        echo '<form method="POST"><button name="cancel" value="' . $row['reservation_id'] . '">Cancel</button></form>';
                    }
                    echo convertFullSlotToDateTime($row['slot']) . "<br>";
                    $rid = $row['reservation_id'];
                    $total = $row['price_of_slot'];
                }
            }
        }
        if($rid != -1) {
            echo $total . ' EGP<br><br>';
        } else {
            echo "No upcoming reservations<br>";
        }
    }
    function pastRes($db, $user) {
        $currentSlot = getCurrentTimeSlot();
        $sql = $db->query("SELECT * FROM `reservations` WHERE ((`cancelled` = 0) AND (`user` = '$user') AND (`slot` <= '$currentSlot')) ORDER BY `reservation_id` ASC, `slot`");
        $rid = -1;
        $total = 0;
        while($row = $sql->fetch_assoc()) {
            $pid = $row['product_id'];
            if($rid == -1) {
                if(productNotFound($db,$pid)) {
                    echo "[removed product]";
                } elseif (productIsHidden($db,$pid)) {
                    echo getProdTitle($db, $row['product_id']);
                } else 
                    echo '<a href="product.php?id=' . $row['product_id'] . '">' . getProdTitle($db, $row['product_id']) . "</a>";
                if($row['rating'] == 0) {
                    echo '<form method="POST">Rate:<button name="1" value="' . $row['reservation_id'] . '">1</button><button name="2" value="' . $row['reservation_id'] . '">2</button><button name="3" value="' . $row['reservation_id'] . '">3</button><button name="4" value="' . $row['reservation_id'] . '">4</button><button name="5" value="' . $row['reservation_id'] . '">5</button></form>';
                } else {
                    $stars = $row['rating'];
                    echo '<div class="stars">';
                    for($i = 0; $i < $stars; $i++) {
                        echo '<span class="fa fa-star"></span>';
                    }
                    echo '</div>';
                }
                echo convertFullSlotToDateTime($row['slot']) . "<br>";
                $rid = $row['reservation_id'];
                $total += $row['price_of_slot'];
            } else {
                if($rid == $row['reservation_id']) {
                    echo convertFullSlotToDateTime($row['slot']) . "<br>";
                    $total += $row['price_of_slot'];
                } else {
                    echo $total . ' EGP<br><br>';
                    if(productNotFound($db,$pid)) {
                        echo "[removed product]";
                    } elseif (productIsHidden($db,$pid)) {
                        echo getProdTitle($db, $row['product_id']);
                    } else 
                        echo '<a href="product.php?id=' . $row['product_id'] . '">' . getProdTitle($db, $row['product_id']) . "</a>";
                    if($row['rating'] == 0) {
                        echo '<form method="POST">Rate:<button name="1" value="' . $row['reservation_id'] . '">1</button><button name="2" value="' . $row['reservation_id'] . '">2</button><button name="3" value="' . $row['reservation_id'] . '">3</button><button name="4" value="' . $row['reservation_id'] . '">4</button><button name="5" value="' . $row['reservation_id'] . '">5</button></form>'; 
                    } else {
                        $stars = $row['rating'];
                        echo '<div class="stars">';
                        for($i = 0; $i < $stars; $i++) {
                            echo '<span class="fa fa-star"></span>';
                        }
                        echo '</div>';
                    }
                    echo convertFullSlotToDateTime($row['slot']) . "<br>";
                    $rid = $row['reservation_id'];
                    $total = $row['price_of_slot'];
                }
            }
        }
        if($rid != -1) {
            echo $total . ' EGP<br><br>';
        } else {
            echo "No upcoming reservations<br>";
        }
    }
    function userNoShow($db, $user) {
        $sql = $db->query("SELECT `no_show` FROM `reservations` WHERE `user` = '$user' AND `no_show` = 1 GROUP BY `reservation_id`");
        $count = mysqli_num_rows($sql);
        echo '<div class="error">You have not shown on: ';
        switch($count) {
            case 0: 
                echo "0 occassions, thank you for being committed!";
                break;
            default:
                echo $count . " occasion(s)";
        }
        echo "</div>";
    }
    function promoApplicable($db, $id) {
        $sql = $db->query("SELECT `product_id` FROM `promos` WHERE `product_id` = '$id'");
        if(mysqli_num_rows($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }
    function validPromo($db, $prod, $code) {
        $sql = $db->query("SELECT * FROM `promos` WHERE `product_id` = '$prod' LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            return ($row['code'] == $code);
        }
    }
    /*Days Off (closed)*/
    function getDaysOffTable($db) {
        $sql = $db->query("SELECT * FROM `closed` GROUP BY `product_id` ORDER BY `day` DESC");
        echo '<table class="rep-table"><thead><th>Day Off</th><th>Vendor</th></thead><tbody>';
        while($row = $sql->fetch_assoc()) {
            $text = substr($row['day'], 0, 4)."/".substr($row['day'], 4, 2)."/".substr($row['day'], 6, 2);
            echo '<tr><td>' . $text . '</td><td>' . getVendorName($db, getProductVendor($db, $row['product_id'])) . '</td></tr>';
        }
        echo '</tbody></table>';
    }
    /*Booker*/
    /*function booker($db, $prod) {
        $currentDate = getCurrentDate();
        for( $i = 0; $i < 7; $i++) {
            echo '<br><table id="' . $i . '"><thead><th>';
            $check = getDayFromNow($i);
            $sql = $db->query("SELECT * FROM `closed` WHERE `product_id` = '$prod' AND `day` = '$check'");
            if(mysqli_num_rows($sql) > 0) {
                echo "<br>Day Off</thead></table><br>";
            } else { 
                echo '<th></thead><tbody>';
                getBookerTableDate($db, $prod, $i);
                echo '</tbody></table><br>';
            }
        }
    }*/
    function booker($db, $prod) {
        $currentDate = getCurrentDate();
        echo '<div id="container"><div id="tableContainer">';
        echo '<br><table id="table0" class="show"><thead><th>';
            $check = getDayFromNow(0);
            $sql = $db->query("SELECT * FROM `closed` WHERE `product_id` = '$prod' AND `day` = '$check'");
            if(mysqli_num_rows($sql) > 0) {
                echo "<br>Day Off</thead></table><br>";
            } else { 
                echo '<th></thead><tbody>';
                getBookerTableDate($db, $prod, 0);
                echo '</tbody></table><br>';
            }
        for( $i = 1; $i < 7; $i++) {
            echo '<br><table id="table' . $i . '"><thead><th>';
            $check = getDayFromNow($i);
            $sql = $db->query("SELECT * FROM `closed` WHERE `product_id` = '$prod' AND `day` = '$check'");
            if(mysqli_num_rows($sql) > 0) {
                echo "<br>Day Off</thead></table><br>";
            } else { 
                echo '<th></thead><tbody>';
                getBookerTableDate($db, $prod, $i);
                echo '</tbody></table><br>';
            }
        }
        echo '</div></div>';
    }
    function bookerar($db, $prod) {
        $currentDate = getCurrentDate();
        echo '<div id="container"><div id="tableContainer">';
        echo '<br><table id="table0" class="show"><thead><th>';
            $check = getDayFromNowar(0);
            $sql = $db->query("SELECT * FROM `closed` WHERE `product_id` = '$prod' AND `day` = '$check'");
            if(mysqli_num_rows($sql) > 0) {
                echo "<br>يوم اجازة</thead></table><br>";
            } else { 
                echo '<th></thead><tbody>';
                getBookerTableDatear($db, $prod, 0);
                echo '</tbody></table><br>';
            }
        for( $i = 1; $i < 7; $i++) {
            echo '<br><table id="table' . $i . '"><thead><th>';
            $check = getDayFromNowar($i);
            $sql = $db->query("SELECT * FROM `closed` WHERE `product_id` = '$prod' AND `day` = '$check'");
            if(mysqli_num_rows($sql) > 0) {
                echo "<br>يوم اجازة</thead></table><br>";
            } else { 
                echo '<th></thead><tbody>';
                getBookerTableDatear($db, $prod, $i);
                echo '</tbody></table><br>';
            }
        }
        echo '</div></div>';
    }
    function getBookerTableDatear($db, $prod, $i) { 
        $date = incrementDate($i) * 100;
        for($j = 0; $j < 24; $j++) {
            $temp = $date + $j;
            $slot = substr($temp, 6, 2);
            if(validTime($db, $prod, $slot)) {
                $sql = $db->query("SELECT * FROM `reservations` WHERE ((`product_id` = '$prod') AND (`slot` = '$temp') AND (`cancelled` = 0))");
                if(mysqli_num_rows($sql) >= getProductCount($db, $prod)) {
                    echo '<tr><td>' . convertSlotTo24($slot) . "</td><td>محجوز بالكامل</td></tr>";
                } else {
                    if($temp > getCurrentTimeSlot()) {
                        echo '<tr><td>' . convertSlotTo24($slot) . '</td><td><input type="checkbox" name="id[]" value="' . $temp . '"></td></tr>';
                    }
                }
            }
        }
    }
    function getBookerTableDate($db, $prod, $i) { 
        $date = incrementDate($i) * 100;
        for($j = 0; $j < 24; $j++) {
            $temp = $date + $j;
            $slot = substr($temp, 6, 2);
            if(validTime($db, $prod, $slot)) {
                $sql = $db->query("SELECT * FROM `reservations` WHERE ((`product_id` = '$prod') AND (`slot` = '$temp') AND (`cancelled` = 0))");
                if(mysqli_num_rows($sql) >= getProductCount($db, $prod)) {
                    echo '<tr><td>' . convertSlotTo24($slot) . "</td><td>Fully Booked</td></tr>";
                } else {
                    if($temp > getCurrentTimeSlot()) {
                        echo '<tr><td>' . convertSlotTo24($slot) . '</td><td><input type="checkbox" name="id[]" value="' . $temp . '"></td></tr>';
                    }
                }
            }
        }
    }
    function validTime($db, $prod, $slot) {
        $sql = $db->query("SELECT * FROM `products` WHERE `product_id` = '$prod'");
        if($row = $sql->fetch_assoc()) {
            if($row['closetime'] < $row['opentime']) {
                if($slot > $row['closetime'] && $slot < $row['opentime']) {
                    return false;
                } else {
                    return true;
                }
            } else {
                if($row['closetime'] > $row['opentime']) {
                    if($slot > $row['closetime'] || $slot < $row['opentime']) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }
    }
    function checkAvailibility($db, $prod, $slot) {
        $sql = $db->query("SELECT * FROM `reservations` WHERE ((`product_id` = '$prod') AND (`slot` = '$slot') AND (`cancelled` = 0))");
        if(mysqli_num_rows($sql) >= getProductCount($db, $prod)) {
            return false;
        } else {
            return true;
        }
    }
    function getNextResID($db) {
        $sql = $db->query("SELECT `reservation_id` FROM `reservations` ORDER BY `reservation_id` DESC LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            return $row['reservation_id'] + 1;
        }
    }
    /*Validations*/
    function isUniqueID($db, $id) {
        $usql = $db->query("SELECT `user` FROM `users` WHERE `user` = '$id' LIMIT 1");
        $ssql = $db->query("SELECT `sales` FROM `sales` WHERE `sales` = '$id' LIMIT 1");
        $rsql = $db->query("SELECT `id` FROM `reps` WHERE `id` = '$id' LIMIT 1");
        $vsql = $db->query("SELECT `vendor` FROM `vendors` WHERE `vendor` = '$id' LIMIT 1");
        $asql = $db->query("SELECT `id` FROM `admins` WHERE `id` = '$id' LIMIT 1");
        return ((mysqli_num_rows($usql) + mysqli_num_rows($ssql) + mysqli_num_rows($rsql) + mysqli_num_rows($vsql) + mysqli_num_rows($asql)) == 0);
    }
    function removeQuotMarks($str) {
        $str = str_replace('"','',$str);
        $str = str_replace("'",'',$str);
        return trim($str);
    }
    function validPromoCode($db, $promo) {        
        $sql = $db->query("SELECT `code` FROM `promos` WHERE `code` = '$promo'");
        return (is_numeric(substr($promo, 4,2)) && mysqli_num_rows($sql) == 0);
    }
    function userIsBlocked($db, $user) {
        $sql = $db->query("SELECT `no_show` FROM `reservations` WHERE `no_show` = 1 AND `user` = '$user' GROUP BY `reservation_id`");
        //if number of records is less than or equal to 3 return false
        return (mysqli_num_rows($sql) >= 3);
    }
    function productIsHidden($db, $id) {
        $sql = $db->query("SELECT `hidden` FROM `products` WHERE `product_id` = '$id' LIMIT 1");
        if($row = $sql->fetch_assoc()) {
            if ($row['hidden'] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }
    function numberAlreadyTaken($db, $num) {
        $sql = $db->query("SELECT `number` FROM `users` WHERE `number` = '$num' LIMIT 1");
        return (mysqli_num_rows($sql) > 0);
    }
    function prodHasUpcomingReservations($db, $prod) {
        $currentSlot = getCurrentTimeSlot();
        $sql = $db->query("SELECT `reservation_id` FROM `reservations` WHERE `product_id` = '$prod' AND (`slot` > '$currentSlot') LIMIT 1");
        return (mysqli_num_rows($sql) > 0);
    }
    function prodAccepted($db, $id) {
        $sql = $db->query("SELECT `product_id` FROM `products` WHERE `product_id` = '$id' AND `hidden` = 0 LIMIT 1");
        return (mysqli_num_rows($sql) > 0);
    }
    function vendorHasNoFutureReservations($db, $vendor) {
        $sql1 = $db->query("SELECT `product_id` FROM `products` WHERE `vendor` = '$vendor'");
        while($row = $sql1->fetch_assoc()) {
            $sql = $db->query("SELECT `reservation_id` FROM `reservations` WHERE `product_id` = '".$row['product_id']."' AND `slot` > '".getCurrentTimeSlot()."'");
            if (mysqli_num_rows($sql) > 0) {
                return false;
            }
        }
        return true;
    }
    function getMonitoringReservations($db) {
        $sql = $db->query("SELECT * FROM `reservations` WHERE `non` = 0 ORDER BY `reservation_id` ASC, `slot`");
        $rid = -1;
        $total = 0;
        while($row = $sql->fetch_assoc()) {
            if($rid == -1) {
                echo "<tr><td>" . $row['user'] . "</td><td>" . getProductVendor($db, $row['product_id']) . "</td><td>"  . binToYesNo($row['no_show']) . '</td><td>' . binToYesNo($row['cancelled']) . '</td><td>' . binToYesNo($row['promo_applied']) . '</td>';
                echo '<td>' . getProdTitle($db, $row['product_id']) . '</td><td>';
                echo convertFullSlotToDateTime($row['slot']) . "<br>";
                $rid = $row['reservation_id'];
                $total += $row['price_of_slot'];
            } else {
                if($rid == $row['reservation_id']) {
                    echo convertFullSlotToDateTime($row['slot']) . "<br>";
                    $total += $row['price_of_slot'];
                } else {
                    echo '</td><td>' . $total . ' EGP</td></tr>';
                    echo "<tr><td>" . $row['user'] . "</td><td>" . getProductVendor($db, $row['product_id']) . "</td><td>"  . binToYesNo($row['no_show']) . '</td><td>' . binToYesNo($row['cancelled']) . '</td><td>' . binToYesNo($row['promo_applied']) . '</td>';
                    echo '<td>' . getProdTitle($db, $row['product_id']) . '</td><td>';
                    echo convertFullSlotToDateTime($row['slot']) . "<br>";
                    $rid = $row['reservation_id'];
                    $total = $row['price_of_slot'];
                }
            }
        }
        if($rid != -1) {
            echo '</td><td>' . $total . ' EGP</td></tr>';
        } else {
            echo "No upcoming reservations<br>";
        }
    }
    function getPartAfterHash($string) {
        $position = strpos($string, '#');
        
        if ($position !== false) {
            $partAfterHash = substr($string, $position + 1);
            return $partAfterHash;
        }
        
        return '';
    }
    function getPartBeforeHash($string) {
        $position = strpos($string, '#');
        
        if ($position !== false) {
            $partBeforeHash = substr($string, 0, $position);
            return $partBeforeHash;
        }
        
        return $string;
    }
    function productNotFound($db, $id) {
        $sql = $db->query("SELECT `product_id` FROM `products` WHERE `product_id` = '$id' LIMIT 1");
        return (mysqli_num_rows($sql) == 0);
    }
    /*Sign up validation*/
    function validSignUp($db, $pass, $repass, $username, $phone, $fname, $lname) {
        $ret = "";
        if($pass != $repass) {
            $ret .= "Passwords do not match. ";
        }
        if(!validPassword($pass)) {
            $ret .= "Password must contain at least one uppercase letter, one lowercase letter, one digit and one symbol. ";
        }
        if(!validPhoneStart($phone)) {
            $ret .= "Phone number must start with 010, 011, 012 or 015. ";
        }
        if(!validUsername($db, $username, $pass)) {
            $ret .= "Invalid username. ";
        }
        if(!uniquePhone($db, $phone)) {
            $ret .= "Phone number already in use. ";
        }
        if(!containsOnlyAlphabeticalChars($fname) || !containsOnlyAlphabeticalChars($lname)) {
            $ret .= "First and last names must contain only alphabetical characters. ";
        }
        return $ret;
    }
    function validPassword($str) {
        // Check if the string contains at least one uppercase character
        if (!preg_match('/[A-Z]/', $str)) {
          return false;
        }
      
        // Check if the string contains at least one lowercase character
        if (!preg_match('/[a-z]/', $str)) {
          return false;
        }
      
        // Check if the string contains at least one symbol (non-alphanumeric character)
        if (!preg_match('/[^A-Za-z0-9]/', $str)) {
          return false;
        }
      
        // Check if the string contains at least one digit
        if (!preg_match('/[0-9]/', $str)) {
          return false;
        }
      
        // All requirements met, return true
        return true;
    }
    function validUsername($db, $str, $pass) {
        return (endsWithAllowedDomain($str) && isUniqueID($db, $str) && !isEmailSimilarToPassword($str, $pass));
        //return (validEmail($str) && endsWithAllowedDomain($str) && isUniqueID($db, $str) && !isEmailSimilarToPassword($str, $pass));
    }
    function validPhoneStart($phone) {
        $validPrefixes = ["010", "011", "012", "015"];
        $prefix = substr($phone, 0, 3); // Extract the first three characters of the string
        
        return in_array($prefix, $validPrefixes);
    }
                /*Helpers for Sign up validation*/
    function validEmail($str) {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }
    function endsWithAllowedDomain($str) {
        $allowedDomains = ["@yahoo.com", "@gmail.com", "@hotmail.com"];
        
        foreach ($allowedDomains as $domain) {
            if (substr($str, -strlen($domain)) === $domain) {
                return true;
            }
        }
        
        return false;
    }
    function isEmailSimilarToPassword($email, $password) {
        $emailUsername = strstr($email, '@', true); // Extract the username part of the email
        $emailDomain = substr(strstr($email, '@'), 1); // Extract the domain part of the email
        
        // Check if the email username is present in the password
        if (strpos($password, $emailUsername) !== false) {
            return true;
        }
        
        // Check if the email domain is present in the password
        if (strpos($password, $emailDomain) !== false) {
            return true;
        }
        
        return false;
    }
    function uniquePhone($db, $phone) {
        $sql = $db->query("SELECT `number` FROM `users` WHERE `number` = '$phone' LIMIT 1");
        return (mysqli_num_rows($sql) == 0);
    }
    function containsOnlyAlphabeticalChars($str) {
        // Remove any non-alphabetical characters from the string
        $cleanedString = preg_replace('/[^A-Za-z]/', '', $str);
        
        // Check if the cleaned string is equal to the original string
        return $cleanedString === $str;
    }
    /*Add product validation*/
    function validUploadProduct($db, $name, $vendor, $count, $pph, $cat, $closetime, $opentime, $desc, $img1, $img2, $img3, $img4, $img5) {
        $ret = "";
        if(vendorHasProdWithSameName($db, $vendor, $name)) {
            $ret .= "Vendor already has a product with the same name. ";
        }
        if(descriptionContainsNumbers($desc)) {
            $ret .= "Description must contain at maximum 10 numbers. ";
        }
        if(validImage($img1) . validImage($img2) . validImage($img3) . validImage($img4) . validImage($img5) != "") {
            $ret .= validImage($img1) . validImage($img2) . validImage($img3) . validImage($img4) . validImage($img5);
        }
        return $ret;
    }
    function vendorHasProdWithSameName($db, $vendor, $name) {
        $sql = $db->query("SELECT `title` FROM `products` WHERE `vendor` = '$vendor' AND `title` = '$name'");
        return (mysqli_num_rows($sql) > 0);
    }
    function descriptionContainsNumbers($str) {
        $digitCount = preg_match_all('/\d/', $str);
        return $digitCount > 10;
    }
    function validImage($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $fileType = $file['type'];
        $ret = "";
        if (!in_array($fileType, $allowedTypes)) {
            $ret .= "Only JPEG, PNG, and JPG images are allowed.";
        }
    
        // Check if the file size is within the limit 
        $maxFileSize = 200000; 
        $fileSize = $file['size'];
        if ($fileSize > $maxFileSize) {
            $ret .= "The file size exceeds the maximum limit of 12 megabytes.";
        }
        return $ret;
    }
    /*Add Reps validation*/
    function validRep($db, $user, $pass, $repass) {
        $ret = "";
        if($pass != $repass) {
            $ret .= "Passwords do not match. ";
        }
        if(!validPassword($pass)) {
            $ret .= "Password must contain at least one uppercase letter, one lowercase letter, one digit and one symbol. ";
        }
        if(!validUsername($db, $user, $pass)) {
            $ret .= "Invalid username. ";
        }
        return $ret;
    }
    /*Add Vendor validation*/
    function validVendor($db, $user, $pass, $repass, $logo, $desc) {
        $ret = "";
        if($pass != $repass) {
            $ret .= "Passwords do not match. ";
        }
        if(!validPassword($pass)) {
            $ret .= "Password must contain at least one uppercase letter, one lowercase letter, one digit and one symbol. ";
        }
        if(!validUsername($db, $user, $pass)) {
            $ret .= "Invalid username. ";
        }
        if(descriptionContainsNumbers($desc)) {
            $ret .= "Description must contain at maximum 10 numbers. ";
        }
        if(!validImage($logo)) {
            $ret .= "Invalid image. ";
        }
        return $ret;
    }
    /*Add Salesman validation*/
    function validSales($db, $user, $pass, $repass, $name, $cut) {
        $ret = "";
        if($pass != $repass) {
            $ret .= "Passwords do not match. ";
        }
        if(!validPassword($pass)) {
            $ret .= "Password must contain at least one uppercase letter, one lowercase letter, one digit and one symbol. ";
        }
        if(!validUsername($db, $user, $pass)) {
            $ret .= "Invalid username. ";
        }
        if(!containsOnlyAlphabeticalChars($name)) {
            $ret .= "Invalid name. ";
        }
        if($cut > 1) {
            $ret .= "Invalid cut. ";
        }
        return $ret;
    }
    /*Add Promo validation*/
    function validPromoAdd($code) {
        $ret = "";
        if (strlen($str) !== 6) {
            $ret .= "Promo code must be 6 characters long. ";
        }
        
        $letters = substr($str, 0, 4);
        if (!ctype_alpha($letters)) {
            $ret .= "First 4 characters must be letters. ";
        }
        
        $digits = substr($str, 4, 2);
        if (!ctype_digit($digits)) {
            $ret .= "Last 2 characters must be digits. ";
        }
        
        return $ret;
    }
    /*Add Feat validation*/
    function validFeat($db, $id, $img) {
        $ret = "";
        if(productAlreadyFeatured($db, $id)) {
            $ret .= "Product already featured. ";
        }
        if(validImage($img) != "") {
            $ret .= "Invalid image. ";
        }
        return $ret;
    }
    function productAlreadyFeatured($db, $id) {
        $sql = $db->query("SELECT `product_id` FROM `feats` WHERE `product_id` = '$id' LIMIT 1");
        return (mysqli_num_rows($sql) > 0);
    }
    /*Day Off validations*/ 
    function validDayOff($db, $id, $y, $m, $d) {
        $currentSlot = getCurrentTimeSlot();
        $dayOff = $y*1000000 + $m*10000 + $d*100;
        $ret = "";
        if($dayOff < $currentSlot) {
            $ret .= "This date is in the past. ";
        }
        if(prodHasReservationsOnThatDay($db, $id, $dayoff)) {
            $ret .= "This product has reservations on that day. ";
        }
        return $ret;
    }
    function prodHasReservationsOnThatDay($db, $id, $dayoff) {
        $lower = $dayoff - 1;
        $upper = $dayoff + 100;
        $sql = $db->query("SELECT `reservation_id` FROM `reservations` WHERE `product_id` = '$id' AND `slot` > '$lower' AND `slot` < '$upper' GROUP BY `reservation_id` LIMIT 1");
        return (mysqli_num_rows($sql) > 0);
    }
    /*Twilio*/
    function generateAndSendCode($number) {
        $verification = "123456";
        return $verification;
    }
    /*Rep reporting*/
    function pastMoreThanTwoDays($slot) {
        $currentSlot = getCurrentTimeSlot();
        return ($currentSlot - $slot) > 200;
    }
?>