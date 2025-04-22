<?php
/**
 * Plugin Name: Mi Prueba Técnica
 * Description: Módulo de prueba técnica responsive con shortcode y bloque Gutenberg opcional.
 * Version: 1.0.0
 * Author: Tu Nombre
 */

if (!defined('ABSPATH')) {
    exit; // Salir si se accede directamente.
}

// Incluir la lógica del shortcode
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Opcionalmente, incluir la lógica del bloque Gutenberg
if (function_exists('register_block_type')) {
    require_once plugin_dir_path(__FILE__) . 'includes/gutenberg-block.php';
}

// Encolar estilos y scripts para el frontend
function mi_prueba_tecnica_enqueue_assets() {
    $plugin_url = plugin_dir_url(__FILE__);
    $asset_version = filemtime(plugin_dir_path(__FILE__) . 'frontend/dist/style.css');
    wp_enqueue_style('mi-prueba-tecnica-style', $plugin_url . 'frontend/dist/style.css', array(), $asset_version);

    $script_asset_path = plugin_dir_path(__FILE__) . 'frontend/dist/bundle.asset.php';
    if (file_exists($script_asset_path)) {
        $script_asset = require $script_asset_path;
        wp_enqueue_script('mi-prueba-tecnica-script', $plugin_url . 'frontend/dist/bundle.js', $script_asset['dependencies'], $script_asset['version'], true);
    } else {
        wp_enqueue_script('mi-prueba-tecnica-script', $plugin_url . 'frontend/dist/bundle.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'mi_prueba_tecnica_enqueue_assets');

function mi_prueba_tecnica_enqueue_scripts() {
    // Encola tu archivo de estilos (si aún no lo haces)
    wp_enqueue_style( 'mi-prueba-tecnica-style', plugin_dir_url( __FILE__ ) . 'frontend/dist/css/style.css' );

    // Encola tu archivo JavaScript
    wp_enqueue_script( 'mi-prueba-tecnica-script', plugin_dir_url( __FILE__ ) . 'frontend/dist/js/mi-menu-script.js', array(), null, true );
    // El array() indica dependencias (si las hay).
    // null indica la versión del script (puedes usar time() para evitar caché en desarrollo).
    // true indica que el script se cargará en el footer.
}
add_action( 'wp_enqueue_scripts', 'mi_prueba_tecnica_enqueue_scripts' );