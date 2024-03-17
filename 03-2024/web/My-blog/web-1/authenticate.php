<?php
session_start();

// Load or initialize the attempt counter for this IP
$ip = $_SERVER['REMOTE_ADDR'];
$attempts_file = "attempts/{$ip}.json";

if (file_exists($attempts_file)) {
    $attempts_data = json_decode(file_get_contents($attempts_file), true);
} else {
    $attempts_data = ['count' => 0];
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$valid_username = 'admin';
$valid_password_hash = '482c811da5d5b4bc6d497ffa98491e38';

// Check for SQL injection parameters
$sqlInjectionPatterns = ['\'', '`', '|','select'];
foreach ($sqlInjectionPatterns as $pattern) {
    if (strpos($username, $pattern) !== false || strpos($password, $pattern) !== false) {
        echo "<img height=40%  width=40%  src='https://iili.io/JM6lUTx.jpg'>";
        exit;
    }
}

if ($username === $valid_username && md5($password) === $valid_password_hash) {
    $_SESSION['loggedin'] = true;
    header('Location: profile.php');
    exit;
} else {
    // Increment the attempt counter
    $attempts_data['count']++;

    // Save the updated attempt data
    file_put_contents($attempts_file, json_encode($attempts_data));

    // Custom message after 3 failed attempts
    if ($attempts_data['count'] > 3) {
        echo "Just a tip for you: brute forcing credentials is not recommended and it is a waste of your time.";
    } else {
        echo "Invalid credentials.";
    }
}
?>
