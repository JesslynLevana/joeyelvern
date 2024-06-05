document.getElementById('mobile-menu-button').addEventListener('click', function() {
    var menu = document.getElementById('mobile-menu');
    var iconMenu = document.getElementById('icon-menu');
    var iconClose = document.getElementById('icon-close');

    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        iconMenu.classList.add('hidden');
        iconClose.classList.remove('hidden');
    } else {
        menu.classList.add('hidden');
        iconMenu.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }
});

document.addEventListener('click', function(event) {
    var userMenuButton = document.getElementById('user-menu-button');
    var userMenu = document.getElementById('user-menu');
    if (userMenuButton && userMenu) {
        if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
            userMenu.classList.add('hidden');
        }
    }
});