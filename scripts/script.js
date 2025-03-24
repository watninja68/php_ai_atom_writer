document.addEventListener("DOMContentLoaded", function () {});

function toggleSidebar() {
  let sidebar = document.getElementById("sidebar");
  sidebar.classList.toggle("-translate-x-full");
  sidebar.classList.toggle("open");
}

function closeSidebar(event) {
  let sidebar = document.getElementById("sidebar");
  let button = document.getElementById("menu-button");
  if (!sidebar.contains(event.target) && !button.contains(event.target)) {
    sidebar.classList.add("-translate-x-full");
    sidebar.classList.remove("open");
    button.innerHTML = '<i class="fas fa-bars"></i>';
  }
}

function toggleChatSidebar() {
  const sidebar = document.getElementById("chatSidebar");
  sidebar.classList.toggle("hidden");
}

// Close sidebar when clicking outside (optional)
document.addEventListener("click", (event) => {
  const sidebar = document.getElementById("chatSidebar");
  const toggleButton = document.getElementById("sidebar-toggle");

  if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
    sidebar.classList.add("hidden");
  }
});





// Function to toggle dark mode and save the preference
function toggleDarkMode() {
  const htmlElement = document.documentElement;
  const body = document.body;
  
  // Toggle the 'dark' class on <html> (Tailwind dark mode)
  htmlElement.classList.toggle("dark");

  // Toggle 'dark-mode' class on specific elements
  body.classList.toggle("dark-mode");
  document.querySelector(".profile-dropdown").classList.toggle("dark-mode");

  // Save the user's preference in localStorage
  const isDarkMode = htmlElement.classList.contains("dark");
  // alert(isDarkMode)
  localStorage.setItem("darkMode", isDarkMode ? "enabled" : "disabled");
}
// The remaining of the above code is in the header.php i move to there to avoid flickering


function toggleProfileDropdown() {
  document.getElementById("profile-dropdown").classList.toggle("hidden");
}

document.addEventListener("click", (event) => {
  closeSidebar(event);
  // Close profile dropdown if clicked outside
  const profileDropdown = document.getElementById("profile-dropdown");
  const profileButton = document.getElementById("profile-button");
  if (
    !profileButton.contains(event.target) &&
    !profileDropdown.contains(event.target)
  ) {
    profileDropdown.classList.add("hidden");
  }
});

function toggleSubMenu(id) {
  const submenu = document.getElementById(id);

  if (submenu.classList.contains("hidden")) {
    submenu.classList.remove("hidden");
    submenu.dataset.prevState = "open"; // Save open state
  } else {
    submenu.classList.add("hidden");
    submenu.dataset.prevState = ""; // Clear saved state
  }
}

function sidebarCollapse() {
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("mainContent");
  const toggleIcon = document.getElementById("toggleIcon");

  if (toggleIcon.classList.contains("fa-chevron-left")) {
    // Collapse the sidebar
    sidebar.classList.add("collapsed");
    mainContent.classList.add("collapsed");
    toggleIcon.classList.replace("fa-chevron-left", "fa-chevron-right");
  } else {
    // Expand the sidebar
    sidebar.classList.remove("collapsed");
    mainContent.classList.remove("collapsed");
    toggleIcon.classList.replace("fa-chevron-right", "fa-chevron-left");
  }
}

function expandOnHover() {
  const sidebarSubMenuText = document.querySelectorAll("sidebar-text-hidden");
  const sidebarTexts = document.querySelectorAll(".sidebar-text");
  const sidebar = document.getElementById("sidebar");
  const toggleIcon = document.getElementById("toggleIcon");

  // Only expand on hover if the sidebar is collapsed and the icon is "fa-chevron-right"
  if (
    sidebar.classList.contains("collapsed") &&
    toggleIcon.classList.contains("fa-chevron-right")
  ) {
    sidebarTexts.forEach((text) => text.classList.remove("hidden"));
    sidebarSubMenuText.forEach((text) => text.classList.add("hidden"));
    sidebar.classList.add("hover-expanded");
  }
}

function collapseOnLeave() {
  const submenus = document.querySelectorAll(".sidebar-text-hidden"); // Get all submenus
  const sidebarSubMenuText = document.querySelectorAll("sidebar-text-hidden");
  const sidebar = document.getElementById("sidebar");
  const sidebarTexts = document.querySelectorAll(".sidebar-text");
  if (sidebar.classList.contains("collapsed")) {
    sidebar.classList.remove("hover-expanded");
    sidebarTexts.forEach((text) => text.classList.add("hidden"));
    sidebarSubMenuText.forEach((text) => text.classList.add("hidden"));
    // Restore submenus that were open before collapsing
    submenus.forEach((submenu) => {
      submenu.classList.add("hidden");
      submenu.dataset.prevState = "open"; // Save state for restoring later
    });
  }
}

function toggleDetails(id) {
  // Hide all detail sections first
  document
    .querySelectorAll(".details")
    .forEach((el) => el.classList.add("hidden"));

  // Show the clicked one
  const target = document.getElementById(id);
  if (target.classList.contains("hidden")) {
    target.classList.remove("hidden");
  }
}
function openModal(title, description) {
  document.getElementById("modalTitle").innerText = title;
  document.getElementById("modalDescription").innerText = description;
  document.getElementById("offerModal").classList.remove("hidden");
  document.getElementById("offerModal").classList.add("modal-active");
}

function closeModal() {
  document.getElementById("offerModal").classList.add("hidden");
  document.getElementById("offerModal").classList.remove("modal-active");
}

// Close modal on ESC key
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") closeModal();
});
