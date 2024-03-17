<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
$filename = $_GET['filename'] ?? '';
$filepath = "uploads/" . $filename; // path traversal vulnerability

if (file_exists($filepath)) {
    $fileExtension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
    if ($fileExtension == "jpg") {
        header('Content-Type: image/jpeg');
    } elseif ($fileExtension == "png") {
        header('Content-Type: image/png');
    } else {
        // Handle other file types or restrict to only images if needed
        header('Content-Type: application/octet-stream');
    }
    readfile($filepath);
} else {
    echo "File not found.";
}
?>
