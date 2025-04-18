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
$nombre = $usuario = $email = $general_err = "";
$nombre_err = $usuario_err = $email_err = $contrasena_err = "";

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar nuevo nombre
    if (empty(trim($_POST["nombre"]))) {
        $nombre_err = "Por favor, introduce un nombre.";
    } else {
        $nombre = trim($_POST["nombre"]);
    }

    // Validar nuevo nombre de usuario
    if (empty(trim($_POST["usuario"]))) {
        $usuario_err = "Por favor, introduce un nombre de usuario.";
    } else {
        $usuario = trim($_POST["usuario"]);
    }

    // Validar nuevo correo electrónico
    if (empty(trim($_POST["email"]))) {
        $email_err = "Por favor, introduce un correo electrónico.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validar la contraseña actual
    if (empty(trim($_POST["contrasenaAnterior"]))) {
        $general_err = "Por favor, introduce tu contraseña actual para confirmar.";
    } else {
        $contrasenaAnterior = trim($_POST["contrasenaAnterior"]);
    }

    // Verificar la contraseña actual
    if (empty($general_err)) {
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

    // Si no hay errores, actualizar los datos en la base de datos
    if (empty($nombre_err) && empty($usuario_err) && empty($email_err) && empty($general_err)) {
        $sql = "UPDATE Usuarios SET nombre = ?, usuario = ?, email = ? WHERE usuario_id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $nombre, $usuario, $email, $usuario_id);

            if ($stmt->execute()) {
                // Guardar el mensaje de éxito en la sesión
                $_SESSION["success_msg"] = "Perfil actualizado correctamente.";
                // Redirigir al perfil
                header("location: perfil.php");
                exit;
            } else {
                $general_err = "Error: No se pudo actualizar el perfil.";
            }
            
            $stmt->close();
        } else {
            $general_err = "Error: No se pudo preparar la consulta.";
        }
    }
}

// Obtener la información actual del usuario
$sql = "SELECT nombre, usuario, email FROM Usuarios WHERE usuario_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $usuario_id);

    if ($stmt->execute()) {
        $stmt->bind_result($nombre_actual, $usuario_actual, $email_actual);
        $stmt->fetch();
    } else {
        echo "Error: No se pudo ejecutar la consulta.";
    }

    $stmt->close();
} else {
    echo "Error: No se pudo preparar la consulta.";
}
?>

<div class="editar-perfil-page">
    <div class="editar-perfil-container">
        <h2>Editar Perfil</h2>
        <div class="space"></div>
        <?php if (!empty($general_err)): ?>
            <p class="alert-danger"><?php echo htmlspecialchars($general_err); ?></p>
        <?php else: ?>
            <p class="alert-green">Actualiza tu información personal</p>
        <?php endif; ?>
        <div class="space"></div>
        <form id="editarPerfilForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nombre">Nuevo Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre_actual); ?>" required>
                <span class="error"><?php echo $nombre_err; ?></span>
            </div>
            <div class="form-group">
                <label for="usuario">Nuevo Nombre de Usuario:</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario_actual); ?>" required>
                <span class="error"><?php echo $usuario_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Nuevo Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_actual); ?>" required>
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-message">
                <p>Por favor, introduzca su contraseña actual para confirmar los cambios.</p>
            </div>
            <div class="form-group">
                <label for="contrasenaAnterior">Contraseña Actual:</label>
                <input type="password" id="contrasenaAnterior" name="contrasenaAnterior" required>
                <span class="error"><?php echo $general_err; ?></span>
            </div>
            <div class="form-actions">
                <button type="submit" class="edit-profile-link">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
<?php
include("includes/footer-cliente.php");
?>
