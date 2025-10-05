<?php
// Start session
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Include database connection
require_once 'database.php';

// Initialize variables
$username = "";
$rememberMe = false;
$errors = [];

// Check if a remember_me cookie exists and pre-fill username
if (isset($_COOKIE['remember_user'])) {
    $username = $_COOKIE['remember_user'];
    $rememberMe = true;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']);
    
    // Validate input data
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    
    // If validation passes, attempt login
    if (empty($errors)) {
        $result = loginUser($username, $password);
        
        if ($result['success']) {
            // Login successful
            $_SESSION['username'] = $result['user']['username'];
            $_SESSION['user_id'] = $result['user']['user_id'];
            
            // If "remember me" is checked, set a cookie
            if ($rememberMe) {
                setcookie("remember_user", $username, time() + (86400 * 30), "/", "", false, true); // 30 days
            } else {
                // If not checked but cookie exists, remove it
                if (isset($_COOKIE['remember_user'])) {
                    setcookie("remember_user", "", time() - 3600, "/");
                }
            }
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteIt - Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="home.php">
                    <h1>Note<span>It</span></h1>
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="signin.php" class="active">Sign In</a></li>
                </ul>
            </nav>
        </header>

        <main class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Welcome Back</h2>
                    <p>Sign in to access your notes</p>
                </div>

                <?php if (!empty($errors)): ?>
                <div class="error-container">
                    <?php foreach ($errors as $error): ?>
                        <p class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="username" name="username" placeholder="Enter your username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="checkbox-group">
                            <input type="checkbox" id="remember_me" name="remember_me" <?php echo $rememberMe ? 'checked' : ''; ?>>
                            <label for="remember_me">Remember Me</label>
                        </div>
                        <a href="forgot_password.php" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary">Sign In</button>
                </form>

                <div class="auth-footer">
                    <p>Don't have an account? <a href="register.php">Register</a></p>
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> NoteIt. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>