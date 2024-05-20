<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <style>
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
    <title>Reservy</title>
</head>
<body>
    <?php 
    include "../restricted/config.php";
    ?>
    <?php
    $feat = getFeatured($db);
    $count = mysqli_num_rows($feat);
    $i = 0;
    if($count > 0) {
        echo '<div id="myCarousel" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
        while($row = $feat->fetch_assoc()) {
            if($i == 0) {
                echo '<div class="carousel-item active">';
                $i++;
            } else {
                echo '<div class="carousel-item">';
            }
            echo '<a href="product.php?id='.$row['product_id'].'">';
            echo '<img src="../'.$row['cover'].'" alt="Featured photo"></a>';
            echo '</div>';
        }
        if($count > 1) {
            echo '</div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>'; 
        } else {    
            echo '</div>';
        }
        
        echo '</div>';
        
    } else { echo '<br><br><br>';}
    ?>
    <div class="grid-wrapper">
        <div class="image-grid">
            <a href="catList.php?cat=Padel">
                <img src="../media/img2.png" alt="Padel">
            </a>
            <a href="catList.php?cat=Football">
                <img src="../media/img1.png" alt="Football">
            </a>
            <a href="catList.php?cat=Workspaces">
                <img src="../media/img3.png" alt="Workspaces">
            </a>
            <a href="catList.php?cat=Venues">
                <img src="../media/img4.png " alt="Venues">
            </a>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>