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
        redirect("article_list.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato|Staatliches" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Blog post system</title>
</head>
<body>
    <div id="login-body">
        <div id="login-form">
            <h1>Sign up Form</h1>

            <?php if (! empty($errors)) : ?>
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?= $error ?></li>    
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form method="post">
                <input name="username" id="username" placeholder="Username">

                <input type="password" name="password" id="password" placeholder="Password">

                <input type="password" name="confirmPass" id="confirmPass" placeholder="Confirm Password">

                <button id="login-btn">Sign up</button>
            </form>

            <p>Already have an account? <a href="index.php">Login</a></p>
        </div>
    </div>
</body>
</html>