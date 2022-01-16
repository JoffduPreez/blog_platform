<?php
require 'classes/Article.php';
require 'classes/Database.php';
require 'classes/User.php';
session_start();


$conn = Database::getConnection();
if (isset($_GET['id'])) {
    $article = Article::getArticleByID($conn, $_GET['id']);
} else {
    $article = null;
}
$following = User::getFollowing($conn, $_SESSION['login_id']);
$user = User::getCurrentUser($conn, $article->user_id);
?>

<?php require 'includes/header.php' ?>
        <div id="main-container">
            <div id="article-container">
                <div id="article-body">
                    <div class="user">
                        <div class="pfp"></div>
                        <p><?= $user[0]['username']; ?></p>
                    </div>
                    <?php if ($article) : ?>
                        <h2><?= htmlspecialchars($article->title); ?></h2>
                        <p><?= htmlspecialchars($article->content); ?></p>
                    <?php endif; ?>
                </div>
                <div id="submit-container">
                    <a href="edit_article.php?id=<?= $article->id; ?>" class="article-button">Edit</a>
                    <a href="delete_article.php?id=<?= $article->id; ?>" class="article-button">Delete</a>
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