<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="big-wrapper">
    <?php
    include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {
        $in = $_GET['xyz'];
        if(substr($in, 0, 1) == "v") {
            $vid = substr($in,1);
            $vend = getVendorDetails($db, $vid);
            ?>
            <form method="POST" enctype="multipart/form-data" class="signinform">
                <h2>Modify Vendor</h2>
                <img src="../<?php echo $vend['logo']?>" alt="logo" width="150px" height="150px">
                <table class="rep-table">
                    <thead><th>Old</th><th>New</th></thead>
                    <tbody>
                        <tr>
                            <td><?php echo $vend['name']; ?></td>
                            <td><textarea placeholder="Name" name="name" required><?php echo $vend['name'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['number']; ?></td>
                            <td><textarea placeholder="Number" name="number" required><?php echo $vend['number'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['location']; ?></td>
                            <td><textarea placeholder="Location/Area" name="location" required><?php echo $vend['location'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><a href ="<?php echo $vend['location_link']; ?>">Link</a></td>
                            <td><textarea placeholder="Location Link" name="link" required><?php echo $vend['location_link'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['desc']; ?></td>
                            <td><textarea placeholder="Description" name="desc" required><?php echo $vend['desc'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['rate']; ?></td>
                            <td><textarea placeholder="Rate" name="rate" required><?php echo $vend['rate'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['rent']; ?></td>
                            <td><textarea placeholder="Rent" name="rent" required><?php echo $vend['rent'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['nProd']; ?></td>
                            <td><textarea placeholder="Number of Products" name="nProd" required><?php echo $vend['nProd'];?></textarea></td>
                        </tr>
                        <tr>
                            <td><?php echo $vend['sales']; ?></td>
                            <td>
                                <select name="sales" required>
                                    <option disabled selected value>--Select--</option>
                                    <?php 
                                    $sales = getSalesSelect($db);
                                    while($s = $sales->fetch_assoc()) {
                                        echo '<option value="' . $s['sales'] . '">' . $s['name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" name="modifyvendor" value="Modify">
            </form>
        <?php
            if(isset($_POST['modifyvendor'])) {
                $name = $_POST['name'];
                $num = $_POST['number'];
                $loc = $_POST['location'];
                $desc = $_POST['desc'];
                $rate = $_POST['rate'];
                $rent = $_POST['rent'];
                $nProd = $_POST['nProd'];
                $sales = $_POST['sales'];
                $link = $_POST['link'];
                $db->query("UPDATE `vendors` SET `name` = '$name', `number` = '$num', `location` = '$loc', `desc` = '$desc', `rate` = '$rate', `rent` = '$rent', `nProd` = '$nProd', `sales` = '$sales', `location_link` = '$link' WHERE `vendor` = '$vid'");
                $done = true;
                if($done) {
                    echo "<script>alert('Vendor Modified!');</script>";
                    echo "<script>window.location.href = 'manageVendors.php';</script>";
                }
            }

        } else {
            if (substr($in, 0, 1) == "p") {
                $pid = substr($in,1);
                $prod = getProdDetails($db, $pid);
                ?>
                <form method="POST" enctype="multipart/form-data" class="signinform">
                    <h2><?php echo getVendorName($db, $prod['vendor']) . " (" . $prod['vendor'] . ")";?></h2>
                    <table class="rep-table">
                        <thead>
                            <th>Old</th>
                            <th>New</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $prod['title'];?></td>
                                <td><textarea placeholder="Title" name="title" required><?php echo $prod['title'];?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $prod['count'];?></td>
                                <td><textarea placeholder="Count" name="count" required><?php echo $prod['count'];?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $prod['pph'];?></td>
                                <td><textarea placeholder="Price per Hour" name="pph" required><?php echo $prod['pph'];?></textarea></td>
                            </tr>
                            <tr>
                                <td><?php echo $prod['cat'];?></td>
                                <td>
                                    <select name="cat" required>
                                        <option disabled selected value>--Select Category--</option>
                                        <option value="Padel">Padel</option>
                                        <option value="Football">Football</option>
                                        <option value="Workspaces">Workspaces</option>
                                        <option value="Venues">Venues</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $prod['opentime']?></td>
                                <td>
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
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $prod['closetime']?></td>
                                <td>
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
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $prod['desc'];?></td>
                                <td><textarea placeholder="Description" name="desc" required minlength="100" maxlength="1000"><?php echo $prod['desc'];?></textarea></td>
                            </tr>
                        </tbody>
                    </table><br>
                    <div class="stars">
                        <a href="../<?php echo $prod['pic1']?>"><img src="../<?php echo $prod['pic1']?>" alt=""></a>
                        <a href="../<?php echo $prod['pic2']?>"><img src="../<?php echo $prod['pic2']?>" alt=""></a>
                        <a href="../<?php echo $prod['pic3']?>"><img src="../<?php echo $prod['pic3']?>" alt=""></a>
                        <a href="../<?php echo $prod['pic4']?>"><img src="../<?php echo $prod['pic4']?>" alt=""></a>
                        <a href="../<?php echo $prod['pic5']?>"><img src="../<?php echo $prod['pic5']?>" alt=""></a>
                    </div>
                    <input type="submit" name="modifyandaccept" value="Modify & Accept">
                    <input type="submit" name="modifyonly" value="Modify Only">
                </form>
                <?php 
                if(isset($_POST['modifyandaccept'])) {
                    $title = $_POST['title'];
                    $count = $_POST['count'];
                    $pph = $_POST['pph'];
                    $cat = $_POST['cat'];
                    $ot = $_POST['opentime'];
                    $ct = $_POST['closetime'];
                    $desc = $_POST['desc'];
                    $db->query("UPDATE `products` SET `title` = '$title', `count` = '$count', `pph` = '$pph', `cat` = '$cat', `opentime` = '$ot', `closetime` = '$ct', `desc` = '$desc', `hidden` = 0 WHERE `product_id` = '$pid'");
                    $done = true;
                    if($done) {
                        echo "<script>alert('Product Modified & Accepted!')</script>";
                        echo "<script>window.location.href = 'approveProducts.php'</script>";
                    }
                }
                if(isset($_POST['modifyonly'])) {
                    $title = $_POST['title'];
                    $count = $_POST['count'];
                    $pph = $_POST['pph'];
                    $cat = $_POST['cat'];
                    $ot = $_POST['opentime'];
                    $ct = $_POST['closetime'];
                    $desc = $_POST['desc'];
                    $db->query("UPDATE `products` SET `title` = '$title', `count` = '$count', `pph` = '$pph', `cat` = '$cat', `opentime` = '$ot', `closetime` = '$ct', `desc` = '$desc' WHERE `product_id` = '$pid'");
                    $done = true;
                    if($done) {
                        echo "<script>alert('Product Modified!')</script>";
                        echo "<script>window.location.href = 'approveProducts.php'</script>";
                    }
                }
            }
        }
    } else {
        header("Location: signinpage.php");
    }
    ?>
    </div></div>
</body>
</html>