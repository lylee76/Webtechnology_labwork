<?php
    session_start();
    if(!isset($_SESSION['user_data'])){
        header('location:index.php');
       
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Dashboard </h1>
    <p>Welcome <?php echo $_SESSION['user_data'] ['name']; ?></p>
    <a href="./logout.php">Logout</a>
    
</body>
</html>