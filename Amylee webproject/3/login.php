<?php

// Database credentials 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get user inputs
$email = $_POST["email"];
$password = $_POST["password"];

// Check if email exists
$sql = "SELECT * FROM registration WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  header("Location: login.php?error=Invalid email or password");
  exit();
} else {
  $row = $result->fetch_assoc();
  $storedPassword = $row["password"];

  // Important: You should compare the entered password with the  password stored in the database
  if ($password==$storedPassword) {
    echo "Login Successfull"; 
    $conn->close();
    exit();
  } else {
    header("Location: login.php?error=Invalid email or password");
    $conn->close();
    exit();
  }
}
?>