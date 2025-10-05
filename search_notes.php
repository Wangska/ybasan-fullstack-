<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Check if request has search query
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    require_once 'database.php';
    
    $userId = $_SESSION['user_id'];
    $query = trim($_GET['query']);
    
    // If query is empty, return all notes
    if (empty($query)) {
        $result = getUserNotes($userId, false, false); // Get active notes (not archived)
    } else {
        // Search notes
        $result = searchNotes($userId, $query);
    }
    
    // Format dates for display
    if ($result['success'] && !empty($result['notes'])) {
        foreach ($result['notes'] as &$note) {
            $note['formatted_date'] = date('F d, Y', strtotime($note['updated_at']));
            
            // Create a short preview of content (first 100 chars)
            $note['preview'] = substr(strip_tags($note['content']), 0, 100);
            if (strlen($note['content']) > 100) {
                $note['preview'] .= '...';
            }
        }
    }
    
    echo json_encode($result);
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>