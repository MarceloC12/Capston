<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa Feliz - Tienda de Juegos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="menu">
        <div class="container">
            <a href="#" class="logo">
                <img src="images/logo.png" alt="Logo de Mesa Feliz">
            </a>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#111419" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </label>

            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="servicios.html">Servicios</a></li>

                    <li class="dropdown">
                        <a href="productos.html" class="dropbtn">Productos ▾</a>
                        <ul class="dropdown-content">
                            <li><a href="productos.html">Ver Todo</a></li>
                            <li><a href="Pokemon.html">Pokémon</a></li>
                            <li><a href="One-Piece.html">One Piece</a></li>
                            <li><a href="Digimon.html">Digimon</a></li>
                        </ul>
                    </li>
                    <li><a href="Accesorios.html">Accesorios</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>

                <div class="cart-icon-container" id="cart-icon-btn">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </div>
            </nav>

            <div class="navbar-actions">
                <ul>
                    <?php if (isset($_SESSION['name'])): ?>
                        <li style="display: flex; align-items: center; gap: 15px;">
                            <span style="font-weight: 700; color: #111419;">
                                ¡Hola, <?php echo htmlspecialchars($_SESSION['name']); ?>! 👋
                            </span>
                            <a href="logout.php" class="btn-login-nav" style="background-color: #d63031; border-color: #d63031;">
                                Salir
                            </a>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="btn-login-nav">Ingresar</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

    <header class="header">
        <div class="header-content container">
            <div class="header-txt">
                <span class="badge-welcome">¡Bienvenidos a Mesa Feliz!</span>
                <h1>Ofertas <br> <span class="highlight">Especiales</span></h1>
                <p>Descubre los mejores juegos y accesorios para tus tardes de diversión. Calidad premium y precios increíbles en TCG y Juegos de Mesa.</p>
                <div class="buttons">
                    <a href="productos.html" class="btn-hero primary">Ver Catálogo</a>
                    <a href="servicios.html" class="btn-hero secondary">Nuestros Servicios</a>
                </div>
            </div>
            <div class="header-img">
                <img src="images/banner.webp" alt="Banner promocional de cartas coleccionables">
            </div>
        </div>
    </header>

    <section class="ofertas container">
        <div class="ofert-card b1">
            <div class="ofert-content">
                <h3>Accesorios</h3>
                <p>Mejora tu experiencia de juego</p>
                <a href="Accesorios.html" class="btn-ofert">Ver colección</a>
            </div>
            <div class="ofert-img-wrapper">
                <img src="Images/Dados.png" alt="Dados y accesorios">
            </div>
        </div>

        <div class="ofert-card b2">
            <div class="ofert-content">
                <h3>Juegos de Cartas</h3>
                <p>Pokémon, One Piece y más</p>
                <a href="Pokemon.html" class="btn-ofert">Ver cartas</a>
            </div>
            <div class="ofert-img-wrapper">
                <img src="Images/800px-Logo_Pokémon_Trading_Card_Game.png" alt="Logo Pokemon TCG">
            </div>
        </div>

        <div class="ofert-card b3">
            <div class="ofert-content">
                <h3>Juegos de Mesa</h3>
                <p>Diversión para todos</p>
                <a href="productos.html" class="btn-ofert">Ver juegos</a>
            </div>
            <div class="ofert-img-wrapper">
                <img src="Images/juegos.png" alt="Caja de juego Catan">
            </div>
        </div>
    </section>

    <main class="product container">
        <h2>Nuestros Productos Destacados</h2>
        <div class="box-container con-paginacion" id="lista-1">
            <div class="box">
                <img src="images/DeckboxXLNegro.webp" alt="Caja para mazo Deck Box XL color negro">
                <div class="product-txt">
                    <h3>Deck Box XL</h3>
                    <p>Top Deck</p>
                    <p class="precio">$23.990</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="1">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="Images/DeckBoxTopPremium.png">
                <div class="product-txt">
                    <h3>Deck Box Top Premium</h3>
                    <p>Top Deck</p>
                    <p class="precio">$25.000</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="2">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="images/deckblanco.jpg" alt="Caja para mazo Deck Box Premium Blanco">
                <div class="product-txt">
                    <h3>Deck Box XL</h3>
                    <p>Top Deck</p>
                    <p class="precio">$25.000</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="3">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="images/deckrojo.webp" alt="Caja para mazo Deck Box XL color rojo">
                <div class="product-txt">
                    <h3>Deck Box XL</h3>
                    <p>Top Deck</p>
                    <p class="precio">$20.000</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="4">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="images/juegos.png" alt="Juego Catan">
                <div class="product-txt">
                    <h3>Catan - El juego</h3>
                    <p>Devir</p>
                    <p class="precio">$29.990</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="5">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="images/polilla.webp" alt="Juego Polilla Tramposa">
                <div class="product-txt">
                    <h3>Polilla - El juego</h3>
                    <p>Devir</p>
                    <p class="precio">$19.990</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="6">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="images/dobble31.webp" alt="Juego Dobble 31 Minutos">
                <div class="product-txt">
                    <h3>Dobble</h3>
                    <p>31 minutos</p>
                    <p class="precio">$15.990</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="7">Agregar al carrito</a>
                </div>
            </div>
            <div class="box">
                <img src="images/one-piece-card-game-a-fist-of-divine-speed-booster-box-op-11.webp" alt="Booster Box One Piece">
                <div class="product-txt">
                    <h3>Booster Box One Piece</h3>
                    <p>One piece TCG</p>
                    <p class="precio">$129.990</p>
                    <a href="#" class="agregar-carrito btn-3" data-id="8">Agregar al carrito</a>
                </div>
            </div>
        </div>
        <div class="btn-2" id="load-more">Cargar Más</div>
    </main>

    <div class="section-divider"></div>

    <section class="highlight-section container">
        <div class="highlight-content">
            <span class="tag-promo">Novedad Digimon TCG</span>
            <h2>Blast Ace: <br> El Tráiler Oficial</h2>
            <p>Descubre las nuevas mecánicas y el arte increíble de la última expansión. ¡Prepárate para llevar tu mazo al siguiente nivel!</p>
            <div class="action-buttons">
                <a href="Digimon.html" class="btn-yellow">
                    Ver Productos
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:8px;">
                        <path d="M5 12h14"></path>
                        <path d="M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="video-wrapper">
            <iframe
                src="https://www.youtube.com/embed/uTYwm-QXCN8?si=PI5hpOOCdJvJwde8"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>
        </div>
    </section>

    <div class="section-divider"></div>

    <section class="testimonial container">
        <span>Testimonios</span>
        <h2>Qué opinan nuestros clientes</h2>
        <div class="testimonial-content">
            <div class="testimonial-card">
                <img src="images/cliente1.png" alt="Foto del cliente Carlos">
                <div class="testimonial-text">
                    <p>"¡Excelente servicio! Los productos llegaron súper rápido y en perfecto estado. La calidad de las cajas para mazos es increíble, muy recomendados."</p>
                    <h4>Carlos V.</h4>
                </div>
            </div>
            <div class="testimonial-card">
                <img src="images/cliente2.png" alt="Foto de la clienta Andrea">
                <div class="testimonial-text">
                    <p>"Me encantó la variedad de juegos que tienen. Pude encontrar todo lo que buscaba para mis noches de juego con amigos. ¡Volveré a comprar sin duda!"</p>
                    <h4>Andrea M.</h4>
                </div>
            </div>
        </div>
    </section>

    <footer class="pro-footer">
        <div class="container footer-grid">
            <div class="footer-col">
                <h4>Secciones de Interés</h4>
                <ul>
                    <li><a href="productos.html">Nuestros Productos</a></li>
                    <li><a href="contacto.html">Contáctanos</a></li>
                    <li><a href="politicas_dev.html">Política de Devolución</a></li>
                    <li><a href="politicas_pre.html">Política de Preventas</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contáctanos</h4>
                <ul>
                    <li><span class="contact-info">📞 +56 9 6846 1475</span></li>
                    <li><span class="contact-info">📧 contmesafeliz@gmail.com</span></li>
                    <li><span class="contact-info">📍 Avda Lazo #1315, San Miguel, RM</span></li>
                </ul>
            </div>
            <div class="footer-col newsletter-col">
                <h4>SUSCRÍBETE Y PREPÁRATE PARA RECIBIR TONELADAS DE SPAM 😉</h4>
                <form action="#" class="newsletter-form">
                    <input type="email" placeholder="Ingresa tu email..." required>
                    <button type="submit">ENVIAR</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Mesa Feliz.</p>
        </div>
    </footer>

    <div id="cart-overlay" class="cart-overlay"></div>

    <div class="cart-sidebar" id="carrito">
        <div class="cart-header">
            <h2>Tu Carrito</h2>
            <button class="close-cart">&times;</button>
        </div>

        <div class="cart-items">
            <table id="lista-carrito" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">Img</th>
                        <th style="text-align: left;">Producto</th>
                        <th style="text-align: center;">Precio</th>
                        <th style="text-align: center;">Cant</th>
                        <th style="text-align: center;">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div class="cart-footer">
            <div class="total-pagar">
                Total: <span id="total-carrito">$0</span>
            </div>
            <button id="vaciar-carrito" class="btn-hero primary" style="width: 100%; margin-top: 10px;">Vaciar Carrito</button>
            <button class="btn-hero secondary" style="width: 100%; margin-top: 10px;">Ir a Pagar</button>
        </div>
    </div>
    <div id="modal-login" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">🔒</div>
            <h3>¡Necesitas Iniciar Sesión!</h3>
            <p>Para asegurar tu compra y enviarte el recibo, necesitas ingresar a tu cuenta de Mesa Feliz.</p>
            <div class="modal-actions">
                <button id="btn-cerrar-modal" class="btn-hero secondary" style="padding: 10px 20px;">Cancelar</button>
                <a href="login.php" class="btn-hero primary" style="padding: 10px 20px; text-decoration: none;">Ir a Ingresar</a>
            </div>
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>