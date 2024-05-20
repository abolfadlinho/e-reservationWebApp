<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Product Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
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
        border-collapse: collapse;
        width: 100%;
        display: none;
        }
        
        table.show {
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
        .booker {
            margin-left: 10px;
        }
    </style>
</head>
<body>
<?php 
    include "../restricted/config.php";
    $id = $_GET['id'];
    if(productIsHidden($db, $id)) {
        echo "<script>window.location.href = '../index.php';</script>";
    } else {

    $prod = getProdDetails($db, $id);
    ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <a href="../<?php echo $prod['pic1']?>"><img src="../<?php echo $prod['pic1']?>" alt="Photo 1"></a>
            </div>
            <div class="carousel-item">
                <a href="../<?php echo $prod['pic2']?>"><img src="../<?php echo $prod['pic2']?>" alt="Photo 2"></a>
            </div>
            <div class="carousel-item">
                <a href="../<?php echo $prod['pic3']?>"><img src="../<?php echo $prod['pic3']?>" alt="Photo 3"></a>
            </div>
            <div class="carousel-item">
                <a href="../<?php echo $prod['pic4']?>"><img src="../<?php echo $prod['pic4']?>" alt="Photo 4"></a>
            </div>
            <div class="carousel-item">
                <a href="../<?php echo $prod['pic5']?>"><img src="../<?php echo $prod['pic5']?>" alt="Photo 5"></a>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
        </a>
    </div>
    <h1><?php echo $prod['title']?></h1>
    <div class="other-details">
        <h3>At <?php echo getVendorName($db, $prod['vendor'])?></h3>
        <h3><?php echo getVendorLocation($db, $prod['vendor'])?></h3>
        <button><?php echo $prod['pph']?> EGP/hour</button>
        <a href="<?php echo getVendorLocationLink($db, $prod['vendor'])?>">
            <button type="button">
                <i class="fas fa-map-pin"></i>
            </button>
        </a>
        <!-- <button><a href="<?php //echo getVendorLocationLink($db, $prod['vendor'])?>">Go</a></button> -->
    </div>
<?php
?>
<hr>
<div id="buttons">
    <button id="previousBtn" disabled>Previous Day</button>
    <button id="nextBtn">Next Day</button>
</div>
<form method="POST" class="booker" id="booker">
    <?php booker($db, $id); 
    if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false")) {?>
        <h2>     Total: <span id="selectedCount">0</span> EGP</h2>
        <div class="stars">
            <input type="radio" id="cash" required>
            <label for="cash">Pay in Cash</label>
            <input type="radio" id="online" disabled>
            <label for="online">Pay Online (Coming Soon!)</label>
        </div>
        <input type="submit" id="submit" name="submit" value="Reserve">
        <h6>*Promo codes are applied after reserving from My Reservations</h6>
    <?php } ?>
</form>
<?php 
if(isset($_POST['submit'])) {
    if((isset($_SESSION['userli'])) && ($_SESSION['userli'] != "false")) {
        if(userIsBlocked($db, $_SESSION['userli'])) {
            echo "<script>window.location.href = 'blocked.php';</script>";
        }
        $selected = $_POST['id'];
        $user = $_SESSION['userli'];
        $p = $id;
        $pos = getProductPPH($db, $p);
        $rid = getNextResID($db);
        foreach($selected as $s) {
            $success = false;
            if(checkAvailibility($db, $p, $s)) {
                $resat = getCurrentTimeSlot();
                $db->query("INSERT INTO `reservations`(`reservation_id`, `slot`, `product_id`, `user`, `paid_online`, `price_of_slot`) VALUES('$rid', '$s', '$p', '$user', 0, '$pos')");
                $success = true;
                if($success)
                    echo "<script>window.location.href = 'thanks.php';</script>";

            }
        }
    } else {
        echo "<script>window.location.href = 'signinpage.php';</script>";
    }
}}
?>
<hr><h1>About <?php echo $prod['title']?></h1>
<p><?php echo $prod['desc']?></p>
<h1>About <?php echo getVendorName($db, $prod['vendor'])?></h1>
<p><?php echo getVendorDesc($db, $prod['vendor'])?></p>
<?php getVendorOtherProds($db, $prod['vendor'], $id);?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
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
    <script>
        // Get the checkboxes and the dynamic component
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const selectedCount = document.getElementById('selectedCount');

        // Function to update the selected count
        function updateSelectedCount() {
        const count = document.querySelectorAll('input[type="checkbox"]:checked').length;
        selectedCount.textContent = count * <?php echo $prod['pph']?>;
        }

        // Add event listener to each checkbox
        checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
