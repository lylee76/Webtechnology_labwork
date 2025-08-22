<?php

// Database credentials (replace with your actual values)
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
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$faculty = $_POST["faculty"];

// Check if email already exists
$sql = "SELECT * FROM registration WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Email already exists
  header("Location: registration.php?error=Email already exists");
  exit();
}

// Construct the SQL INSERT query
$sql = "INSERT INTO registration (name, email, password, phone, gender, faculty) VALUES ('$name', '$email', '$password', '$phone', '$gender', '$faculty')";

// Execute the query
if ($conn->query($sql) === TRUE) {
  echo "Registration successful!";
} else {
  echo "Error: " . $conn->error;
}

$conn->close();

?>