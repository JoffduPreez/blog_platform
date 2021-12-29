<?php
require 'classes/Article.php';
require 'classes/Database.php';

$conn = Database::getConnection();
$articles = Article::getAllArticles($conn);

?>
<h1>TEST 1</h1>

<?php require 'includes/header.php'; ?>
<a href="new_article.php">New article</a>
<?php if (empty($articles)): ?>
    <p>No articles found.</p>
<?php else: ?>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <article>
                    <h3><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h3>
                    <p><?= htmlspecialchars($article['content']); ?></p>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>