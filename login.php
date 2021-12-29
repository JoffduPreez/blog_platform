<?php
require 'includes/redirect.php';
require 'classes/Database.php';
require 'classes/User.php';

session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $conn = Database::getConnection();

    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {
        User::login();
        redirect('/article_list.php');
    } else {
        array_push($errors, 'login incorrect');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Post System</title>
    <meta charset="utf-8">
</head>
<body>
    <main>
        <h1>Login</h1>
        <h4>Welcome back! Please login with your credentials</h4>

        <?php if (!empty($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>    
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post">
            <div>
                <label for="username">Username</label>
                <input name="username" id="username">
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>

            <button>Log in</button>
        </form>

        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </main>
</body>
</html>
