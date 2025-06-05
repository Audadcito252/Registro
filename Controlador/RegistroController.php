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
            if (count($errores) === 0) {                require_once __DIR__ . '/../Modelo/Usuario.php';
                require_once __DIR__ . '/../Modelo/Conexion.php';
                
                // Información de depuración
                error_log("Intentando registrar usuario: $nombre, $email");
                
                try {
                    $usuario = new Usuario($nombre, $email, password_hash($password, PASSWORD_DEFAULT));
                    $conn = Conexion::conectar();
                    
                    if ($conn->connect_errno) {
                        error_log("Error de conexión a la BD: " . $conn->connect_error);
                        echo '<div class="alert alert-danger">Error de conexión a la base de datos: ' . htmlspecialchars($conn->connect_error) . '</div>';
                        return;
                    }
                    
                    $stmt = $conn->prepare('INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)');
                    if (!$stmt) {
                        error_log("Error en la preparación de la consulta: " . $conn->error);
                        echo '<div class="alert alert-danger">Error en la preparación de la consulta: ' . htmlspecialchars($conn->error) . '</div>';
                        return;
                    }
                    
                    $stmt->bind_param('sss', $usuario->nombre, $usuario->email, $usuario->password);
                    
                    if ($stmt->execute()) {
                        error_log("Usuario registrado correctamente con ID: " . $conn->insert_id);
                        echo '<div class="alert alert-success">¡Registro exitoso!</div>';
                    } else {
                        if ($conn->errno === 1062) {
                            error_log("Error: correo duplicado: $email");
                            echo '<div class="alert alert-danger">El correo ya está registrado.</div>';
                        } else {
                            error_log("Error al insertar: " . $conn->error);
                            echo '<div class="alert alert-danger">Error al registrar: ' . htmlspecialchars($conn->error) . '</div>';
                        }                    }
                } catch (Exception $e) {
                    error_log("Excepción: " . $e->getMessage());
                    echo '<div class="alert alert-danger">Error inesperado: ' . htmlspecialchars($e->getMessage()) . '</div>';
                }
                
                if (isset($stmt)) $stmt->close();
                if (isset($conn)) $conn->close();
            } else {
                foreach ($errores as $error) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
                }
            }
        }
    }
}
