<?php
/*
Plugin Name: Modulo
Description: Módulo responsive con HTML, SCSS, JS y shortcode.
Version: 1.0
Author: Ceah
*/

function modulo_plugin_enqueue_assets() {
    wp_enqueue_style('modulo-plugin-style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('modulo-plugin-script', plugin_dir_url(__FILE__) . 'js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'modulo_plugin_enqueue_assets');

function render_modulo_custom() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/modulo.php';
    return ob_get_clean();
}
add_shortcode('modulo_custom', 'render_modulo_custom');

// Registro opcional de bloque Gutenberg
function modulo_register_gutenberg_block() {
    wp_register_script(
        'modulo-gutenberg-block',
        plugins_url('blocks/block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(plugin_dir_path(__FILE__) . 'blocks/block.js')
    );

    register_block_type('modulo/bloque', array(
        'editor_script' => 'modulo-gutenberg-block',
        'render_callback' => 'render_modulo_custom',
    ));
}
add_action('init', 'modulo_register_gutenberg_block');
?>