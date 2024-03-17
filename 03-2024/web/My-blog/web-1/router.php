<?php
// Log the request details
file_put_contents(
    'php_server.log',
    sprintf(
        "[%s] %s: %s %s\nUser-Agent: %s\n\n",
        date('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI'],
        $_SERVER['HTTP_USER_AGENT']
    ),
    FILE_APPEND
);

// Log POST request body if present
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents(
        'php_server.log',
        "POST Body:\n" . file_get_contents('php://input') . "\n\n",
        FILE_APPEND
    );
}

// Serve the requested resource as usual
return false;
?>
