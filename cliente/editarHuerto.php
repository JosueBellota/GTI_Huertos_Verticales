<?php
include('includes/menu-cliente.php');

// Verificar sesión iniciada
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardar_cambios'])) {
    $huerto_id = $_POST['huerto_id'];
    $nuevo_nombre = $_POST['nombre'];
    $nueva_ubicacion = $_POST['ubicacion'];

    $sql_actualizar = "UPDATE Huertos SET nombre = ?, ubicacion = ? WHERE huerto_id = ?";
    if ($stmt = $conn->prepare($sql_actualizar)) {
        $stmt->bind_param("ssi", $nuevo_nombre, $nueva_ubicacion, $huerto_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Huerto actualizado correctamente.";
            $_SESSION['msg_type'] = "success";
            header("location: huertos.php");
            exit;
        } else {
            echo "Error: No se pudo ejecutar la actualización.";
        }
        $stmt->close();
    } else {
        echo "Error: No se pudo preparar la consulta.";
    }
} else {
    $huerto_id = $_GET['huerto_id'];

    $sql = "SELECT nombre, ubicacion FROM Huertos WHERE huerto_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $huerto_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $huerto = $result->fetch_assoc();
                $nombre = $huerto['nombre'];
                $ubicacion = $huerto['ubicacion'];
            } else {
                echo "Error: Huerto no encontrado.";
                exit;
            }
            $stmt->close();
        } else {
            echo "Error: No se pudo ejecutar la consulta.";
            exit;
        }
    } else {
        echo "Error: No se pudo preparar la consulta.";
        exit;
    }
}
?>

<div class="screen">
    <div class="container-form">
        <h2>Editar Huerto</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="huerto_id" value="<?php echo $huerto_id; ?>">
            <div class="form-group">
                <label for="nombre">Nombre del Huerto</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación del Huerto</label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="<?php echo htmlspecialchars($ubicacion); ?>" required>
            </div>
            <div class="register-action-group">
                <button type="submit" class="btn btn-wine" name="guardar_cambios">Guardar Cambios</button>
                <a href="huertos.php" class="button-link">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer-cliente.php'); ?>
