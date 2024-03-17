<?php

$results = [];

if (isset($_SERVER['REQUEST_METHOD']) && strcasecmp("post", $_SERVER['REQUEST_METHOD']) == 0) {
    if (!isset($_POST['search'])) {
        die("Please enter a last name to search!");
    }

    $search = $_POST['search'];

    // Using prepared statements to prevent SQL injection
    $query = "SELECT firstname FROM users WHERE BINARY lastname LIKE :search";

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
        $stmt->execute(['search' => '%' . $search . '%']);
        $results = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="juice-shop-styles.css">
    <title>Juice Shop</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Juice Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="welcome.php">Welcome</a>
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
<h7 style="color: white; display: block; text-align: center;">"SELECT firstname FROM users WHERE BINARY lastname LIKE :search"</h7>

    <div class="container mt-5">
        <h3 class="text-center mb-4">Search for existing Users</h3>
            
            <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="index.php" method="POST" class="form-inline justify-content-center">
                    <input type="text" name="search" class="form-control mb-2 mr-sm-2" placeholder="Enter last name">
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </form>
            </div>
        </div>
        <?php if (!empty($results)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>First Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result) { ?>
                            <tr>
                                <td><?= htmlspecialchars($result['firstname']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
