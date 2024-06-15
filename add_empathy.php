<?php
require 'db.php';
session_start();

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to express empathy.']);
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $entryId = $_POST['entry_id'];

    // Insert empathy record
    $stmt = $pdo->prepare('INSERT INTO empathy (entry_id, user_id) VALUES (?, ?)');
    $stmt->execute([$entryId, $userId]);

    // Get updated empathy count
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM empathy WHERE entry_id = ?');
    $stmt->execute([$entryId]);
    $empathyCount = $stmt->fetchColumn();

    echo json_encode(['success' => true, 'message' => 'Empathy recorded.', 'empathy_count' => $empathyCount]);
    exit;
}
?>
