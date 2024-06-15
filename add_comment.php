<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to add a comment.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $entryId = $_POST['entry_id'];
    $commentText = $_POST['comment'];

    $stmt = $pdo->prepare('INSERT INTO comments (entry_id, user_id, comment) VALUES (?, ?, ?)');
    $stmt->execute([$entryId, $userId, $commentText]);

    header('Location: view_diary.php?id=' . $entryId);
    exit;
}
?>
