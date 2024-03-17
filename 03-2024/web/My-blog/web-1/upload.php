<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$target_dir = "uploads/";
$imageFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
$maxFileSize = 2 * 1024 * 1024; // 2 MB

// Check file size
if ($_FILES["file"]["size"] > $maxFileSize) {
    echo "Sorry, your file is too large. Maximum file size is 2 MB.";
    exit;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png") {
    echo "Sorry, only JPG and PNG files are allowed.";
    exit;
}

$target_file = $target_dir . "profile." . $imageFileType;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    // Redirect to profile page
    header('Location: profile.php');
    exit;
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
