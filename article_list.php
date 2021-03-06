<?php
require 'classes/Article.php';
require 'classes/User.php';
require 'classes/Database.php';
session_start();

$conn = Database::getConnection();
$articles = Article::getAllArticles($conn, $_SESSION['login_id']); // change this
$following = User::getFollowing($conn, $_SESSION['login_id']);


// var_dump($articles);
?>

<?php require 'includes/header.php' ?>
        <div id="main-container">
            <div id="new-post-container">
                <form action="new_article.php" method="post" id="new-article">
                    <input name="title" type="text" placeholder="Title" id="new-article-title">
                    <textarea name="content" placeholder="Content" id="new-article-body"></textarea>
                    <label for="new-article-date" id="publication-label">Publication date and time</label>
                    <input type="datetime-local" name="published_at" id="new-article-date">
                </form>
                <div id="submit-container">
                    <button type="submit" form="new-article" class="article-button">Publish</button>
                </div>
            </div>

            <?php if (empty($articles)): ?>
                <p>No articles found.</p>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <?php $currentUser = User::getCurrentUser($conn, $article['user_id']); ?>
                    <div class="post">
                        <div class="pfp"></div>
                        <div class="post-body">
                            <a href="profile.php?id=<?= $currentUser[0]['id']; ?>" class="username"><?= htmlspecialchars($currentUser[0]['username']); ?></a>
                            <a href="article.php?id=<?= $article['id']; ?>" class="article-title"><?= htmlspecialchars($article['title']); ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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