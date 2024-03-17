<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            width: 300px;
            margin: 100px auto;
        }
        .login-form {
            margin-top: 20px;
        }
        .login-form label {
            font-weight: bold;
        }
        .login-form input[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <h2 class="text-center">Login</h2>
        <form class="login-form" method="POST" action="authenticate.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Login">
        </form>
    </div>
</body>
</html>
