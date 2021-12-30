<?php
require 'classes/Article.php';
require 'classes/Database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    $conn = Database::getConnection();
    $errors = Article::newArticle($conn, $title, $content, $published_at, intval($_SESSION['login_id']));
}
?>


<?php require 'includes/header.php'; ?>
<h2>Create article</h2>
<?php require 'includes/article_form.php'; ?>
<?php require 'includes/footer.php'; ?>