<?php
require 'classes/Article.php';
require 'classes/Database.php';

$conn = Database::getConnection();
$article = Article::getArticleByID($conn, $_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    $conn = Database::getConnection();
    Article::editArticle($conn, $title, $content, $published_at, $id);
}
?>


<?php require 'includes/header.php'; ?>
<h2>Edit article</h2>
<?php require 'includes/article_form.php'; ?>
<?php require 'includes/footer.php'; ?>