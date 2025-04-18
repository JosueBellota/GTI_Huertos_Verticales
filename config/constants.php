<?php 
// Iniciar Sesión

session_start();

// Crear Constantes para Almacenar Valores No Repetitivos
define('SITEURL', 'https://jbelich.upv.edu.es/src/'); // Actualiza la URL principal del proyecto según sea necesario
define('LOCALHOST', 'localhost:3306');
define('DB_USERNAME', 'jbelich_user');
define('DB_PASSWORD', 'Bellota@1769');
define('DB_NAME', 'jbelich_huertosverticales');

// Conexión a la Base de Datos
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); // Conexión a la Base de Datos


$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); // Seleccionando la Base de Datos

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

