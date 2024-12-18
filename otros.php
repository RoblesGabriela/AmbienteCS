<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Chacón Store</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* Contenedor principal del modal */
        .carrito-modal {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            /* Superposición sobre el contenido */
        }

        /* Contenido del modal */
        .modal-content {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 15px;
            width: 300px;
            position: relative;
        }

        /* Botón de cierre (X) */
        .close {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 20px;
            color: #555;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }
    </style>

</head>

<body>
    <header>
        <div class="header-container d-flex align-items-center justify-content-between">
            <div class="menu-toggle">
                <button id="menu-toggle-btn">&#9776;</button>
            </div>

            <a href="index.html" class="link-tienda">
                <h1>Chacón Store</h1>

            </a>

            <div class="search-bar d-flex align-items-center">
                <input type="text" class="form-control me-2" placeholder="Buscar productos...">
                <button class="btn btn-primary">
                    <img src="image/lupa.png" alt="Buscar">
                </button>
            </div>
            <div class="cart">
                <button onclick="abrirCarrito()">
                    <img src="image/carrito.png" alt="Carrito">
                    <!-- Contador de artículos -->
                    <span id="contador-carrito" style="position: absolute; top: -25px; right: -15px; background-color: red; color: white; border-radius: 50%; padding: 5px 10px; font-size: 14px; font-weight: bold;"> 0 </span>
                </button>


                <div class="cart-empty-text" id="cartEmpty">
                    <span class="cart-empty-title">¡Hay un carrito que llenar!</span>
                    <span class="cart-empty-subtitle">
                        Actualmente no tenés productos en tu carrito.
                    </span>
                    <a href="https://www.chaconstore.cr/">
                        <button class="button-text_contained primary full-width" id="btnBuscar">
                            Buscar productos
                        </button>
                    </a>
                </div>
            </div>

    </header>
    <main>

        <nav id="nav-menu">
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="empleados.html">Empleados</a></li>
                <li><a href="telefonos.php">Teléfonos</a></li>
                <li><a href="computadoras.php">Computadoras</a></li>
                <li><a href="audifonos.php">Audífonos</a></li>
                <li><a href="otros.php">Otros</a></li>
                <li><a href="sobreNosotros.html">Sobre Nosotros</a></li>
            </ul>
        </nav>

    </main>

    <footer>
        <div class="footer-social">
            <a href="#"><img src="image/facebook.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/chacon_store/"><img src="image/instagram.png" alt="Instagram"></a>
        </div>
        <p>&copy; 2024 Todos los derechos reservados.</p>
    </footer>

    <div class="whatsapp-button">
        <a href="https://wa.me/1234567890" target="_blank">
            <img src="image/whatsapp.png" alt="WhatsApp">
        </a>
    </div>

    <script src="acciones.js"></script>