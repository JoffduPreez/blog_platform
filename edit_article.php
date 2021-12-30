<?php
require 'classes/Article.php';
require 'classes/Database.php';

$conn = Database::getConnection();
if (isset($_GET['id'])) {
    $article = Article::getArticleByID($conn, $_GET['id']);
    $title = $article->title;
    $content = $article->content;
    $published_at = $article->published_at;
} else {
    $article = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    $conn = Database::getConnection();
    $errors = Article::editArticle($conn, $title, $content, $published_at, $id);
}
?>


<?php require 'includes/header.php'; ?>
<h2>Edit article</h2>
<?php require 'includes/article_form.php'; ?>
<?php require 'includes/footer.php'; ?>