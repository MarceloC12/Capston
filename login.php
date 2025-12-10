<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset(); 

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Mesa Feliz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="menu" style="position: absolute; top: 0; width: 100%;">
        <div class="container">
            <a href="index.php" class="logo">
                <img src="images/logo.png" alt="Logo de Mesa Feliz">
            </a>
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="productos.html">Productos</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="auth-container-wrapper">
        <div class="container-auth">
            
            <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
                <form action="login_register.php" method="post">
                    <h2>Iniciar Sesión</h2>
                    <?= showError($errors['login']); ?>
                    
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    
                    <button type="submit" name="login">Ingresar</button>
                    
                    <p>¿No tienes cuenta? <a href="#" onclick="showForm('register-form')">Regístrate</a></p>
                </form>
            </div>

            <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
                <form action="login_register.php" method="post">
                    <h2>Registrarse</h2>
                    <?= showError($errors['register']); ?>
                    
                    <input type="text" name="name" placeholder="Nombre completo" required>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    
                    <select name="role" required>
                        <option value="">-- Selecciona Rol --</option>
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                    
                    <button type="submit" name="register">Registrarse</button>
                    
                    <p>¿Ya tienes cuenta? <a href="#" onclick="showForm('login-form')">Inicia Sesión</a></p>
                </form>
            </div>
            
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>