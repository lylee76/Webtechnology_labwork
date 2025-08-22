<?php
session_start();

if (isset($_COOKIE['email'])) {
    $_SESSION['user_data']['name'] = $_COOKIE['name'];
    $_SESSION['user_data']['email'] = $_COOKIE['email'];
    $_SESSION['user_data']['id'] = $_COOKIE['userid'];
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = [];
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'Enter a valid email';
    }

    if (empty($password)) {
        $error['password'] = 'Enter password';
    }

    if (count($error) == 0) {
        try {
            $connection = new mysqli('localhost', 'root', '', 'student');

            if ($connection->connect_error) {
                throw new Exception('Database connection failed: ' . $connection->connect_error);
            }

            $stmt = $connection->prepare('SELECT * FROM users WHERE User_email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();

                // Verify password
                if ($password==$user['User_password']) {
                    if (isset($_POST['remember'])) {
                        setcookie('email', $email, time() + (7 * 24 * 60 * 60));
                        setcookie('name', $user['name'], time() + (7 * 24 * 60 * 60));
                        setcookie('userid', $user['id'], time() + (7 * 24 * 60 * 60));
                    }

                    $_SESSION['user_data'] = [
                        'name' => $user['name'],
                        'email' => $user['User_email'],
                        'id' => $user['id']
                    ];

                    header('Location: dashboard.php');
                    exit();
                } else {
                    echo "$password";
                    $error['general'] = 'Login failed: Incorrect password';
                }
            } else {
                $error['general'] = 'Login failed: User not found';
            }

            $stmt->close();
            $connection->close();
        } catch (Exception $e) {
            die('Database Error: ' . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" placeholder="Enter email" value="<?php echo htmlspecialchars($email ?? ''); ?>" />
        <?php echo $error['email'] ?? ''; ?>
        <br />
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter password" value="<?php echo htmlspecialchars($password ?? ''); ?>" />
        <?php echo $error['password'] ?? ''; ?>
        <br />
        <input type="checkbox" name="remember" value="remember"> Remember me
        <br />
        <input type="submit" value="Login" name="login">
    </form>
    <?php if (isset($error['general'])): ?>
        <p><?php echo $error['general']; ?></p>
    <?php endif; ?>
</body>
</html>
