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

// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Validate form data
  $errors = []; // Array to store any validation errors

  // Validate item name (optional)
  if (empty($_POST['itemName'])) {
    $errors[] = "item name is required.";
  }

  // Validate quantity (numeric, positive)
  if (!is_numeric($_POST['quantity']) || $_POST['quantity'] <= 0) {
    $errors[] = "Invalid quantity. Please enter a positive number.";
  }

  // Validate price (numeric, non-negative)
  if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
    $errors[] = "Invalid price. Please enter a non-negative number.";
  }

  // Validate expiry date (optional, basic check)
  if (empty($_POST['expiryDate'])) {
    $errors[] = "Expiry date is required.";
  }

  // Handle data processing if no errors
  if (empty($errors)) {
    $itemName = mysqli_real_escape_string($conn, $_POST['itemName']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $expiryDate = $_POST['expiryDate'];

  
    // Prepare SQL statement for insertion
   // $sql = "INSERT INTO items (name, qty, price, expiry_date)
            // VALUES (?,?,?,?)";
    $stmt = $conn->prepare("INSERT INTO items (name, qty, price, expiry_date)
    VALUES (?,?,?,?)");

    // Bind parameters and execute insertion
    $stmt->bind_param("ssss", $itemName, $quantity, $price, $expiryDate);
    if ($stmt->execute()) {
      echo "item added successfully!"; // Success message
    } else {
      echo "Error adding item: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
  } else {
    // Display any validation errors
    echo "<b>Please fix the following errors:</b><br>";
    foreach ($errors as $error) {
      echo "- " . $error . "<br>";
    }
  }
}
