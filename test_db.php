<?php
// Script para probar la conexión a la base de datos

// Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión
require_once __DIR__ . '/Modelo/Conexion.php';

echo "<h2>Prueba de conexión a la base de datos</h2>";

try {
    // Intentar conectar a la base de datos
    $conn = Conexion::conectar();
    
    echo "<p style='color: green'>Conexión exitosa a la base de datos!</p>";
    
    // Verificar si la tabla usuarios existe
    $result = $conn->query("SHOW TABLES LIKE 'usuarios'");
    if ($result->num_rows > 0) {
        echo "<p>La tabla 'usuarios' existe.</p>";
        
        // Verificar la estructura de la tabla
        echo "<h3>Estructura de la tabla 'usuarios':</h3>";
        $result = $conn->query("DESCRIBE usuarios");
        echo "<pre>";
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>";
        
        // Contar registros en la tabla
        $result = $conn->query("SELECT COUNT(*) as total FROM usuarios");
        $row = $result->fetch_assoc();
        echo "<p>Hay {$row['total']} registros en la tabla 'usuarios'.</p>";
        
        // Mostrar los primeros 5 registros
        $result = $conn->query("SELECT * FROM usuarios LIMIT 5");
        if ($result->num_rows > 0) {
            echo "<h3>Algunos registros existentes:</h3>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Fecha creación</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . (isset($row['creado_en']) ? htmlspecialchars($row['creado_en']) : 'N/A') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay registros en la tabla 'usuarios'.</p>";
        }
    } else {
        echo "<p style='color: red'>La tabla 'usuarios' no existe!</p>";
        
        // Intentar crear la tabla
        echo "<p>Intentando crear la tabla 'usuarios'...</p>";
        $sql = "CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green'>Tabla 'usuarios' creada con éxito!</p>";
        } else {
            echo "<p style='color: red'>Error al crear la tabla: " . $conn->error . "</p>";
        }
    }
    
    // Cerrar la conexión
    $conn->close();
} catch (Exception $e) {
    echo "<p style='color: red'>Error de conexión: " . $e->getMessage() . "</p>";
}
?>
