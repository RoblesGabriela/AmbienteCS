////control de menu////
document.getElementById('menu-toggle-btn').addEventListener('click', function() {
    const nav = document.getElementById('nav-menu');
    const mainContent = document.querySelector('main');
    
 
    nav.classList.toggle('open');
    
    if (nav.classList.contains('open')) {
        mainContent.style.marginLeft = '200px';
    } else {
        mainContent.style.marginLeft = '0';
    }
});
