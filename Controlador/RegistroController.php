<?php
class RegistroController {
    public function mostrarFormulario() {
        require_once __DIR__ . '/../Vista/registro.php';
    }
    public function procesarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmar = $_POST['confirmar'] ?? '';
            $errores = [];
            if ($nombre === '') $errores[] = 'El nombre es obligatorio.';
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Correo inválido.';
            if (strlen($password) < 6) $errores[] = 'Contraseña muy corta.';
            if ($password !== $confirmar) $errores[] = 'Las contraseñas no coinciden.';
            if (count($errores) === 0) {
                require_once __DIR__ . '/../Modelo/Usuario.php';
                require_once __DIR__ . '/../Modelo/Conexion.php';
                $usuario = new Usuario($nombre, $email, password_hash($password, PASSWORD_DEFAULT));
                $conn = Conexion::conectar();
                $stmt = $conn->prepare('INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)');
                $stmt->bind_param('sss', $usuario->nombre, $usuario->email, $usuario->password);
                if ($stmt->execute()) {
                    echo '<div class="alert alert-success">¡Registro exitoso!</div>';
                } else {
                    if ($conn->errno === 1062) {
                        echo '<div class="alert alert-danger">El correo ya está registrado.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error al registrar: ' . htmlspecialchars($conn->error) . '</div>';
                    }
                }
                $stmt->close();
                $conn->close();
            } else {
                foreach ($errores as $error) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
                }
            }
        }
    }
}
