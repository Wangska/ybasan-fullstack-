<?php
// archive_note.php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Check if note ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid note ID.";
    header("Location: dashboard.php");
    exit();
}

$note_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Database connection via shared config
require_once __DIR__ . '/config.php';

try {
    
    // Verify the note belongs to the user
    $check_sql = "SELECT id FROM notes WHERE id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $note_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows === 0) {
        throw new Exception("You don't have permission to archive this note.");
    }
    
    // Archive the note
    $sql = "UPDATE notes SET archived = 1 WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $note_id, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Note archived successfully!";
    } else {
        $_SESSION['error'] = "Error archiving note: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: dashboard.php");
exit();
?>