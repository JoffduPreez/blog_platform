<?php
require 'classes/Article.php';
require 'classes/Database.php';
require 'classes/User.php';
session_start();

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
$following = User::getFollowing($conn, $_SESSION['login_id']); 
?>

<?php require 'includes/header.php' ?>
        <div id="main-container">
            <div id="new-post-container">
                <form action="" method="get" id="new-article">
                    <input name="title" type="text" placeholder="Title" id="new-article-title" value="<?= htmlspecialchars($title); ?>">
                    <textarea name="content" placeholder="Content" id="new-article-body"><?= htmlspecialchars($content); ?></textarea>
                    <label for="new-article-date" id="publication-label">Publication date and time</label>
                    <input type="datetime-local" name="published_at" id="new-article-date" value="<?= htmlspecialchars($published_at); ?>">
                </form>
                <div id="submit-container">
                    <a href="article.php?id=<?= $article->id; ?>" class="article-button">Cancel</a>
                    <button type="submit" class="article-button" form="new-article">Update</button>
                </div>
            </div>
        </div>
    
        <div id="following">
            <h3>Following</h3>
    
            <?php if (empty($following)): ?>
                <p>You don't follow anyone</p>
            <?php else: ?>
                <?php foreach ($following as $user): ?>
                    <div class="user">
                        <div class="pfp"></div>
                        <a href="profile.php?id=<?= $user['id']; ?>"><?= $user['username']; ?></a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
<?php require 'includes/footer.php' ?>