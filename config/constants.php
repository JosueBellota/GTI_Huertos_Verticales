<?php 

session_start();

define('SITEURL', 'http://localhost:8000/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'jbelich_huertosverticales');

// Conexión a la Base de Datos
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); 


$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); 

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

