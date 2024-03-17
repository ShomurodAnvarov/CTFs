<?php

$results = [];

if (isset($_SERVER['REQUEST_METHOD']) && strcasecmp("post", $_SERVER['REQUEST_METHOD']) == 0) {

    $item = $_POST['item'] ?? '';
    $description = $_POST['description'] ?? '';
    $catid = $_POST['catid'] ?? ''; // This field is intentionally left vulnerable to SQL injection

    // Using prepared statements for the item and description fields to prevent SQL injection
    $query = "SELECT products.name as item, category.category_name as category, products.description as description 
              FROM products 
              INNER JOIN category ON products.catid = category.catid 
              WHERE products.name LIKE :item 
              AND products.description LIKE :description";

    // Intentionally concatenating the $catid variable to make the category field vulnerable to SQL injection
    if (!empty($catid)) {
        $query .= " AND category.catid = " . $catid;
    }

    $host = "localhost";
    $db = "appdb";
    $user = "appuser";
    $pass = "appsecret123";
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $stmt = $pdo->prepare($query);
        $stmt->execute(['item' => '%' . $item . '%', 'description' => '%' . $description . '%']);
        $results = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<title>Juice Shop</title>
<style>
    .search-form {
        margin: 20px 0;
    }
    .search-form label {
        margin-right: 10px;
    }
    .search-form input[type="text"] {
        margin-right: 10px;
    }
    .search-form select {
        margin-right: 10px;
    }
    .search-form input[type="submit"] {
        margin-top: 5px;
    }
    .search-results {
        margin-top: 20px;
    }
</style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-sm">
    <div class="container">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li> 
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Welcome</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.html">About</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="jumbotron mt-4">
        <h1 class="display-4">Juice Shop</h1>
        <p class="lead">This is a  Shop that can be used for purchase items. There are several items available for sale here.<br>Check it out and have fun! </p>
    </div>

    <div class="search-form">
        <form action="welcome.php" method="POST">
        <input type="submit" value="Search" class="btn btn-primary">
            <label for="item">Item:</label>
            <input type="text" name="item" class="form-control" placeholder="Enter item name">
            <label for="description">Description:</label>
            <input type="text" name="description" class="form-control" placeholder="Enter description">
            <label for="catid">Category:</label>
            <select name="catid" class="form-control">
                <option value="1000">Drinks</option>
                <option value="1001">Snacks</option>
                <option value="1002">Fruits</option>
                <option value="1003">Lunch boxes</option>
            </select>
          </form>
    </div>

    <div class="search-results">
        <?php
        if (!empty($results)) {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($results as $result) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($result['item']) . "</td>";
                        echo "<td>" . htmlspecialchars($result['category']) . "</td>";
                        echo "<td>" . htmlspecialchars($result['description']) . "</td>";
                        echo "</tr>\n";
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
