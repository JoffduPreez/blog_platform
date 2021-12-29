<?php
require 'classes/Database.php';
require 'classes/User.php';
include 'includes/redirect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $conn = Database::getConnection();

    $errors = User::registerUser($conn, $_POST['username'], $_POST['password'], $_POST['confirmPass']);
    if (empty($errors)) {
        redirect("/");
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
        <h1>Sign up</h1>
        <h4>Welcome! Create an account</h4>

        <?php if (! empty($errors)) : ?>
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

            <div>
                <label for="confirmPass">Confirm Password</label>
                <input type="password" name="confirmPass" id="confirmPass">
            </div>

            <button>Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </main>
</body>
</html>