<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Users</title>
</head>
<body>
    <div class="big-wrapper">
        <?php 
        include "../restricted/config.php"; 
        if((isset($_SESSION['adminli'])) && ($_SESSION['adminli'] != "false")) {

        ?>
        <div class="small-wrapper">
            <br><br>
            <form method="POST">
                <table class="rep-table">
                    <thead><th><button type="submit" name="submit">Set to default name</button></th><th>Name</th><th>E-mail</th><th>Phone Number</th></thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM users";
                            $result = mysqli_query($db, $sql);
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<tr><td><input type="checkbox" name="id[]" value="' . $row['user'] . '"></td><td>' . $row['fname'] . " " . $row['lname'] . '</td><td>' . $row['user'] . '</td><td>' . $row['number'] . '</td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
        <?php 
        if(isset($_POST['submit']) && isset($_POST['id'])) {
            $selected = $_POST['id'];
            foreach($selected as $select) {
                $db->query("UPDATE users SET fname = 'Default', lname = 'Default' WHERE user = '$select'");
            }
            $done = true;
            if($done)
                echo "<script>window.location.href = '../viewUsers.php';</script>";
        }

        } else {
        $done = true;
        if($done)
            echo "<script>window.location.href = '../signinpage.php';</script>";
        }?>
    </div>
    
</body>
</html>