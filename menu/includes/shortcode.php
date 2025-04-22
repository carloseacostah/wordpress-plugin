<?php

function mi_prueba_tecnica_shortcode($atts = [], $content = null, $tag = '') {
    // Normalizar los atributos a minúsculas
    $atts = array_change_key_case((array)$atts, CASE_LOWER);

    // Extraer atributos (puedes definir atributos personalizados aquí)
    $attributes = shortcode_atts([], $atts, $tag);

    ob_start();
    ?>
    <nav class="main-navigation">
        <div class="main-navigation__logo">
            <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'frontend/dist/images/kschool-logo.png'; ?>" alt="Kschool Logo">
        </div>
        <ul class="main-navigation__list">
            <li class="main-navigation__item main-navigation__item--has-submenu">
                <a href="#" class="main-navigation__link">Formación</a>
                <ul class="submenu">
                    <li class="submenu__item"><a href="#" class="submenu__link">Digital Marketing School</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Tech School</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Business School</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Space School</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Design School</a></li>
                </ul>
            </li>
            <li class="main-navigation__item main-navigation__item--has-submenu">
                <a href="#" class="main-navigation__link">Servicios</a>
                <ul class="submenu">
                    <li class="submenu__item"><a href="#" class="submenu__link">InCompany</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Eventos</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Empleo</a></li>
                </ul>
            </li>
            <li class="main-navigation__item main-navigation__item--has-submenu main-navigation__item--active-hover">
                <a href="#" class="main-navigation__link">Oposiciones</a>
                <ul class="submenu">
                    <li class="submenu__item submenu__item--highlighted"><a href="#" class="submenu__link">Oposiciones</a></li>
                    <li class="submenu__item"><a href="#" class="submenu__link">Másteres Profesionales</a></li>
                </ul>
            </li>
            <li class="main-navigation__item"><a href="#" class="main-navigation__link">AS Talent</a></li>
            <li class="main-navigation__item"><a href="#" class="main-navigation__link">Blog</a></li>
        </ul>
        <div class="main-navigation__actions">
            <a href="#" class="main-navigation__action-icon">🌐</a> <a href="#" class="main-navigation__action-icon">🏢</a> <div class="main-navigation__user main-navigation__item--has-submenu">
                <a href="#" class="main-navigation__action-icon">👤</a> <div class="submenu submenu--user">
                    <a href="#" class="submenu__link">Acceder</a>
                    <a href="#" class="submenu__link">Iniciar Sesión</a>
                </div>
            </div>
            <a href="#" class="main-navigation__button">unirte</a>
        </div>
    </nav>
    <?php
    return ob_get_clean();
}
add_shortcode('mi_prueba_tecnica_menu', 'mi_prueba_tecnica_shortcode');