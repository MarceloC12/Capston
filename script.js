document.addEventListener('DOMContentLoaded', () => {

    // cargar más de los productos
    let loadMoreBtn = document.querySelector('#load-more');
    let currentItem = 4;

    if (loadMoreBtn) {
        loadMoreBtn.onclick = () => {
            let boxes = [...document.querySelectorAll('.box-container .box')];
            for (var i = currentItem; i < currentItem + 4; i++) {
                if (boxes[i]) {
                    boxes[i].style.display = 'flex';
                }
            }
            currentItem += 4;
            if (currentItem >= boxes.length) {
                loadMoreBtn.style.display = 'none';
            }
        }
    }

    // lógica carrito de compras
    let articulosCarrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const carrito = document.getElementById('carrito') || document.querySelector('.cart-sidebar');
    const elementos1 = document.getElementById('lista-1');
    const lista = document.querySelector('#lista-carrito tbody');
    const vaciarcarritoBtn = document.getElementById('vaciar-carrito');
    const cartCountElement = document.querySelector('.cart-count');
    const totalElement = document.getElementById('total-carrito');
    // cargar lo guardado al iniciar
    carritoHTML();
    actualizarContador();
    if (elementos1) {
        elementos1.addEventListener('click', comprarElemento);
    }
    
    if (carrito) {
        carrito.addEventListener('click', eliminarElemento);
    }
    
    if (vaciarcarritoBtn) {
        vaciarcarritoBtn.addEventListener('click', vaciarCarrito);
    }

    function comprarElemento(e) {
        e.preventDefault();
        if(e.target.classList.contains('agregar-carrito') || e.target.classList.contains('btn-3')) {
            const elemento = e.target.parentElement.parentElement;
            leerDatosElemento(elemento);
        }
    }

    function leerDatosElemento(elemento) {
        const infoElemento = {
            imagen: elemento.querySelector('img').src,
            titulo: elemento.querySelector('h3') ? elemento.querySelector('h3').textContent : 'Producto',
            precio: elemento.querySelector('.precio') ? elemento.querySelector('.precio').textContent : '$0',
            id: elemento.querySelector('a').getAttribute('data-id'),
            cantidad: 1
        }

        const existe = articulosCarrito.some(curso => curso.id === infoElemento.id);

        if(existe) {
            const cursos = articulosCarrito.map(curso => {
                if(curso.id === infoElemento.id) {
                    curso.cantidad++;
                    return curso;
                } else {
                    return curso;
                }
            });
            articulosCarrito = [...cursos];
        } else {
            articulosCarrito = [...articulosCarrito, infoElemento];
        }

        carritoHTML();
        actualizarContador();
        sincronizarStorage();
    }

    function eliminarElemento(e) {
        if(e.target.classList.contains('borrar')) {
            e.preventDefault();
            const productoId = e.target.getAttribute('data-id');
            
            articulosCarrito = articulosCarrito.filter(curso => curso.id !== productoId);

            carritoHTML();
            actualizarContador();
            sincronizarStorage();
        }
    }

    function vaciarCarrito() {
        articulosCarrito = [];
        limpiarHTML();
        actualizarContador();
        sincronizarStorage();
    }

    function sincronizarStorage() {
        localStorage.setItem('carrito', JSON.stringify(articulosCarrito));
    }

    function carritoHTML() {
        limpiarHTML();
        let totalGeneral = 0;

        articulosCarrito.forEach(producto => {
            const { imagen, titulo, precio, cantidad, id } = producto;
            
            // calculo de subtotal
            const precioLimpio = precio.replace('$', '').replace(/\./g, '');
            const precioNumero = parseInt(precioLimpio) || 0;
            const subtotal = precioNumero * cantidad;
            totalGeneral += subtotal;
            const subtotalFormato = '$' + subtotal.toLocaleString('es-CL');

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><img src="${imagen}" width=50 style="border-radius:5px;"></td>
                <td>${titulo}</td>
                <td>${precio}</td>
                <td style="text-align:center;">${cantidad}</td>
                <td style="font-weight:bold;">${subtotalFormato}</td>
                <td><a href="#" class="borrar" data-id="${id}" style="color:#ff4d4d; font-weight:bold; font-size:18px; text-decoration:none;">&times;</a></td>
            `;
            if(lista) {
                lista.appendChild(row);
            }
        });

        if(totalElement) {
            totalElement.innerText = '$' + totalGeneral.toLocaleString('es-CL');
        }
    }

    function limpiarHTML() {
        if(lista) {
            while(lista.firstChild) {
                lista.removeChild(lista.firstChild);
            }
        }
        if(totalElement && articulosCarrito.length === 0) {
            totalElement.innerText = '$0';
        }
    }
    
    function actualizarContador() {
        let totalArticulos = 0;
        articulosCarrito.forEach(producto => {
            totalArticulos += producto.cantidad;
        });
        if(cartCountElement) {
            cartCountElement.innerText = totalArticulos;
        }
    }

    const cartIcon = document.getElementById('cart-icon-btn'); 
    const cartSidebar = document.getElementById('carrito') || document.querySelector('.cart-sidebar');
    const closeCartBtn = document.querySelector('.close-cart');

    if (cartIcon && cartSidebar) {
        cartIcon.addEventListener('click', (e) => {
            e.preventDefault();
            cartSidebar.classList.add('active');
        });
    }

    if (closeCartBtn && cartSidebar) {
        closeCartBtn.addEventListener('click', () => {
            cartSidebar.classList.remove('active');
        });
    }


    // --- LOGIN / REGISTRO ---
    window.showForm = function(formId) {
        const forms = document.querySelectorAll(".form-box");
        forms.forEach(form => form.classList.remove("active"));
        
        const formToShow = document.getElementById(formId);
        if (formToShow) {
            formToShow.classList.add("active");
        }
    }

    // integración stripe
    const btnPagar = document.querySelector('#carrito .btn-hero.secondary');

    if (btnPagar) {
        btnPagar.addEventListener('click', async (e) => {
            e.preventDefault();
            // obtener carrito
            const carritoParaPagar = JSON.parse(localStorage.getItem('carrito')) || [];
            if (carritoParaPagar.length === 0) {
                alert("Tu carrito está vacío");
                return;
            }

            // cambiar texto y deshabilitar
            const textoOriginal = btnPagar.innerText;
            btnPagar.innerText = "Procesando...";
            btnPagar.style.opacity = "0.7";
            btnPagar.disabled = true;

            try {
                // enviar datos a PHP (checkout.php)
                const response = await fetch('checkout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ items: carritoParaPagar })
                });

                if (response.status === 401) {
                    // si el usuario no está logeado, hacemos que lo hagaxd
                    const modalLogin = document.getElementById('modal-login');
                    if (modalLogin) {
                        modalLogin.style.display = 'flex';
                    } else {
                        alert("Debes iniciar sesión para pagar.");
                        window.location.href = 'login.php';
                    }
                    restaurarBoton();
                    return; 
                }
                const data = await response.json();

                // redirigir a stripe si salió to bn
                if (data.url) {
                    window.location.href = data.url;
                } else {
                    console.error('Error del servidor:', data.error);
                    alert("Error al iniciar el pago. Revisa la consola.");
                    restaurarBoton();
                }

            } catch (error) {
                console.error("Error de conexión:", error);
                alert("Error de conexión con el servidor de pago.");
                restaurarBoton();
            }
            // función auxiliar para volver el botón a la normalidad x si falla
            function restaurarBoton() {
                btnPagar.innerText = textoOriginal;
                btnPagar.style.opacity = "1";
                btnPagar.disabled = false;
            }
        });
    }

    const modalLogin = document.getElementById('modal-login');
    const btnCerrarModal = document.getElementById('btn-cerrar-modal');
    if (btnCerrarModal) {
        btnCerrarModal.addEventListener('click', () => {
            if(modalLogin) modalLogin.style.display = 'none';
        });
    }
    
    // cerrar si hacen clic fuera de la cajita pa logearse
    if (modalLogin) {
        modalLogin.addEventListener('click', (e) => {
            if (e.target === modalLogin) {
                modalLogin.style.display = 'none';
            }
        });
    }

});