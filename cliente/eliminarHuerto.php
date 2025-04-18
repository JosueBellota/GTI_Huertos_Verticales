<?php
include('includes/menu-cliente.php');
require_once "../config/constants.php";

// Verificar sesión iniciada
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Procesar la solicitud de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_eliminar'])) {
    $huerto_id = $_POST['huerto_id'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Obtener todas las instalaciones asociadas al huerto
        $sql_get_instalaciones = "SELECT instalacion_id FROM Instalaciones WHERE huerto_id = ?";
        if ($stmt_get_instalaciones = $conn->prepare($sql_get_instalaciones)) {
            $stmt_get_instalaciones->bind_param("i", $huerto_id);
            $stmt_get_instalaciones->execute();
            $stmt_get_instalaciones->store_result();
            $stmt_get_instalaciones->bind_result($instalacion_id);

            // Eliminar todas las mediciones asociadas a cada instalación
            while ($stmt_get_instalaciones->fetch()) {
                $sql_delete_mediciones = "DELETE FROM Mediciones WHERE instalacion_id = ?";
                if ($stmt_delete_mediciones = $conn->prepare($sql_delete_mediciones)) {
                    $stmt_delete_mediciones->bind_param("i", $instalacion_id);
                    $stmt_delete_mediciones->execute();
                    $stmt_delete_mediciones->close();
                } else {
                    throw new Exception("Error al eliminar mediciones.");
                }
            }
            $stmt_get_instalaciones->close();
        } else {
            throw new Exception("Error al obtener instalaciones.");
        }

        // Eliminar todas las instalaciones asociadas al huerto
        $sql_delete_instalaciones = "DELETE FROM Instalaciones WHERE huerto_id = ?";
        if ($stmt_delete_instalaciones = $conn->prepare($sql_delete_instalaciones)) {
            $stmt_delete_instalaciones->bind_param("i", $huerto_id);
            $stmt_delete_instalaciones->execute();
            $stmt_delete_instalaciones->close();
        } else {
            throw new Exception("Error al eliminar instalaciones.");
        }

        // Eliminar todas las relaciones de usuario con el huerto
        $sql_delete_relacion = "DELETE FROM Usuarios_Huertos WHERE huerto_id = ?";
        if ($stmt_delete_relacion = $conn->prepare($sql_delete_relacion)) {
            $stmt_delete_relacion->bind_param("i", $huerto_id);
            $stmt_delete_relacion->execute();
            $stmt_delete_relacion->close();
        } else {
            throw new Exception("Error al eliminar la relación del usuario con el huerto.");
        }

        // Eliminar el huerto
        $sql_delete_huerto = "DELETE FROM Huertos WHERE huerto_id = ?";
        if ($stmt_delete_huerto = $conn->prepare($sql_delete_huerto)) {
            $stmt_delete_huerto->bind_param("i", $huerto_id);
            if ($stmt_delete_huerto->execute()) {
                $_SESSION['message'] = "Huerto eliminado correctamente.";
                $_SESSION['msg_type'] = "success";
            } else {
                throw new Exception("Error al eliminar el huerto.");
            }
            $stmt_delete_huerto->close();
        } else {
            throw new Exception("Error al preparar la consulta de eliminación.");
        }

        // Confirmar la transacción
        $conn->commit();

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    header("location: huertos.php");
    exit;
}

// Obtener el ID del huerto a eliminar
$huerto_id = $_GET['huerto_id'];
?>

<div class="screen">
    <div class="container-form">
        <h2>Eliminar Huerto</h2>

        <div class="space"></div>
        <p class="alert-danger">¿Estás seguro de que deseas eliminar este huerto?</p>
        <div class="space"></div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="huerto_id" value="<?php echo htmlspecialchars($huerto_id); ?>">
            <div class="register-action-group">
                <button type="submit" class="btn btn-wine" name="confirmar_eliminar">Eliminar</button>
                <a href="huertos.php" class="button-link">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer-cliente.php'); ?>
