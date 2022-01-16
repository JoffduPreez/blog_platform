<?php
require 'classes/User.php';
require 'classes/Database.php';
session_start();

$conn = Database::getConnection();
$users = User::getAllUsers($conn, $_SESSION['login_id']);
$following = User::getFollowing($conn, $_SESSION['login_id']); 
?>

<?php require 'includes/header.php' ?>
        <div id="main-container">
            <?php if (empty($users)): ?>
                <p>No users found.</p>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <div class="user">
                        <div class="pfp"></div>
                        <a href="profile.php?id=<?= $user['id']; ?>" class="username"><?= htmlspecialchars($user['username']); ?></a>
                    </div>
                    <?php if (User::checkFollow($conn, $_SESSION['login_id'], $user['id'])): ?>
                        <a href="unfollow.php?id=<?= $user['id']; ?>">Unfollow</a>
                    <?php else: ?>
                        <a href="follow.php?id=<?= $user['id']; ?>">Follow</a>
                    <?php endif; ?>
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