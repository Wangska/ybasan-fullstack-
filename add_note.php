<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Note - NoteIt</title>
    <!-- Add your CSS links here -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add New Note</h1>
        <nav>
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </nav>
    </header>
    
    <main>
        <section class="form-container">
            <form action="process_note.php" method="POST">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="10" required></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; <?php echo date("Y"); ?> NoteIt App</p>
    </footer>
</body>
</html>