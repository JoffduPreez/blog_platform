<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
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
    <div id="flex-container">
        <nav id="navbar">
            <a href="article_list.php">Home</a>
            <a href="user_list.php">Explore</a>
            <a href="profile.php?id=<?= $_SESSION['login_id']; ?>">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>