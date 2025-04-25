<?php 
// Iniciar Sesión

session_start();

// Crear Constantes para Almacenar Valores No Repetitivos
define('SITEURL', 'http://localhost:8000/'); // Actualiza la URL principal del proyecto según sea necesario
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'jbelich_huertosverticales');

// Conexión a la Base de Datos
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); // Conexión a la Base de Datos


$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); // Seleccionando la Base de Datos

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

