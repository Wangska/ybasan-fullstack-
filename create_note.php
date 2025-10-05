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
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    // Basic validation
    if (empty($title)) {
        echo json_encode(['success' => false, 'message' => 'Title is required']);
        exit();
    }
    
    // Create note
    $result = createNote($userId, $title, $content);
    
    echo json_encode($result);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>