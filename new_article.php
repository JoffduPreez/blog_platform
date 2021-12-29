<?php
require 'includes/redirect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $published_at = $_POST['published_at'];

    try {
        $conn = Database::getConnection();

        $sql = "INSERT INTO articles (title, content, published_at) VALUES (:title, :content, :published_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        if ($published_at == '') {
            $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);
        }

        if ($stmt->execute()) {
            $id = $conn->lastInsertId();
            redirect("/");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}
?>


<?php require 'includes/header.php'; ?>
<form method="post">
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