<?php
require 'db.php';
session_start();
include 'header.php';
?>

<nav>
    <a href="index.php" class="button">Home</a>
</nav>

<?php if (isset($_SESSION['user_id'])): ?>
    <h2>Recent Diary Entries</h2>
    <?php
    $stmt = $pdo->prepare('SELECT diary_entries.id, title, created_at, username FROM diary_entries JOIN users ON diary_entries.user_id = users.id ORDER BY created_at DESC LIMIT 5');
    $stmt->execute();
    $entries = $stmt->fetchAll();
    ?>
    <?php foreach ($entries as $entry): ?>
        <div class="entry">
            <h3><a href="view_diary.php?id=<?php echo $entry['id']; ?>"><?php echo htmlspecialchars($entry['title']); ?></a></h3>
            <p>Written by <?php echo htmlspecialchars($entry['username']); ?> on <?php echo $entry['created_at']; ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Please <a href="login.php">login</a> or <a href="register.php">sign up</a> to view and write diary entries!</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
