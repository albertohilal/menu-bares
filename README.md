# Menu Bares

Plugin personalizado para WordPress que permite mostrar y editar el menú de un bar mediante shortcodes. Desarrollado para ser utilizado por clientes directamente desde el frontend.

## 📦 Características

- Listado de productos categorizados por tipo (bebidas, comidas, etc.).
- Visualización en dos columnas para facilitar el diseño en Elementor.
- Soporte para precios y descripciones.
- Edición desde frontend protegida por login personalizado.
- Acceso público mediante slug único (ej: `/nocturno-menu/`).
- Uso de base de datos externa para gestionar productos, categorías y clientes autorizados.

## 🧩 Shortcodes disponibles

- `[menu_bar]`  
  Muestra el menú público del bar según el slug en la URL. Ordenado por categoría y presentado en dos columnas.

- `[form_menu_cliente]`  
  Muestra el formulario para que el cliente (dueño del bar) edite su menú. Requiere autenticación por token.

## 🗂️ Estructura del plugin

menu-bares/
├── menu-bares.php # Plugin principal
├── login.html # Formulario de acceso para clientes
├── form_crud.html # Formulario CRUD para productos
├── servidor.js # Backend Node.js con Express y MySQL
├── .env # Variables de entorno (ignorado por Git)
├── env.example # Ejemplo del archivo .env
├── README.md # Este archivo

markdown
Copiar
Editar

## 🚀 Instalación y uso

1. Subir `menu-bares.php` a la carpeta `/wp-content/plugins/`.
2. Activar el plugin desde el panel de WordPress.
3. Crear una página y colocar el shortcode `[menu_bar]` o `[form_menu_cliente]`.
4. Asegurarse de tener un cliente activo con slug público cargado en la tabla `aa_clientes_autorizados`.
5. Si se usa el CRUD, iniciar el servidor con Node.js:
   ```bash
   node servidor.js
🌐 Requisitos
WordPress instalado

MySQL con las tablas:

aa_clientes_autorizados

aa_menu_productos

aa_menu_categorias

Servidor Node.js para la interfaz CRUD

🛡️ Seguridad
El menú público no requiere login y se basa en el slug de la URL.

El formulario de edición de productos está protegido por token.

Las credenciales del servidor deben mantenerse en .env, fuera del repositorio.

Desarrollado por Desarrollo y Diseño
Alberto Hilal