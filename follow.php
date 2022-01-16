<?php
require 'classes/User.php';
require 'classes/Database.php';
require 'includes/redirect.php';
session_start();

$conn = Database::getConnection();
User::followUser($conn, $_SESSION['login_id'], $_GET['id']);
redirect("/user_list.php");