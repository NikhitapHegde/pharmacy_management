<?php
// Database connection (replace with your actual connection details)
$servername = "localhost";
$username = "root";
$password = "Poornima16@23";
$dbname = "phm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to fetch in-stock medicines (assuming a "qty" column)
$sql = "SELECT * FROM items WHERE qty > 0";
$result = $conn->query($sql);

$medicineList = [];

if ($result === false) {
  die("Error executing query: " . $conn->error);
}

if ($result->num_rows > 0) {
  // Loop through results and add to array
  while ($row = $result->fetch_assoc()) {
    $medicineList[] = $row;
  }
}

// Close connection
$conn->close();

// Encode medicine list as JSON and return
echo json_encode($medicineList);
?>
