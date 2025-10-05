<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'database.php';
    
    $userId = $_SESSION['user_id'];
    $noteId = isset($_POST['note_id']) ? (int)$_POST['note_id'] : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    
    // Basic validation
    if (empty($noteId)) {
        echo json_encode(['success' => false, 'message' => 'Note ID is required']);
        exit();
    }
    
    if (empty($title)) {
        echo json_encode(['success' => false, 'message' => 'Title is required']);
        exit();
    }
    
    // Update note
    $result = updateNote($noteId, $userId, $title, $content);
    
    echo json_encode($result);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>