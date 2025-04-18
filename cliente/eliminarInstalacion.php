<?php
// Incluir el archivo de menú del cliente si es necesario
include("includes/menu-cliente.php");

// Definir variables para mensajes de éxito y error
$success_msg = $error_msg = '';

// Verificar si se proporcionó el parámetro huerto_id
if (!isset($_GET['huerto_id']) || !is_numeric($_GET['huerto_id'])) {
    $error_msg = "Error: Huerto no válido.";
} else {
    // Obtener el huerto_id desde el parámetro GET
    $huerto_id = $_GET['huerto_id'];

    // Obtener las instalaciones disponibles para este huerto
    $sqlGetInstalaciones = "SELECT instalacion_id, fecha_instalacion FROM Instalaciones WHERE huerto_id = $huerto_id";
    $resultInstalaciones = $conn->query($sqlGetInstalaciones);

    // Procesar la eliminación de la instalación seleccionada
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $instalacion_id = $_POST['instalacion_id'] ?? '';

        if (!empty($instalacion_id) && is_numeric($instalacion_id)) {
            // Eliminar primero las mediciones asociadas a esta instalación
            $sqlDeleteMediciones = "DELETE FROM Mediciones WHERE instalacion_id = $instalacion_id";
            if ($conn->query($sqlDeleteMediciones) === TRUE) {
                // Luego eliminar la instalación seleccionada
                $sqlDeleteInstalacion = "DELETE FROM Instalaciones WHERE instalacion_id = $instalacion_id";

                if ($conn->query($sqlDeleteInstalacion) === TRUE) {
                    $success_msg = "Instalación y sus mediciones eliminadas correctamente.";

                    // Redireccionar a instalaciones.php con el huerto_id
                    header("Location: instalaciones.php?huerto_id=$huerto_id");
                    exit(); // Asegurar que el script se detiene después de redirigir
                } else {
                    $error_msg = "Error al eliminar la instalación: " . $conn->error;
                }
            } else {
                $error_msg = "Error al eliminar las mediciones asociadas: " . $conn->error;
            }
        } else {
            $error_msg = "Error: Selecciona una instalación válida.";
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<div class="screen">
<div class="container-form">
    <div class="space"></div>
    <h2>Eliminar Instalación</h2>
    <div class="space"></div>

    <?php if (!empty($error_msg)): ?>
        <p class="alert-danger"><?php echo htmlspecialchars($error_msg); ?></p>
    <?php endif; ?>

    <?php if ($resultInstalaciones && $resultInstalaciones->num_rows > 0): ?>
        <form action="eliminarInstalacion.php?huerto_id=<?php echo $huerto_id; ?>" method="post">
            <div class=".chart-controls2">
                <label for="instalacion">Selecciona una instalación:</label>
                <select id="instalacion" name="instalacion_id" required>
                    <?php while ($row = $resultInstalaciones->fetch_assoc()): ?>
                        <option value="<?php echo $row['instalacion_id']; ?>">
                            <?php echo $row['fecha_instalacion']; ?> (ID: <?php echo $row['instalacion_id']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="space"></div>
            <div class="register-action-group">
                <button type="submit" class="btn btn-wine">Eliminar Instalación</button>
                <?php else: ?>
                    <p>No hay instalaciones disponibles para este huerto.</p>
                <?php endif; ?>
                <a href="instalaciones.php?huerto_id=<?php echo $huerto_id; ?>" class="button-link">Cancelar</a>
            </div>
            
        </form>
  
    <?php if (!empty($success_msg)): ?>
        <p class="alert-success"><?php echo htmlspecialchars($success_msg); ?></p>
    <?php endif; ?>
</div>
</div>
<?php include('includes/footer-cliente.php'); ?>
