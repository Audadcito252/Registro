<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #3A6B5D;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .register-form {
            padding: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #000000;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #3A6B5D;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background-color: #3A6B5D;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2a5246;
        }
        .error-message {
            color: #EC0617;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        .success-message {
            color: #3A6B5D;
            font-size: 15px;
            margin-top: 10px;
            display: none;
        }
        footer {
            text-align: center;
            margin-top: 30px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Registro</h1>
            <p>Crea tu cuenta para continuar</p>
        </header>
        <section class="register-form">
            <form id="registroForm" method="POST" action="/registro">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    <p class="error-message" id="nombre-error">El nombre es obligatorio</p>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@dominio.com" required>
                    <p class="error-message" id="email-error">Por favor ingresa un correo electrónico válido</p>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Tu contraseña" required>
                    <p class="error-message" id="password-error">La contraseña debe tener al menos 6 caracteres</p>
                </div>
                <div class="form-group">
                    <label for="confirmar">Confirmar Contraseña</label>
                    <input type="password" id="confirmar" name="confirmar" placeholder="Repite tu contraseña" required>
                    <p class="error-message" id="confirmar-error">Las contraseñas no coinciden</p>
                </div>
                <button class="btn" type="submit">Registrarse</button>
                <p class="success-message" id="success-message">¡Registro exitoso!</p>
            </form>
        </section>
        <footer>
            &copy; 2025 Registro App
        </footer>
    </div>
    <script>
        const form = document.getElementById('registroForm');
        const nombre = document.getElementById('nombre');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmar = document.getElementById('confirmar');
        const nombreError = document.getElementById('nombre-error');
        const emailError = document.getElementById('email-error');
        const passwordError = document.getElementById('password-error');
        const confirmarError = document.getElementById('confirmar-error');
        const successMessage = document.getElementById('success-message');

        function showError(element) {
            element.style.display = 'block';
            element.classList.add('fade-in');
        }
        function hideError(element) {
            element.style.display = 'none';
            element.classList.remove('fade-in');
        }
        form.addEventListener('submit', function(e) {
            let valid = true;
            hideError(nombreError);
            hideError(emailError);
            hideError(passwordError);
            hideError(confirmarError);
            successMessage.style.display = 'none';

            if (!nombre.value.trim()) {
                showError(nombreError);
                valid = false;
            }
            if (!email.value.match(/^\S+@\S+\.\S+$/)) {
                showError(emailError);
                valid = false;
            }
            if (password.value.length < 6) {
                showError(passwordError);
                valid = false;
            }
            if (password.value !== confirmar.value) {
                showError(confirmarError);
                valid = false;
            }
            if (!valid) {
                e.preventDefault();
            } else {
                // Puedes dejar que el formulario se envíe al backend
                successMessage.style.display = 'block';
                successMessage.classList.add('fade-in');
            }
        });
    </script>
</body>
</html>
