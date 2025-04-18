<?php
include('includes/menu-cliente.php');

// Verificar sesión iniciada
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_huerto'])) {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $usuario_id = $_SESSION["usuario_id"];

    // Insertar el nuevo huerto
    $sql_insert_huerto = "INSERT INTO Huertos (nombre, ubicacion) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql_insert_huerto)) {
        $stmt->bind_param("ss", $nombre, $ubicacion);
        if ($stmt->execute()) {
            $huerto_id = $stmt->insert_id;
            
            // Asociar el nuevo huerto con el usuario
            $sql_insert_usuario_huerto = "INSERT INTO Usuarios_Huertos (usuario_id, huerto_id) VALUES (?, ?)";
            if ($stmt_usuario_huerto = $conn->prepare($sql_insert_usuario_huerto)) {
                $stmt_usuario_huerto->bind_param("ii", $usuario_id, $huerto_id);
                if ($stmt_usuario_huerto->execute()) {
                    $_SESSION['message'] = "Huerto agregado correctamente.";
                    $_SESSION['msg_type'] = "success";
                    header("location: huertos.php");
                    exit;
                } else {
                    $_SESSION['message'] = "Error al asociar el huerto con el usuario.";
                    $_SESSION['msg_type'] = "danger";
                }
                $stmt_usuario_huerto->close();
            } else {
                $_SESSION['message'] = "Error al preparar la consulta de asociación.";
                $_SESSION['msg_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Error: No se pudo ejecutar la inserción del huerto.";
            $_SESSION['msg_type'] = "danger";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: No se pudo preparar la consulta para insertar el huerto.";
        $_SESSION['msg_type'] = "danger";
    }
}
?>

<div class="screen">
    <div class="container-form">
        <h2>Agregar Nuevo Huerto</h2>
        <div class="space"></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Huerto</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ubicacion">Ubicación del Huerto</label>
                <input type="text" name="ubicacion" id="ubicacion" class="form-control" required>
            </div>
            <div class="register-action-group">
                <button type="submit" class="btn btn-wine" name="agregar_huerto">Agregar Huerto</button>
                <a href="huertos.php" class="button-link">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer-cliente.php'); ?>
