<?php
// Mensaje inicial
$initial_msg = "Por favor, rellene el formulario para crear una cuenta";

// Mensaje de error de registro
$register_err = "";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de configuración de la base de datos
    require_once "config/constants.php";

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validar que las contraseñas coincidan
    if ($password != $confirm_password) {
        $register_err = "Las contraseñas no coinciden.";
    } else {
        // Preparar la consulta SQL para insertar un nuevo usuario
        $sql = "INSERT INTO Usuarios (nombre, email, usuario, contrasena, rol_id) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Vincular las variables a la declaración preparada como parámetros
            $stmt->bind_param("ssssi", $param_full_name, $param_email, $param_username, $param_password, $param_rol_id);

            // Establecer los parámetros
            $param_full_name = $full_name;
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña
            $param_rol_id = 3; // Asignar rol de "Usuario"

            // Intentar ejecutar la declaración preparada
            if ($stmt->execute()) {
                // Redirigir al usuario a la página de inicio de sesión después del registro exitoso
                header("location: cliente/index.php");
                exit; // Asegurarse de que el script se detenga después de la redirección
            } else {
                $register_err = "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            // Cerrar la declaración
            $stmt->close();
        }
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<?php include('includes/menu.php'); ?>

<!-- registro.php -->
<div class="screen2">
    <div class="container-form">
        <h2>Registro</h2>

        <div class="space"></div>
        <?php
        // Mostrar mensaje inicial o mensaje de error, no ambos
        if (!empty($register_err)) {
            echo '<p class="alert-danger">' . $register_err . '</p>';
        } else {
            echo '<p class="alert-green">' . $initial_msg . '</p>';
        }
        ?>
        <div class="space"></div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="full_name">Nombre Completo:</label>
                <input type="text" id="full_name" name="full_name" required autocomplete="name" placeholder="Ingrese su nombre completo">
            </div>
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required autocomplete="username" placeholder="Ingrese su nombre de usuario">
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required autocomplete="email" placeholder="Ingrese su correo electrónico">
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Ingrese su contraseña">
            </div>
            <div class="form-group">
                <label for="confirm_password">Repetir Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password" placeholder="Repita su contraseña">
            </div>
            <div class="form-group-policy">
                <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                <label for="privacy_policy">He leído y acepto las <a href="politicas.php" class="button-link">políticas de privacidad</a></label>
            </div>
            <div class="register-action-group">
                <button type="submit" class="btn btn-wine" id="register">Registrar</button>
                <a href="login.php" class="button-link">¿Ya tienes cuenta?</a>
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>
