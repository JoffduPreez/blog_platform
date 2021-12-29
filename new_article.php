<?php
require 'classes/Article.php';
require 'classes/Database.php';
require 'includes/redirect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    $conn = Database::getConnection();
    Article::newArticle($conn, $title, $content, $published_at);
}
?>


<?php require 'includes/header.php'; ?>
<form method="post">
    <h1>TEST 1</h1>
    <div>
        <label for="title">Title</label>
        <input name="title" id="title" placeholder="Article title" value="<?= htmlspecialchars($title); ?>">
    </div>

    <div>
        <label for="content">Content</label>
        <textarea name="content" rows="4" cols="40" id="content" placeholder="Article content"><?= htmlspecialchars($content); ?></textarea>
    </div>

    <div>
        <label for="published_at">Publication date and time</label>
        <input type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($published_at); ?>">
    </div>

    <button>Save</button>
</form>
<?php require 'includes/footer.php'; ?>