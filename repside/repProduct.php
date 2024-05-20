<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Representative Product</title>
    <style>
        #container {
        margin: 20px;
        }
        
        #header {
        font-size: 24px;
        font-weight: bold;
        }
        
        #tableContainer {
        margin-top: 10px;
        }
        
        table {
        /*border-collapse: collapse;
        width: 100%;*/
        width: auto;
        display: none;
        }
        
        table.show {
        display: table;
        }

        .rep-table {
            display: table;
        }
        
        thead {
            background-color: #a5e300;
            border-radius: 100px;
        }

        th, td {
        border: none;
        padding: 8px;
        text-align: center;
        }
        
        #buttons {
        margin-top: 10px;
        }
        
        button {
        padding: 10px;
        margin-right: 10px;
        }
        .carousel slide {
            width: 100%;
            height: 300px;
            justify-content: center;
        }
        .slide {
            display: flex;
            justify-content: space-between;
        }
        .carousel-item img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: #a5e300;
            width: 60px;
            height: 60px;
            opacity: 0.7;
            margin-top: 200px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }

        .carousel-inner {
            margin-bottom: 10px;
            margin-top: 78px;
        }
        .other-details {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="list-wrapper">
    <?php include "../restricted/config.php";
    echo '<div class="small-wrapper">';
    $product = $_GET['id'];
    if((isset($_SESSION['repli'])) && ($_SESSION['repli'] != "false") && (getRepVendor($db, $_SESSION['repli']) == getProductVendor($db, $product))) {
        ?>
        <div id="buttons">
            <button id="previousBtn" disabled>اليوم السابق</button>
            <button id="nextBtn">اليوم التالي</button>
        </div>
        <form method="POST" class="booker" id="booker">
            <?php bookerar($db, $product); ?>
            <input type="text" name="name" placeholder="الاسم"><br>
            <input type="text" name="phone" placeholder="رقم التليفون"><br>
            <input type="submit" id="submit" name="submit" value="احجز"> <br>
        </form>
        <?php
        getRepResTable($db, $product);
        if(isset($_POST['submit'])) {
                $selected = $_POST['id'];
                $p = $product;
                $user = "";
                if(isset($_POST['name']))
                    $user = $user . $_POST['name'];
                if(isset($_POST['phone']))
                    $user = $user . "#" . $_POST['phone'];
                $pos = 0;
                $rid = getNextResID($db);
                foreach($selected as $s) {
                    $success = false;
                    if(checkAvailibility($db, $p, $s)) {
                        $db->query("INSERT INTO `reservations`(`reservation_id`, `user`, `slot`, `product_id`, `non`, `paid_online`, `price_of_slot`) VALUES('$rid', '$user', '$s', '$p', 1, 0, '$pos')");
                        $success = true;
                        if($success)
                            echo "<script>window.location.href = 'reps.php';</script>";
        
                    }
                }
        }
        if(isset($_POST['paid'])) {
            $id = $_POST['paid'];
            $db->query("UPDATE `reservations` SET `no_show` = 2 WHERE `reservation_id` = '$id'");
            $success = true;
            if($success)
                echo "<script>window.location.href = 'reps.php';</script>";
        }
        if(isset($_POST['noshow'])) {
            $id = $_POST['noshow'];
            $db->query("UPDATE `reservations` SET `no_show` = 1 WHERE `reservation_id` = '$id'");
            $success = true;
            if($success)
                echo "<script>window.location.href = 'reps.php';</script>";
        }
        if(isset($_POST['cancel'])) {
            $id = $_POST['cancel'];
            $db->query("DELETE FROM `reservations` WHERE `reservation_id` = '$id'");
            $success = true;
            if($success)
                echo "<script>window.location.href = 'reps.php';</script>";
        }
    } else {
        header("Location: ../publicside/signinpage.php");
    }
    ?>
    </div>
    </div>
    <script>
    // Store references to elements
    const headerElement = document.getElementById("header");
    const previousButton = document.getElementById("previousBtn");
    const nextButton = document.getElementById("nextBtn");
    const tables = document.querySelectorAll("table");

    let currentIndex = 0; // Current table index
    tables[currentIndex].classList.add("show"); // Show the initial table

    // Function to update content based on current index
    function updateContent() {
      tables.forEach((table, index) => {
        if (index === currentIndex) {
          table.classList.add("show");
        } else {
          table.classList.remove("show");
        }
      });

      // Show/hide previous/next buttons based on current index
      previousButton.disabled = currentIndex === 0;
      nextButton.disabled = currentIndex === tables.length - 1;

      // Update header
      headerElement.textContent = "Table " + currentIndex;
    }

    // Event listener for previous button
    previousButton.addEventListener("click", () => {
      if (currentIndex > 0) {
        currentIndex--;
        updateContent();
      }
    });

    // Event listener for next button
    nextButton.addEventListener("click", () => {
      if (currentIndex < tables.length - 1) {
        currentIndex++;
        updateContent();
      }
    });
    </script>
</body>
</html>