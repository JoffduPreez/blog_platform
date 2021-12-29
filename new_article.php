<?php
require 'includes/redirect.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $db_host = "localhost";
//     $db_name = "blog_platform";
//     $db_user = "joffre";
//     $db_pass = "joffre$$";
//     $title = $_POST['title'];
//     $content = $_POST['content'];
//     $published_at = $_POST['published_at'];
    
//     $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
//     if ($conn->connect_error) {
//       die("Connection failed: " . mysqli_connect_error());
//     }
    
//     $sql = "INSERT INTO articles (title, content, published_at) VALUES (?, ?, ?)";
//     $stmt = $conn->prepare($sql);

//     if ($stmt === false) {
//         echo mysqli_error($conn);
//     } else {
//         if ($published_at == '') {
//             $published_at = null;
//         }
//         $stmt->bind_param("sss", $title, $content, $published_at);

//         if ($stmt->execute()) {
//             redirect("/");
//         } else {
//             echo mysqli_stmt_error($stmt);
//         }
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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