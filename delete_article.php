<?php
require 'classes/Article.php';
require 'classes/Database.php';

$conn = Database::getConnection();
Article::deleteArticle($conn, $_GET['id']);
?>