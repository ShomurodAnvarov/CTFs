<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello Users, is your network reachable? test it with our secure services</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .result {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .blocked-img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card my-5">
                    <div class="card-body">
                        <h3 class="card-title">Hello Users, is your network reachable? Test it with our secure services</h3>
                        <h7>We trust any user input</h7>
                        <form method="POST" action="#ping" class="mb-3">
                            <div class="form-group">
                                <label for="ip">Enter the IP address to ping:</label>
                                <input type="text" class="form-control" id="ip" name="ip" placeholder="8.8.8.8">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Ping me">
                        </form>

                        <form method="POST" action="#whois" class="mb-3">
                            <div class="form-group">
                                <label for="domain">WHOIS Lookup:</label>
                                <input type="text" class="form-control" id="domain" name="domain" placeholder="example.com">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Lookup">
                        </form>

                        <form method="POST" action="#nslookup">
                            <div class="form-group">
                                <label for="ns">NS Lookup:</label>
                                <input type="text" class="form-control" id="ns" name="ns" placeholder="example.com">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Lookup">
                        </form>
                        <!-- <div  style="color: white;" class="form-group">
                        it works like this,   <br>thecommand="ping -c 3" +(your-input-here)+";"
                                 <br>execute thecommand;
                                 <br>echo results;
                        </div> -->
                    </div>
                </div>

                <div class="result">
                    <?php
                    if (isset($_POST['ip'])) {
                        $input = $_POST["ip"];
                        $blacklist = array('\'','whoami', 'id', 'busybox');
                        foreach ($blacklist as $item) {
                            if (strpos($input, $item) !== false) {
                                echo "<img src='https://iili.io/JM6lUTx.jpg' class='blocked-img'>";
                                $input = str_replace($item, "", $input);
                            }
                        }
                        $output = shell_exec("ping -c 3 " . $input);
                        echo "<pre>" . htmlspecialchars($output) . "</pre>";
                    }

                    if (isset($_POST['domain'])) {
                        $domain = escapeshellarg($_POST["domain"]);
                        $output = shell_exec("whois " . $domain);
                        echo "<pre>" . htmlspecialchars($output) . "</pre>";
                    }

                    if (isset($_POST['ns'])) {
                        $ns = escapeshellarg($_POST["ns"]);
                        $output = shell_exec("nslookup " . $ns);
                        echo "<pre>" . htmlspecialchars($output) . "</pre>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
