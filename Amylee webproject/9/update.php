<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "book";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data and ensure all required fields are set
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $publisher = isset($_POST['publisher']) ? $_POST['publisher'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $edition = isset($_POST['edition']) ? intval($_POST['edition']) : 0;
    $no_of_page = isset($_POST['no_of_page']) ? intval($_POST['no_of_page']) : 0;
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.00;
    $publish_date = isset($_POST['publish_date']) ? $_POST['publish_date'] : '';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';

    // Check if all required fields have values
    if ($id > 0 && $title && $publisher && $author && $edition && $no_of_page && $price && $publish_date && $isbn) {
        // Prepare and bind
        $stmt = $conn->prepare("UPDATE users SET title = ?, publisher = ?, author = ?, edition = ?, no_of_page = ?, price = ?, publish_date = ?, isbn = ? WHERE id = ?");
        if ($stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("sssiidssi", $title, $publisher, $author, $edition, $no_of_page, $price, $publish_date, $isbn, $id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close connections
        $stmt->close();
    } else {
        echo "All fields are required.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
