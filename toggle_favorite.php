<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Check if request is POST and note_id is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_id'])) {
    require_once 'database.php';
    
    $userId = $_SESSION['user_id'];
    $noteId = (int)$_POST['note_id'];
    
    // Validate note ID
    if ($noteId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid note ID']);
        exit();
    }
    
    // Toggle favorite status
    $result = toggleNoteFavorite($noteId, $userId);
    
    // Get the current favorite status to return to client
    if ($result['success']) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT is_favorite FROM notes WHERE note_id = ? AND user_id = ?");
        $stmt->execute([$noteId, $userId]);
        $note = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($note) {
            $result['is_favorite'] = (bool)$note['is_favorite'];
        }
    }
    
    echo json_encode($result);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>