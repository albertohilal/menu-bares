<?php
/*
Plugin Name: Menú Bares
*/

// Shortcode principal
add_shortcode('menu_bar', 'mostrar_menu_bar');

function mostrar_menu_bar() {
    ob_start();

    // Obtener el slug de la URL
    $slug = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

   echo "<h1>Nuestro Menú</h1>";


    // Conexión a la base de datos de WordPress
    global $wpdb;

    // Buscar el cliente por slug_publico
    $tabla_clientes = 'iunaorg_bares.aa_clientes_autorizados';
    $cliente = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $tabla_clientes WHERE slug_publico = %s AND activo = 1",
            $slug
        )
    );

    if (!$cliente) {
        echo "<p style='color:red;'>No se encontró el menú para esta URL.</p>";
        return ob_get_clean();
    }

    // Usamos cliente_slug para buscar productos
    $cliente_slug = $cliente->cliente_slug;

    // Obtener productos
    $tabla_productos = 'iunaorg_bares.aa_menu_productos';
    $productos = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $tabla_productos WHERE cliente_slug = %s AND visible = 1 ORDER BY categoria, nombre_producto",
            $cliente_slug
        )
    );

    if (!$productos) {
        echo "<p style='color:red;'>Este bar aún no cargó productos visibles.</p>";
        return ob_get_clean();
    }

    // Agrupar productos por categoría
    $categorias = [];
    foreach ($productos as $producto) {
        $categorias[$producto->categoria][] = $producto;
    }

    echo "<div class='menu-bar'>";
    foreach ($categorias as $categoria => $items) {
        echo "<h3>$categoria</h3><ul>";
        foreach ($items as $item) {
            echo "<li><strong>{$item->nombre_producto}</strong>: {$item->descripcion} – <em>$" . number_format($item->precio, 2, ',', '.') . "</em></li>";
        }
        echo "</ul>";
    }
    echo "</div>";

    return ob_get_clean();
}
?>
