document.addEventListener("DOMContentLoaded", function () {
    const addNoteBtn = document.getElementById("add-note-btn");
    const notesGrid = document.querySelector(".notes-grid");
  
    // Function to create a new note
    function createNote(title = "New Note", content = "Write your note here...") {
      const newNote = document.createElement("div");
      newNote.classList.add("note");
  
      // Get current date
      const currentDate = new Date().toLocaleDateString("en-US", {
        month: "long",
        day: "2-digit",
        year: "numeric",
      });
  
      // Set note content
      newNote.innerHTML = `
        <nav class="note-bar">
          <a href="#" class="note-branding">${title}</a>
          <div class="menu-container">
            <button class="menu-button">
              <span class="dot"></span>
              <span class="dot"></span>
              <span class="dot"></span>
            </button>
            <div class="menu-options hidden">
              <button class="edit-note">Edit</button>
              <button class="archive-note">Archive</button>
              <button class="delete-note">Delete</button>
            </div>
          </div>
        </nav>
        <p contenteditable="false">${content}</p>
        <div class="note-footer">
          <p>${currentDate}</p>
        </div>
      `;
  
      // Select necessary elements
      const menuButton = newNote.querySelector(".menu-button");
      const menuOptions = newNote.querySelector(".menu-options");
      const editButton = newNote.querySelector(".edit-note");
      const archiveButton = newNote.querySelector(".archive-note");
      const deleteButton = newNote.querySelector(".delete-note");
      const noteContent = newNote.querySelector("p");
  
      // Toggle dropdown menu
      menuButton.addEventListener("click", function (e) {
        e.stopPropagation(); // Prevent click event from propagating
        menuOptions.classList.toggle("hidden");
      });
  
      // Close dropdown when clicking outside
      document.addEventListener("click", function (event) {
        if (!newNote.contains(event.target)) {
          menuOptions.classList.add("hidden");
        }
      });
  
      // Edit note functionality
      editButton.addEventListener("click", function () {
        if (noteContent.contentEditable === "true") {
          noteContent.contentEditable = "false";
          editButton.textContent = "Edit";
        } else {
          noteContent.contentEditable = "true";
          noteContent.focus();
          editButton.textContent = "Save";
        }
      });
  
      // Archive note functionality
      archiveButton.addEventListener("click", function () {
        newNote.classList.toggle("archived");
        menuOptions.classList.add("hidden"); // Hide menu after clicking
      });
  
      // Delete note functionality
      deleteButton.addEventListener("click", function () {
        newNote.remove();
      });
  
      // Append the new note to the notes grid
      notesGrid.appendChild(newNote);
    }
  
    // Add new note when clicking the add button
    addNoteBtn.addEventListener("click", function () {
      createNote();
    });
  });
  