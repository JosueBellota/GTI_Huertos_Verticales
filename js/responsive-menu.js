const menuToggler = document.getElementById('menu-icon');
const headerNav = document.querySelector('.header__nav-list');
const menuIcon = document.querySelector('.menu-icon');
const closeIcon = document.querySelector('.close-icon');

// Initial state: menu is closed
let isMenuOpen = false;

menuToggler.addEventListener('click', function () {
    if (!isMenuOpen) {
        // Open the menu
        headerNav.style.display = 'block';
        menuIcon.style.display = 'none'; 
        isMenuOpen = true;
        closeIcon.style.display = 'block';
    } else {
        // Close the menu
        headerNav.style.display = 'none';
        closeIcon.style.display = 'none';
        menuIcon.style.display = 'block';
            
        isMenuOpen = false;
    }
});

// Event listener for close icon
closeIcon.addEventListener('click', function () {
    // Close the menu
    headerNav.style.display = 'none';
    menuIcon.style.display = 'block';
    isMenuOpen = false;
});