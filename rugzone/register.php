<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if users.txt exists; create if not
    if (!file_exists("users.txt")) {
        file_put_contents("users.txt", "");
    }

    // Prevent duplicate usernames
    $file = fopen("users.txt", "r");
    while (($line = fgets($file)) !== false) {
        list($stored_user, $stored_pass) = explode("|", trim($line));
        if ($stored_user === $username) {
            fclose($file);
            echo "<h1>Username already exists!</h1>";
            echo "<p><a href='register.html'>Try a different username</a></p>";
            exit;
        }
    }
    fclose($file);

    // Save new user to users.txt
    $file = fopen("users.txt", "a") or die("Unable to open file!");
    if (flock($file, LOCK_EX)) {
        fwrite($file, "$username|$password\n"); // Added the delimiter |
        flock($file, LOCK_UN);
    }
    fclose($file);

    echo "<h1>Account successfully created!</h1>";
    echo "<p><a href='login.html'>Login here</a></p>";
}
?>
