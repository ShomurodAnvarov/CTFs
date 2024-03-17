<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$file = $_GET['file'];

// Path traversal vulnerability
$path = 'uploads/' . $file;

if (file_exists($path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    readfile($path);
    exit;
} else {
    echo "File not found.";
}
?>
