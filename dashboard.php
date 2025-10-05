<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

// Get user information
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <title>NoteIt Dashboard</title>
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
        height: 100vh;
      }
      
      /* Main Layout */
      .main1 {
        display: flex;
        height: 100vh;
      }
      
      /* Sidebar Navigation */
      .navi {
        width: 280px;
        background-color: #fff;
        border-right: 1px solid #eaeaea;
        padding: 25px 20px;
        display: flex;
        flex-direction: column;
        height: 100%;
      }
      
      .yep {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #333;
      }
      
      .yep span {
        color: #4a6bff;
      }
      
      .nav-bar {
        list-style: none;
        margin-bottom: auto;
      }
      
      .nav-bar li {
        margin-bottom: 15px;
      }
      
      .nav-bar a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #555;
        font-weight: 500;
        padding: 10px 15px;
        border-radius: 6px;
        transition: all 0.3s ease;
      }
      
      .nav-bar a:hover {
        background-color: rgba(74, 107, 255, 0.1);
        color: #4a6bff;
      }
      
      .nav-bar i {
        margin-right: 10px;
        font-size: 18px;
        width: 24px;
        text-align: center;
      }
      
      /* User Profile Section */
      .user {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: #f5f7ff;
        border-radius: 10px;
        margin-top: 190%;
      }
      
      .user img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
        border: 2px solid #4a6bff;
      }
      
      .user p {
        font-size: 14px;
        color: #555;
        line-height: 1.3;
      }
      
      /* Main Content Area */
      .main {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
      }
      
      .hala {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
      }
      
      .hala h2 {
        font-size: 28px;
        color: #333;
        font-weight: 600;
      }
      
      /* Search Bar and Add Button */
      .search-bar {
        display: flex;
        align-items: center;
      }
      
      .search-bar input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: 'Poppins', sans-serif;
        margin-right: 15px;
        width: 250px;
        transition: all 0.3s ease;
      }
      
      .search-bar input:focus {
        outline: none;
        border-color: #4a6bff;
        box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
      }
      
      .plus-button {
        width: 40px;
        height: 40px;
        background-color: #4a6bff;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-right: 10px;
        transition: all 0.3s ease;
      }
      
      .plus-button:hover {
        background-color: #3a5eff;
        transform: scale(1.05);
      }
      
      .search-bar p {
        color: #4a6bff;
        font-weight: 500;
      }
      
      /* Notes Grid */
      .notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
      }
      
      .note {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        min-height: 200px;
        position: relative;
      }
      
      .note:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
      }
      
      .note-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
      }
      
      .note-branding {
        font-weight: 600;
        font-size: 18px;
        color: #333;
        text-decoration: none;
      }
      
      .menu-button {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        gap: 3px;
        position: relative;
        z-index: 1;
      }
      
      .dot {
        width: 5px;
        height: 5px;
        background-color: #999;
        border-radius: 50%;
      }
      
      .note p {
        color: #666;
        flex-grow: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
      }
      
      .note-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        font-size: 13px;
        color: #999;
      }
      
      /* Empty state for no notes */
      .notes-grid:empty::after {
        content: "No notes yet. Click the + button to create your first note!";
        grid-column: 1 / -1;
        text-align: center;
        padding: 50px;
        color: #999;
        font-style: italic;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      }
      
      /* Note Menu */
      .note-menu {
        position: absolute;
        top: 50px;
        right: 20px;
        background-color: white;
        border-radius: 6px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        min-width: 150px;
        z-index: 10;
        display: none;
      }
      
      .note-menu.active {
        display: block;
        animation: fadeIn 0.2s ease-in-out;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
      }
      
      .note-menu-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        font-size: 14px;
        color: #555;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
      }
      
      .note-menu-item:hover {
        background-color: #f5f7ff;
        color: #4a6bff;
      }
      
      .note-menu-item i {
        margin-right: 10px;
        width: 18px;
        text-align: center;
      }
      
      /* Overlay for when menu is open */
      .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 5;
        display: none;
      }
      
      .overlay.active {
        display: block;
      }
      
      /* Responsive styles */
      @media (max-width: 768px) {
        .main1 {
          flex-direction: column;
        }
        
        .navi {
          width: 100%;
          height: auto;
          border-right: none;
          border-bottom: 1px solid #eaeaea;
          padding: 15px;
        }
        
        .nav-bar {
          display: flex;
          overflow-x: auto;
          margin-bottom: 15px;
        }
        
        .nav-bar li {
          margin-right: 15px;
          margin-bottom: 0;
        }
        
        .hala {
          flex-direction: column;
          align-items: flex-start;
        }
        
        .search-bar {
          width: 100%;
          margin-top: 15px;
        }
        
        .search-bar input {
          flex-grow: 1;
          width: auto;
        }
        
        .notes-grid {
          grid-template-columns: 1fr;
        }
        
        .note-menu {
          top: 45px;
          right: 15px;
        }
        .navi{
          width: 280px;
    background-color: #fff;
    border-right: 1px solid #eaeaea;
    padding: 25px 20px;
    display: flex;
    
    flex-direction: column;
    height: 100%;
        }
      }
    </style>
  </head>
  <body>
    <div class="main1">
      <div class="navi">
        <h1 class="yep">Note<span>It!</span></h1>
        <nav>
          <ul class="nav-bar">
            <li>
              <a href="#"
                ><i class="fa-regular fa-note-sticky"></i>All Notes</a
              >
            </li>
            <li>
              <a href="#"><i class="fa-regular fa-heart"></i>Favorites</a>
            </li>
            <li>
              <a href="#"><i class="fa-solid fa-boxes-packing"></i>Archives</a>
            </li>
            <li>
              <a href="logout.php"
                ><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</a
              >
            </li>
          </ul>
        </nav>
        <div class="user">
          <img src="" alt="User Icon" />
          <p>Hi <?php echo htmlspecialchars($username); ?>!<br>Welcome back.</p>
        </div>
      </div>
      <div class="main">
        <div class="hala">
          <h2>All Notes</h2>
          <div class="search-bar">
            <input type="text" id="note-search" placeholder="Search notes...">
            <button class="plus-button" id="add-note-btn">+</button>
            <p>Add Notes</p>
          </div>
        </div>
        <div class="notes-grid">
          <?php
          // Example of dynamically fetching notes from database
          // In a real app, you would query your database here
          $notes = [
            [
              'id' => 1,
              'title' => 'Meeting Notes',
              'content' => 'Discuss project timeline and resource allocation for the upcoming product launch. Follow up with marketing team about promotional materials.',
              'date' => 'March 25, 2025'
            ],
            [
              'id' => 2,
              'title' => 'Shopping List',
              'content' => 'Milk, eggs, bread, apples, pasta, chicken, tomatoes, olive oil, yogurt, cereal',
              'date' => 'March 27, 2025'
            ],
            [
              'id' => 3,
              'title' => 'Ideas for Birthday',
              'content' => 'Restaurant reservation, gift ideas: book, watch, or cooking class. Remember to order cake one day before.',
              'date' => 'March 28, 2025'
            ]
          ]; // Example notes for display
          
          if (!empty($notes)):
            foreach($notes as $note): 
          ?>
          <div class="note"> 
            <nav class="note-bar">
              <a href="#" class="note-branding"><?php echo htmlspecialchars($note['title']); ?></a>
              <button class="menu-button" data-note-id="<?php echo $note['id']; ?>">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
              </button>
              <div class="note-menu" id="menu-<?php echo $note['id']; ?>">
                <div class="note-menu-item" onclick="editNote(<?php echo $note['id']; ?>)">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </div>
                <div class="note-menu-item" onclick="deleteNote(<?php echo $note['id']; ?>)">
                  <i class="fa-solid fa-trash"></i> Delete
                </div>
                <div class="note-menu-item" onclick="archiveNote(<?php echo $note['id']; ?>)">
                  <i class="fa-solid fa-box-archive"></i> Archive
                </div>
              </div>
            </nav>
            <p><?php echo htmlspecialchars($note['content']); ?></p>
            
            <div class="note-footer">
              <div class="dots"></div>
              <p><?php echo htmlspecialchars($note['date']); ?></p>
            </div>
          </div>
          <?php 
            endforeach;
          endif;
          ?>
        </div>
      </div>
    </div>
    <div class="overlay" id="menu-overlay"></div>
    
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Add note button functionality
        const addNoteBtn = document.getElementById('add-note-btn');
        addNoteBtn.addEventListener('click', function() {
          // In a real application, this would open a modal or redirect to a new note page
          alert('Add note functionality would open here!');
        });
        
        // Search functionality
        const searchInput = document.getElementById('note-search');
        searchInput.addEventListener('input', function() {
          const searchTerm = this.value.toLowerCase();
          const notes = document.querySelectorAll('.note');
          
          notes.forEach(note => {
            const title = note.querySelector('.note-branding').textContent.toLowerCase();
            const content = note.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || content.includes(searchTerm)) {
              note.style.display = 'flex';
            } else {
              note.style.display = 'none';
            }
          });
        });
        
        // Menu button functionality for each note
        const menuButtons = document.querySelectorAll('.menu-button');
        const overlay = document.getElementById('menu-overlay');
        
        menuButtons.forEach(button => {
          button.addEventListener('click', function(e) {
            e.stopPropagation();
            const noteId = this.getAttribute('data-note-id');
            const menu = document.getElementById('menu-' + noteId);
            
            // Close all other open menus first
            document.querySelectorAll('.note-menu.active').forEach(openMenu => {
              if (openMenu !== menu) {
                openMenu.classList.remove('active');
              }
            });
            
            // Toggle current menu
            menu.classList.toggle('active');
            
            // Show overlay if any menu is active
            if (document.querySelectorAll('.note-menu.active').length > 0) {
              overlay.classList.add('active');
            } else {
              overlay.classList.remove('active');
            }
          });
        });
        
        // Close menus when clicking elsewhere
        overlay.addEventListener('click', function() {
          closeAllMenus();
        });
        
        document.addEventListener('click', function(e) {
          if (!e.target.closest('.note-menu') && !e.target.closest('.menu-button')) {
            closeAllMenus();
          }
        });
        
        function closeAllMenus() {
          document.querySelectorAll('.note-menu.active').forEach(menu => {
            menu.classList.remove('active');
          });
          overlay.classList.remove('active');
        }
      });
      
      // Note action functions
      function editNote(noteId) {
        // In a real application, this would open an edit form
        alert('Edit note #' + noteId);
        closeAllMenus();
      }
      
      function deleteNote(noteId) {
        // In a real application, this would show a confirmation dialog
        if (confirm('Are you sure you want to delete note #' + noteId + '?')) {
          // Delete note logic would go here
          alert('Note #' + noteId + ' deleted!');
        }
        closeAllMenus();
      }
      
      function archiveNote(noteId) {
        // In a real application, this would archive the note
        alert('Note #' + noteId + ' archived!');
        closeAllMenus();
      }
      
      function closeAllMenus() {
        document.querySelectorAll('.note-menu.active').forEach(menu => {
          menu.classList.remove('active');
        });
        document.getElementById('menu-overlay').classList.remove('active');
      }
    </script>
  </body>
</html>