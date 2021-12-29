<?php

$db_host = "localhost";
$db_name = "blog_platform";
$db_user = "joffre";
$db_pass = "joffre$$";


// $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
// if ($conn->connect_error) {
//   die("Connection failed: " . mysqli_connect_error());
// }

// $sql = "SELECT *
//         FROM articles";
// $result = $conn->query($sql);
// $articles = $result->fetch_all(MYSQLI_ASSOC);


$dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

try {
    $db = new PDO($dsn, $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement = $db->query($sql);
    $articles = $statement->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

?>

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