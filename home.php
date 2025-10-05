<?php
// Start session
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteIt - Modern Note Taking Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #eaeaea;
        }
        
        .logo a {
            text-decoration: none;
        }
        
        .logo h1 {
            font-size: 32px;
            font-weight: 700;
            color: #333;
        }
        
        .logo span {
            color: #4a6bff;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 30px;
        }
        
        nav ul li a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        nav ul li a:hover {
            color: #4a6bff;
        }
        
        nav ul li a.active {
            color: #4a6bff;
            position: relative;
        }
        
        nav ul li a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #4a6bff;
        }
        
        /* Main Content Styles */
        main {
            padding: 60px 0;
        }
        
        .home-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }
        
        .hero-content {
            flex: 1;
        }
        
        .hero-content h2 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #222;
        }
        
        .hero-content h2 span {
            color: #4a6bff;
        }
        
        .hero-content p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        .cta-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: #4a6bff;
            color: white;
            border: 2px solid #4a6bff;
        }
        
        .btn-primary:hover {
            background-color: #3a5eff;
            border-color: #3a5eff;
        }
        
        .btn-secondary {
            background-color: transparent;
            color: #4a6bff;
            border: 2px solid #4a6bff;
        }
        
        .btn-secondary:hover {
            background-color: rgba(74, 107, 255, 0.1);
        }
        
        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Footer Styles */
        footer {
            padding: 20px 0;
            text-align: center;
            border-top: 1px solid #eaeaea;
            color: #777;
            font-size: 14px;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .home-hero {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-content {
                order: 2;
            }
            
            .hero-image {
                order: 1;
                margin-bottom: 30px;
            }
            
            .cta-buttons {
                justify-content: center;
            }
            
            nav ul li {
                margin-left: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <a href="index.php">
                    <h1>Note<span>It</span></h1>
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="signin.php">Sign In</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <div class="home-hero">
                <div class="hero-content">
                    <h2>Note<span>It!</span></h2>
                    <p>
                        Meet NoteIt!, the modernized app that makes note-taking a breeze.
                        Jot down ideas effortlessly, organize them with ease, and retrieve
                        information lightning-fast. Its customized formatting options and
                        ideal sharing capabilities make NoteIt! an indispensable tool for
                        maximizing your efficiency.
                    </p>
                    <div class="cta-buttons">
                        <a href="signin.php" class="btn btn-primary">SIGN IN</a>
                        <a href="register.php" class="btn btn-secondary">REGISTER</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="man.png" alt="Person taking notes">
                </div>
            </div>
        </main>

        <footer>
            <p>&copy; <?php echo date('Y'); ?> NoteIt. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>