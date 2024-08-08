<?php
$servername = "localhost";
$username = "root";
$password = "hiitsme123";
$dbname = "pharma";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['uname'];
$password = $_POST['pword'];

// Validate and sanitize user input
$username = $conn->real_escape_string($username);

$stmt = $conn->prepare("SELECT username, password FROM details WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($db_username, $db_password);
$stmt->fetch();

echo "DB Username: " . $db_username . "<br>";
echo "DB Password: " . $db_password . "<br>";

if (password_verify($password, $db_password)) {
    header("Location: dashboard.html");
    exit();
} else {
    echo "Login failed. Incorrect username or password.";
}

$stmt->close();
$conn->close();
?>
