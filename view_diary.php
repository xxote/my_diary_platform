<?php
require 'db.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$entryId = $_GET['id'];
$stmt = $pdo->prepare('SELECT diary_entries.id, title, content, emotion, created_at, username FROM diary_entries JOIN users ON diary_entries.user_id = users.id WHERE diary_entries.id = ?');
$stmt->execute([$entryId]);
$entry = $stmt->fetch();

if (!$entry) {
    echo 'Diary entry not found.';
    include 'footer.php';
    exit;
}
?>

<nav>
    <a href="index.php" class="button">Home</a>
</nav>

<div class="entry-container">
    <h1><?php echo htmlspecialchars($entry['title']); ?></h1>
    <div class="entry-content">
        <p><?php echo nl2br(htmlspecialchars($entry['content'])); ?></p>
    </div>
    <div class="entry-emotion">
        <p><?php echo htmlspecialchars($entry['emotion']); ?></p>
    </div>
    <div class="entry-meta">
        <p>Written by <?php echo htmlspecialchars($entry['username']); ?> on <?php echo $entry['created_at']; ?></p>
    </div>

    <?php
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM empathy WHERE entry_id = ?');
    $stmt->execute([$entryId]);
    $empathyCount = $stmt->fetchColumn();
    ?>
    <p class="empathy-count">Empathy: <?php echo $empathyCount; ?></p>

    <form method="post" class="empathy-form">
        <input type="hidden" name="entry_id" value="<?php echo $entry['id']; ?>">
        <button type="submit" name="empathy" value="empathy">Empathy</button>
    </form>

    <div class="entry-comments">
        <h2>Comments</h2>
        <?php
        $stmt = $pdo->prepare('SELECT comment, username FROM comments JOIN users ON comments.user_id = users.id WHERE entry_id = ?');
        $stmt->execute([$entryId]);
        $comments = $stmt->fetchAll();
        ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                <p><small>by <?php echo htmlspecialchars($comment['username']); ?></small></p>
            </div>
        <?php endforeach; ?>

        <form id="comment-form" method="post" action="add_comment.php">
            <input type="hidden" name="entry_id" value="<?php echo $entry['id']; ?>">
            <label for="comment">Add a comment:</label>
            <textarea id="comment" name="comment" required></textarea>
            <button type="submit">Comment</button>
        </form>
    </div>
</div>

<script src="main.js"></script>
<?php include 'footer.php'; ?>
