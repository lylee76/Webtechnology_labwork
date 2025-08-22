<?php
    session_start();

    // Destroy session
    session_unset();
    session_destroy();

    // Clear cookies
    setcookie('email', '', time()-1);
    setcookie('name', '', time()-1);
    setcookie('userid', '', time()-1);

    // Debugging output
    echo "Logging out...";

    // Redirect to login page
    header('Location: index.php');
    exit();
?>
