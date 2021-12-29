<?php

$db_host = "localhost";
$db_name = "blog_platform";
$db_user = "joffre";
$db_pass = "joffre$$";
$title = $_POST['title'];
$content = $_POST['content'];
$published_at = $_POST['published_at'];
$dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

try {
    $conn = new PDO($dsn, $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT *
            FROM articles
            WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":id", $_GET['id'], PDO::PARAM_INT);

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

    if ($stmt->execute()) {
        $article = $stmt->fetch();
    }

} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
?>


<?php require 'includes/header.php'; ?>

<?php if ($article) : ?>
    <article>
        <h2><?= htmlspecialchars($article['title']); ?></h2>
        <p><?= htmlspecialchars($article['content']); ?></p>
    </article>

    <a href="edit-article.php?id=<?= $article['id']; ?>">Edit</a>
    <a href="delete-article.php?id=<?= $article['id']; ?>">Delete</a>

<?php else : ?>
    <p>Article not found.</p>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>