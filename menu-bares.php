<?php
/*
Plugin Name: Menú Bares
*/

add_shortcode('menu_bares', 'mostrar_menu_bar');

function mostrar_menu_bar() {
    ob_start();

    $slug = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

    echo "<h1 style='text-align: center;'>Nuestro Menú</h1>";

    global $wpdb;

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

    $cliente_slug = $cliente->cliente_slug;

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

    $categorias = [];

    foreach ($productos as $producto) {
        $categoria = $producto->categoria;
        if (!isset($categorias[$categoria])) {
            $categorias[$categoria] = [];
        }
        $categorias[$categoria][] = $producto;
    }

    foreach ($categorias as $categoria => $items) {
        echo "<h2 style='margin-top: 30px;'>$categoria</h2>";
        echo "<div style='display: flex; flex-wrap: wrap;'>";

        foreach ($items as $index => $producto) {
            $nombre = esc_html($producto->nombre_producto);
            $descripcion = esc_html($producto->descripcion);
            $precio = number_format($producto->precio, 2, ',', '.');
            echo "
                <div style='width: 50%; padding: 10px; box-sizing: border-box;'>
                    <p>
                        <strong>$nombre</strong>: $descripcion
                        <em>– \$$precio</em>
                    </p>
                </div>
            ";
        }

        echo "</div>";
    }

    return ob_get_clean();
}
