<?php
require 'classes/Article.php';
require 'classes/User.php';
require 'classes/Database.php';
session_start();

$conn = Database::getConnection();
$articles = Article::getAllArticles($conn, $_GET['id']);
$following = User::getFollowing($conn, $_SESSION['login_id']); 
$currentUser = User::getCurrentUser($conn, $_GET['id']);
// var_dump($articles);
?>

<?php require 'includes/header.php' ?>
        <div id="main-container">
            <div id="profile-container">
                <div id="profile-body">
                    <div class="user">
                        <div class="pfp"></div>
                        <p><?= $currentUser[0]['username']; ?></p>
                    </div>
                    <?php if ($currentUser[0]['bio']) : ?>
                        <p><?= $currentUser[0]['bio']; ?></p>
                    <?php else : ?>
                        <p>This user has no bio</p>
                    <?php endif; ?>
                </div>
                <div id="submit-container">
                    <a href="edit_profile.php?id=<?= $_GET['id']; ?>" class="article-button">Edit profile</a>
                </div>
            </div>

            <?php if (empty($articles)): ?>
                <p>This user has no articles</p>
            <?php else: ?>
                <?php foreach ($articles as $article): ?>
                    <div class="post">
                        <div class="pfp"></div>
                        <div class="post-body">
                            <h3 class="username">Username</h3>
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