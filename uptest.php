<?php 
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
  
    // Check if the file is an image (JPEG, PNG, or JPG)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = $file['type'];
    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>alert('Error: Only JPEG, PNG, and JPG images are allowed.');</script>";
        exit;
    }
  
    // Check if the file size is within the limit (12 megabytes)
    $maxFileSize = 12 * 1024 * 1024; // 12 megabytes
    $fileSize = $file['size'];
    if ($fileSize > $maxFileSize) {
        echo "<script>alert('Error: The file size exceeds the maximum limit of 12 megabytes.');</script>";
        exit;
    }
    echo "<script>alert('File is valid.');</script>";
} else {
    echo "<script>alert('Error: No file was uploaded.');</script>";}
?>