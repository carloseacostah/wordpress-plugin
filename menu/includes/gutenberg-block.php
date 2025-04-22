<?php

function mi_prueba_tecnica_register_block() {
    register_block_type('mi-prueba-tecnica/menu', array(
        'attributes' => array(
            'selectedMenu' => array(
                'type' => 'string',
                'default' => '',
            ),
        ),
        'render' => 'mi_prueba_tecnica_render_block',
        'editor_script' => 'mi-prueba-tecnica-block-editor-script',
        'editor_style' => 'mi-prueba-tecnica-block-editor-style',
    ));
}
add_action('init', 'mi_prueba_tecnica_register_block');

function mi_prueba_tecnica_render_block($attributes) {
    $selected_menu_id = $attributes['selectedMenu'];

    if (!$selected_menu_id) {
        return '<p>' . esc_html__('Por favor, selecciona un menú en el editor.', 'mi-prueba-tecnica') . '</p>';
    }

    $menu_items = wp_get_nav_menu_items($selected_menu_id);

    if (!$menu_items || is_wp_error($menu_items)) {
        return '<p>' . esc_html__('No se encontraron elementos para este menú.', 'mi-prueba-tecnica') . '</p>';
    }

    ob_start();
    ?>
    <nav class="main-navigation">
        <div class="main-navigation__logo">
            <img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'frontend/dist/images/kschool-logo.svg'; ?>" alt="Kschool Logo">
        </div>
        <ul class="main-navigation__list">
            <?php
            $primary_items = array();
            $children = array();

            foreach ($menu_items as $item) {
                if ($item->menu_item_parent == 0) {
                    $primary_items[] = $item;
                } else {
                    $children[$item->menu_item_parent][] = $item;
                }
            }

            foreach ($primary_items as $primary_item) :
                $has_submenu = isset($children[$primary_item->ID]) && !empty($children[$primary_item->ID]);
                $active_class = ''; // Puedes añadir lógica para la clase activa si es necesario
                ?>
                <li class="main-navigation__item<?php if ($has_submenu) : ?> main-navigation__item--has-submenu<?php endif; ?><?php echo esc_attr($active_class); ?>">
                    <a href="<?php echo esc_url($primary_item->url); ?>" class="main-navigation__link"><?php echo esc_html($primary_item->title); ?></a>
                    <?php if ($has_submenu) : ?>
                        <ul class="submenu">
                            <?php foreach ($children[$primary_item->ID] as $child_item) : ?>
                                <li class="submenu__item"><a href="<?php echo esc_url($child_item->url); ?>" class="submenu__link"><?php echo esc_html($child_item->title); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            <?php
            // Los enlaces estáticos "AS Talent" y "Blog" podrían también gestionarse desde el menú de WordPress si es necesario
            ?>
            <?php
            $as_talent_page_id = get_page_by_path('as-talent'); // Reemplaza 'as-talent' con el slug correcto
            if ($as_talent_page_id) :
                ?>
                <li class="main-navigation__item"><a href="<?php echo esc_url(get_permalink($as_talent_page_id)); ?>" class="main-navigation__link">AS Talent</a></li>
                <?php
            else :
                ?>
                <li class="main-navigation__item"><a href="#" class="main-navigation__link">AS Talent</a></li>
                <?php
            endif;

            $blog_page_id = get_page_by_path('blog'); // Reemplaza 'blog' con el slug correcto
            if ($blog_page_id) :
                ?>
                <li class="main-navigation__item"><a href="<?php echo esc_url(get_permalink($blog_page_id)); ?>" class="main-navigation__link">Blog</a></li>
                <?php
            else :
                ?>
                <li class="main-navigation__item"><a href="#" class="main-navigation__link">Blog</a></li>
                <?php
            endif;
            ?>
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

    <div class="global-submenu-container">
        <ul class="global-submenu">
            <?php
            foreach ($primary_items as $primary_item) :
                if (isset($children[$primary_item->ID]) && !empty($children[$primary_item->ID])) :
                    ?>
                    <li class="global-submenu__parent" data-parent="<?php echo sanitize_title($primary_item->title); ?>">
                        <?php foreach ($children[$primary_item->ID] as $child_item) : ?>
                            <a href="<?php echo esc_url($child_item->url); ?>" class="global-submenu__link"><?php echo esc_html($child_item->title); ?></a>
                        <?php endforeach; ?>
                    </li>
                    <?php
                endif;
            endforeach;
            ?>
            <li class="global-submenu__parent" data-parent="astalent">
                <?php if ($as_talent_page_id) : ?>
                    <a href="<?php echo esc_url(get_permalink($as_talent_page_id)); ?>" class="global-submenu__link">AS Talent</a>
                <?php else : ?>
                    <a href="#" class="global-submenu__link">AS Talent</a>
                <?php endif; ?>
            </li>
            <li class="global-submenu__parent" data-parent="blog">
                <?php if ($blog_page_id) : ?>
                    <a href="<?php echo esc_url(get_permalink($blog_page_id)); ?>" class="global-submenu__link">Blog</a>
                <?php else : ?>
                    <a href="#" class="global-submenu__link">Blog</a>
                <?php endif; ?>
            </li>
            <li class="global-submenu__parent" data-parent="usuario">
                <a href="#" class="global-submenu__link">Acceder</a>
                <a href="#" class="global-submenu__link">Iniciar Sesión</a>
            </li>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}

// Encolar scripts y estilos (sin cambios necesarios aquí si ya están configurados)
function mi_prueba_tecnica_enqueue_block_editor_assets() {
    $plugin_url = plugin_dir_url(dirname(__FILE__));
    wp_enqueue_script(
        'mi-prueba-tecnica-block-editor-script',
        $plugin_url . 'frontend/dist/bundle.js',
        array('wp-blocks', 'wp-element', 'wp-i18n', 'wp-components', 'wp-editor', 'wp-block-editor', 'wp-api-fetch'),
        filemtime(plugin_dir_path(dirname(__FILE__)) . 'frontend/dist/bundle.js'),
        true
    );

    wp_enqueue_style(
        'mi-prueba-tecnica-block-editor-style',
        $plugin_url . 'frontend/dist/style.css',
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(dirname(__FILE__)) . 'frontend/dist/style.css')
    );
}
add_action('enqueue_block_editor_assets', 'mi_prueba_tecnica_enqueue_block_editor_assets');