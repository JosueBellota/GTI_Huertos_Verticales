<?php
include("includes/menu-cliente.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Obtener información del usuario desde la sesión
$usuario_id = $_SESSION["usuario_id"];

// Inicializar variables
$contrasenaNueva = $repetirContrasenaNueva = $contrasenaAnterior = "";
$contrasenaNueva_err = $repetirContrasenaNueva_err = $general_err = "";

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar nueva contraseña
    if (empty(trim($_POST["contrasenaNueva"]))) {
        $contrasenaNueva_err = "Por favor, introduce la nueva contraseña.";
    } else {
        $contrasenaNueva = trim($_POST["contrasenaNueva"]);
    }

    // Validar repetición de la nueva contraseña
    if (empty(trim($_POST["repetirContrasenaNueva"]))) {
        $repetirContrasenaNueva_err = "Por favor, repite la nueva contraseña.";
    } else {
        $repetirContrasenaNueva = trim($_POST["repetirContrasenaNueva"]);
        if ($contrasenaNueva !== $repetirContrasenaNueva) {
            $repetirContrasenaNueva_err = "Las contraseñas no coinciden.";
        }
    }

    // Validar la contraseña actual
    if (empty(trim($_POST["contrasenaAnterior"]))) {
        $general_err = "Por favor, introduce tu contraseña actual para confirmar.";
    } else {
        $contrasenaAnterior = trim($_POST["contrasenaAnterior"]);
    }

    // Verificar la contraseña actual
    if (empty($general_err) && empty($contrasenaNueva_err) && empty($repetirContrasenaNueva_err)) {
        $sql = "SELECT contrasena FROM Usuarios WHERE usuario_id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $usuario_id);

            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($hashed_password);
                    if ($stmt->fetch()) {
                        if (!password_verify($contrasenaAnterior, $hashed_password)) {
                            $general_err = "La contraseña actual no es correcta.";
                        }
                    }
                } else {
                    $general_err = "Error: Usuario no encontrado.";
                }
            } else {
                $general_err = "Error: No se pudo ejecutar la consulta.";
            }
            
            $stmt->close();
        } else {
            $general_err = "Error: No se pudo preparar la consulta.";
        }
    }

    // Si no hay errores, actualizar la contraseña en la base de datos
    if (empty($contrasenaNueva_err) && empty($repetirContrasenaNueva_err) && empty($general_err)) {
        $sql = "UPDATE Usuarios SET contrasena = ? WHERE usuario_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $hashed_nueva_contrasena = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
            $stmt->bind_param("si", $hashed_nueva_contrasena, $usuario_id);

            if ($stmt->execute()) {
                // Contraseña actualizada exitosamente
                header("location: perfil.php");
                exit;
            } else {
                $general_err = "Error: No se pudo actualizar la contraseña.";
            }
            
            $stmt->close();
        } else {
            $general_err = "Error: No se pudo preparar la consulta.";
        }
    }
}

?>

<div class="perfil-page">
    <div class="perfil-container">
        <h2>Cambiar Contraseña</h2>
        <div class="space"></div>
        <?php
        if (!empty($general_err)) {
            echo '<p class="alert-danger">' . $general_err . '</p>';
        } else {
            echo '<p class="alert-green">Introduce tu nueva contraseña</p>';
        }
        ?>
        <div class="space"></div>
        <form id="cambiarContrasenaForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="contrasenaNueva">Nueva Contraseña:</label>
                <input type="password" id="contrasenaNueva" name="contrasenaNueva" required>
                <span class="alert-danger"><?php echo $contrasenaNueva_err; ?></span>
            </div>
            <div class="form-group">
                <label for="repetirContrasenaNueva">Repetir Nueva Contraseña:</label>
                <input type="password" id="repetirContrasenaNueva" name="repetirContrasenaNueva" required>
                <span class="alert-danger"><?php echo $repetirContrasenaNueva_err; ?></span>
            </div>
            <div class="form-message">
                <p>Por favor, introduzca su contraseña actual para confirmar el cambio.</p>
            </div>
            <div class="form-group">
                <label for="contrasenaAnterior">Contraseña Actual:</label>
                <input type="password" id="contrasenaAnterior" name="contrasenaAnterior" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="edit-profile-link">Cambiar Contraseña</button>
            </div>
        </form>
    </div>
</div>
<?php
include("includes/footer-cliente.php");
?>
