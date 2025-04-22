document.addEventListener('DOMContentLoaded', function() {
    const mainNavItemsWithSubmenu = document.querySelectorAll('.main-navigation__item--has-submenu');
    const mainNavigation = document.querySelector('.main-navigation');
    const globalSubmenuContainer = document.querySelector('.global-submenu-container');

    mainNavItemsWithSubmenu.forEach(item => {
        item.addEventListener('mouseenter', function() {
            // Muestra la barra amarilla y el contenedor del submenú al hacer hover en un item con submenú
            mainNavigation.classList.add('show-yellow-bar');
            globalSubmenuContainer.style.display = 'flex'; // Aseguramos que el contenedor del submenú sea visible
        });

        item.addEventListener('mouseleave', function() {
            // Oculta la barra amarilla y el contenedor del submenú si el cursor sale del item y del submenú
            const isMouseOverSubmenu = globalSubmenuContainer.matches(':hover');
            const isMouseOverNavItem = this.matches(':hover');

            if (!isMouseOverSubmenu && !isMouseOverNavItem) {
                mainNavigation.classList.remove('show-yellow-bar');
                globalSubmenuContainer.style.display = 'none';
            }
        });
    });

    // Oculta la barra y el submenú si el cursor sale del contenedor del submenú
    globalSubmenuContainer.addEventListener('mouseleave', function() {
        mainNavigation.classList.remove('show-yellow-bar');
        this.style.display = 'none';
    });

    // Oculta la barra si el cursor sale del menú principal y no está sobre un item con submenú
    mainNavigation.addEventListener('mouseleave', function(event) {
        const isMouseOverNavItemWithSubmenu = Array.from(mainNavItemsWithSubmenu).some(item => item.matches(':hover'));
        const isMouseOverSubmenu = globalSubmenuContainer.matches(':hover');

        if (!isMouseOverNavItemWithSubmenu && !isMouseOverSubmenu) {
            mainNavigation.classList.remove('show-yellow-bar');
            globalSubmenuContainer.style.display = 'none';
        }
    });
});