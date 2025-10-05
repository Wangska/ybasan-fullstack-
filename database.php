<?php
// database.php - Database connection and functions

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'noteit_db');
define('DB_USER', 'root'); // Change to your database username
define('DB_PASS', ''); // Change to your database password

/**
 * Get database connection
 * @return PDO Database connection
 */
function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

/**
 * Register a new user
 * @param string $username Username
 * @param string $email User email
 * @param string $password Plain password (will be hashed)
 * @param string $fullName User's full name
 * @return bool Success or failure
 */
function registerUser($username, $email, $password, $fullName) {
    try {
        $conn = getConnection();
        
        // Check if username exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Username already exists"];
        }
        
        // Check if email exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Email already exists"];
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)");
        $success = $stmt->execute([$username, $email, $hashedPassword, $fullName]);
        
        return ["success" => $success, "message" => $success ? "Registration successful" : "Registration failed"];
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Authenticate a user
 * @param string $username Username
 * @param string $password Plain password
 * @return array User data or error
 */
function loginUser($username, $password) {
    try {
        $conn = getConnection();
        
        // Get user by username
        $stmt = $conn->prepare("SELECT user_id, username, email, password, full_name FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() == 0) {
            return ["success" => false, "message" => "Invalid username or password"];
        }
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            return ["success" => false, "message" => "Invalid username or password"];
        }
        
        // Update last login
        $updateStmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE user_id = ?");
        $updateStmt->execute([$user['user_id']]);
        
        // Remove password from returned data
        unset($user['password']);
        
        return ["success" => true, "user" => $user];
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Get all notes for a user
 * @param int $userId User ID
 * @param bool $archived Whether to get archived notes
 * @param bool $favorites Whether to get only favorite notes
 * @return array Notes
 */
function getUserNotes($userId, $archived = false, $favorites = false) {
    try {
        $conn = getConnection();
        
        $sql = "SELECT note_id, title, content, is_favorite, created_at, updated_at 
                FROM notes 
                WHERE user_id = ? AND is_archived = ?";
        
        $params = [$userId, $archived ? 1 : 0];
        
        if ($favorites) {
            $sql .= " AND is_favorite = 1";
        }
        
        $sql .= " ORDER BY updated_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return ["success" => true, "notes" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Create a new note
 * @param int $userId User ID
 * @param string $title Note title
 * @param string $content Note content
 * @return array Result with note_id if successful
 */
function createNote($userId, $title, $content) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) VALUES (?, ?, ?)");
        $success = $stmt->execute([$userId, $title, $content]);
        
        if ($success) {
            $noteId = $conn->lastInsertId();
            return ["success" => true, "note_id" => $noteId];
        } else {
            return ["success" => false, "message" => "Failed to create note"];
        }
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Update an existing note
 * @param int $noteId Note ID
 * @param int $userId User ID (for security)
 * @param string $title Note title
 * @param string $content Note content
 * @return array Result
 */
function updateNote($noteId, $userId, $title, $content) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("UPDATE notes SET title = ?, content = ? WHERE note_id = ? AND user_id = ?");
        $stmt->execute([$title, $content, $noteId, $userId]);
        
        if ($stmt->rowCount() > 0) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Note not found or you don't have permission"];
        }
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Toggle favorite status for a note
 * @param int $noteId Note ID
 * @param int $userId User ID (for security)
 * @return array Result
 */
function toggleNoteFavorite($noteId, $userId) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("UPDATE notes SET is_favorite = NOT is_favorite WHERE note_id = ? AND user_id = ?");
        $stmt->execute([$noteId, $userId]);
        
        if ($stmt->rowCount() > 0) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Note not found or you don't have permission"];
        }
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Toggle archive status for a note
 * @param int $noteId Note ID
 * @param int $userId User ID (for security)
 * @return array Result
 */
function toggleNoteArchive($noteId, $userId) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("UPDATE notes SET is_archived = NOT is_archived WHERE note_id = ? AND user_id = ?");
        $stmt->execute([$noteId, $userId]);
        
        if ($stmt->rowCount() > 0) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Note not found or you don't have permission"];
        }
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Delete a note
 * @param int $noteId Note ID
 * @param int $userId User ID (for security)
 * @return array Result
 */
function deleteNote($noteId, $userId) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("DELETE FROM notes WHERE note_id = ? AND user_id = ?");
        $stmt->execute([$noteId, $userId]);
        
        if ($stmt->rowCount() > 0) {
            return ["success" => true];
        } else {
            return ["success" => false, "message" => "Note not found or you don't have permission"];
        }
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

/**
 * Search for notes by title or content
 * @param int $userId User ID
 * @param string $query Search query
 * @param bool $archived Whether to include archived notes
 * @return array Notes
 */
function searchNotes($userId, $query) {
    try {
        $conn = getConnection();
        
        $sql = "SELECT note_id, title, content, is_favorite, is_archived, created_at, updated_at 
                FROM notes 
                WHERE user_id = ? AND (title LIKE ? OR content LIKE ?)
                ORDER BY updated_at DESC";
        
        $searchPattern = "%" . $query . "%";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $searchPattern, $searchPattern]);
        
        return ["success" => true, "notes" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
    } catch (PDOException $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}
?>