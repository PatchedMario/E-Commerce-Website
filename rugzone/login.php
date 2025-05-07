<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    // Check if the file exists
    if (!file_exists("users.txt")) {
        echo "<h1>Login failed!</h1>";
        echo "<p><a href='login.html'>Try again</a></p>";
        exit;
    }

    $file = fopen("users.txt", "r");
    $valid = false;

    while (($line = fgets($file)) !== false) {
        list($stored_user, $stored_pass) = explode("|", trim($line));

        if ($stored_user === $username && password_verify($password, $stored_pass)) {
            $valid = true;
            break;
        }
    }
    fclose($file);

    if ($valid) {
        echo "<h1>Welcome, $username!</h1>";
        echo "<p><a href='index.html'>Go to homepage</a></p>";
    } else {
        echo "<h1>Login failed!</h1>";
        echo "<p><a href='login.html'>Try again</a></p>";
    }
}
?>
