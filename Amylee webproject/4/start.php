<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php session</title>
</head>
<body>
    <?php
    $_SESSION["Firstname"]="Amylee";
    $_SESSION["lastname"]="Pakhrin";
    echo"Session variables are set.";
    ?>

    
</body>
</html>


