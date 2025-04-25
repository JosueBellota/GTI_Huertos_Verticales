
<?php

// Incluir el archivo de configuración de la base de datos
require_once "../config/constants.php";

// Verify if the user is authenticated
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  // Redirect the user to the public login page
  header("location: ../login.php");
  exit;
}
// Obtener información del usuario desde la sesión
$usuario_id = $_SESSION["usuario_id"];

// Preparar la consulta SQL para obtener todos los datos del usuario
$sql = "SELECT * FROM Usuarios WHERE usuario_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $usuario_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
        } else {
            echo "Error: No se encontró al usuario.";
            exit;
        }
    } else {
        echo "Error: No se pudo ejecutar la consulta.";
        exit;
    }
    
    // $stmt->close();
} else {
    echo "Error: No se pudo preparar la consulta.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensores Inteligentes</title>

    <!-- google fonts Montserrat -->  

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- ---------------bootstrap icons--------- -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Estilos -->
   
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="css/menufootercliente.css">
    <!-- <link rel="stylesheet" href="../css/cliente.css"> -->
    <link rel="stylesheet" href="../css/landing.css">
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="stylesheet" href="css/huertos.css">
    <link rel="stylesheet" href="css/instalaciones.css">

    <!-- chartjs -->

    <!-- jsdelivr -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <!-- luxon -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js"></script>
    <!-- chartjs-adapter-luxon -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.1/dist/chartjs-adapter-luxon.umd.min.js"></script>


</head>
<body>

    <!-- menu -->

    <header class="menu-cliente">
    <div class="header__container">
        <a href="index.php" class="header__logo">
            <img src="../img/logoGTI.svg" alt="Site Logo" class="header__logo-image" />
        </a>
        <nav class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item"><a href="index.php">Inicio</a></li>
                <li class="header__nav-item"><a href="huertos.php">Huertos</a></li>
                <li class="header__nav-item"><a href="logout.php">Cerrar Sesión</a></li>
                <div class="close-icon">
                  <i class="bi bi-x-lg"></i>
                </div>
            </ul>

            
            <!-- Icono de Perfil -->
            <div class="profile">
                <a href="perfil.php">
                <i class="bi bi-person-circle"></i>
                <span><?php echo htmlspecialchars($usuario["nombre"]); ?></span>
                </a>
            </div>


            <!-- Icono de Menu -->
            <div class="menu-icon" id="menu-icon">
              
              <i class="bi bi-list"></i>
               
            </div>
  
            <!-- <img src="../img/menu.png" class="menu-icon" id="menu-icon" alt=""> -->
        </nav>
        <script src="js/responsive-menu.js"></script>
    </div>
</header>