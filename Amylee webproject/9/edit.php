<?php
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

// Get book ID from URL
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($book_id > 0) {
    // Prepare and execute query to fetch book data
    $stmt = $conn->prepare("SELECT title, publisher, author, edition, no_of_page, price, publish_date, isbn FROM users WHERE id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->bind_result($title, $publisher, $author, $edition, $no_of_page, $price, $publish_date, $isbn);
    $stmt->fetch();
    $stmt->close();
} else {
    die("Invalid book ID.");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>
    <h2>Edit Book</h2>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $book_id; ?>">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>

        <label for="publisher">Publisher:</label>
        <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>" required><br><br>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required><br><br>

        <label for="edition">Edition:</label>
        <input type="number" id="edition" name="edition" value="<?php echo htmlspecialchars($edition); ?>" required><br><br>

        <label for="no_of_page">Number of Pages:</label>
        <input type="number" id="no_of_page" name="no_of_page" value="<?php echo htmlspecialchars($no_of_page); ?>" required><br><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required><br><br>

        <label for="publish_date">Publish Date:</label>
        <input type="date" id="publish_date" name="publish_date" value="<?php echo htmlspecialchars($publish_date); ?>" required><br><br>

        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($isbn); ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>