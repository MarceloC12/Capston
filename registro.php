<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Mesa Feliz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="menu" style="position: absolute;">
        <div class="container">
            <a href="index.html" class="logo">
                <img src="images/logo.png" alt="Logo Mesa Feliz">
            </a>
            <nav class="navbar">
                <ul>
                    <li><a href="index.html">← Volver al Inicio</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Únete a la Mesa</h2>
                <p>Crea tu cuenta y empieza tu colección hoy.</p>
            </div>

            <form action="login_register.php" method="POST" class="auth-form">
                
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" name="name" id="name" placeholder="Tu nombre" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="Crea una contraseña segura" required>
                </div>

                <button type="submit" name="register" class="btn-auth">Registrarme</button>
            </form>

            <div class="auth-footer">
                <p>¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a></p>
            </div>
        </div>
    </div>

</body>
</html>