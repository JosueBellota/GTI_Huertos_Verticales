<?php
include("includes/menu-cliente.php");

// Verificar sesión iniciada
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Consultar y mostrar lista de huertos del usuario
$sql = "SELECT h.huerto_id, h.nombre 
        FROM Huertos h
        INNER JOIN Usuarios_Huertos uh ON h.huerto_id = uh.huerto_id
        WHERE uh.usuario_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION["usuario_id"]);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $huertos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        echo "Error: No se pudo ejecutar la consulta.";
        exit;
    }
} else {
    echo "Error: No se pudo preparar la consulta.";
    exit;
}
?>

<div class="welcome">
    <div class="space"></div>
    <h1>TUS HUERTOS</h1>
    <h4>Selecciona uno de tus Huertos</h4>
    <div class="space"></div>
    <div class="huerto-msg">
    <?php
    if (isset($_SESSION['message'])) {
        echo '<p class="alert-green">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }
    ?>
    </div>
    
    <div class="space"></div>
    <div id="huertos-menu" class="huertos-gallery">
        <?php foreach ($huertos as $huerto) : ?>
            <div class="huerto-card">

                <a href="instalaciones.php?huerto_id=<?php echo $huerto['huerto_id']; ?>" class="huerto-link">
                    <h3><?php echo htmlspecialchars($huerto["nombre"]); ?></h3>
                </a>
                
                <div class="huerto-actions">
                    <a href="eliminarHuerto.php?huerto_id=<?php echo $huerto['huerto_id']; ?>" class="btn btn-eliminar"><i class="bi bi-trash"></i> Eliminar</a>
                    <a href="editarHuerto.php?huerto_id=<?php echo $huerto['huerto_id']; ?>" class="btn btn-editar"><i class="bi bi-pencil-square"></i> Editar</a>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="huerto-card add-huerto">
            <a href="agregarHuerto.php">
                <i class="bi bi-plus-circle"></i>
            </a>
        </div>
    </div>
</div>

<?php include("includes/footer-cliente.php"); ?>
