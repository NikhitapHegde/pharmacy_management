<?php
$servername = "localhost";
$username = "root";
$password = "hiitsme123";
$dbname = "pharma";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$username = $_POST['uname'];
$password = $_POST['pword'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);


$stmt = $conn->prepare("INSERT INTO details (name, username, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $username, $hashed_password);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
