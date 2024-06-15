<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $emotion = $_POST['emotion'];

    $stmt = $pdo->prepare('INSERT INTO diary_entries (user_id, title, content, emotion) VALUES (?, ?, ?, ?)');
    $stmt->execute([$userId, $title, $content, $emotion]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Write Diary</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Write a New Diary Entry</h1>
    </header>
    <form action="write_diary.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        <label for="emotion">Emotion:</label>
        <input type="text" id="emotion" name="emotion" required>
        <button type="submit">Save Diary</button>
    </form>
</body>
</html>
