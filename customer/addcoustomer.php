<?php

// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $errors = []; // Array to store any validation errors

  // Validate customer name (optional)
  if (empty($_POST['customerName'])) {
    $errors[] = "Customer name is required.";
  }

  // Validate date of birth (optional)
  if (empty($_POST['dateOfBirth'])) {
    $errors[] = "Date of birth is required.";
  }

  // Validate mobile number (improved validation)
  $mobileNumber = trim($_POST['mobileNumber']);
  <span class="math-inline">pattern \= "/^\\d\{10\}</span>/";
  if (!preg_match($pattern, $mobileNumber)) {
    $errors[] = "Invalid mobile number. Please enter 10 digits.";
  }

  // Validate address (optional)
  if (empty($_POST['address'])) {
    $errors[] = "Address is required.";
  }

  // Validate medicine and other item data
  $medicineNames = $_POST['medicineName'];
  $medicineQuantities = $_POST['medicineQuantity'];
  $otherItemNames = $_POST['otherItemName'];
  $otherItemQuantities = $_POST['otherItemQuantity'];

  // Validate each medicine/item entry
  for ($i = 0; $i < count($medicineNames); $i++) {
    if (empty($medicineNames[$i]) || !is_numeric($medicineQuantities[$i]) || $medicineQuantities[$i] <= 0) {
      $errors[] = "Invalid medicine entry. Please check medicine name and quantity.";
      break; // Early exit if there's an error
    }
  }

  for ($i = 0; $i < count($otherItemNames); $i++) {
    if (empty($otherItemNames[$i]) || !is_numeric($otherItemQuantities[$i]) || $otherItemQuantities[$i] <= 0) {
      $errors[] = "Invalid other item entry. Please check item name and quantity.";
      break; // Early exit if there's an error
    }
  }

  // Handle data processing if no errors
  if (empty($errors)) {
    $customerId = $_POST['customerId'];
    $customerName = mysqli_real_escape_string($conn, $_POST['customerName']);
    $dateOfBirth = $_POST['dateOfBirth'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);

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

    // Prepare SQL statements to insert customer and medicine/item data
    $sqlCustomer = "INSERT INTO customer (id, name, date_of_birth, medicine_required,item_required, mobile_number, address)
                     VALUES (?, ?, ?, ?, ?)";
    $stmtCustomer = $conn->prepare($sqlCustomer);

 
    // Start transaction for data integrity
    $conn->begin_transaction();

    try {
      // Bind parameters and execute customer insert
      $stmtCustomer->bind_param("sssss", $customerId, $customerName, $dateOfBirth, $mobileNumber, $address);
      $stmtCustomer->execute();

      // Insert medicine data (loop through each entry)
      for ($i = 0; $i < count($medicineNames); $i++) {
        $stmtMedicine->bind_param("sss", $customerId, $medicineNames[$i], $medicineQuantities[$i]);
        $stmtMedicine->execute();
      }

           // Insert other item data (loop through each entry)
           for ($i = 0; $i < count($otherItemNames); $i++) {
            $stmtOtherItem->bind_param("sss", $customerId, $otherItemNames[$i], $otherItemQuantities[$i]);
            $stmtOtherItem->execute();
          }
    
          // Commit the transaction if all insertions successful
          $conn->commit();
          echo "Customer added successfully!"; // Success message
        } catch (Exception $e) {
          // Rollback transaction if any errors occur
          $conn->rollback();
          echo "Error adding customer: " . $e->getMessage();
        }
    
        // Close prepared statements and connection
        $stmtCustomer->close();
        $stmtMedicine->close();
        $stmtOtherItem->close();
        $conn->close();
      } else {
        // Display any validation errors
        echo "<b>Please fix the following errors:</b><br>";
        foreach ($errors as $error) {
          echo "- " . $error . "<br>";
        }
      }
    }
    