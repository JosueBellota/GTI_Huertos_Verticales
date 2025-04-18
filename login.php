<?php
// Mensaje inicial
$initial_msg = "Rellena tus credenciales";

// Mensaje de error de inicio de sesión
$login_err = "";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Incluir el archivo de configuración de la base de datos
  require_once "config/constants.php"; 

  // Definir las variables de entrada del formulario y limpiarlas
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  // Preparar la consulta SQL para verificar las credenciales del usuario
  $sql = "SELECT usuario_id, nombre, contrasena FROM Usuarios WHERE usuario = ?";

  if ($stmt = $conn->prepare($sql)) {
    // Vincular las variables a la declaración preparada como parámetros
    $stmt->bind_param("s", $param_username);

    // Establecer los parámetros
    $param_username = $username;

    // Intentar ejecutar la declaración preparada
    if ($stmt->execute()) {
      // Almacenar el resultado
      $stmt->store_result();

      // Verificar si el usuario existe, si es así, verificar la contraseña
      if ($stmt->num_rows == 1) {
        // Vincular las variables de resultado
        $stmt->bind_result($usuario_id, $nombre, $contrasena_hash);

        if ($stmt->fetch()) {
          // Verificar el hash de la contraseña
          if (password_verify($password, $contrasena_hash)) {
            // Contraseña válida, iniciar sesión
            session_start();

            // Almacenar datos de sesión
            $_SESSION["loggedin"] = true;
            $_SESSION["usuario_id"] = $usuario_id;
            $_SESSION["nombre"] = $nombre;

            // Redirigir al usuario a la página de inicio después del inicio de sesión exitoso
            header("location: cliente/index.php");
            exit; // Ensure that script stops execution after redirection
          } else {
            // Contraseña incorrecta
            $login_err = "Nombre de usuario o contraseña incorrectos.";
          }
        }
      } else {
        // Usuario no encontrado
        $login_err = "Nombre de usuario o contraseña incorrectos.";
      }
    } else {
      // Error al ejecutar la consulta
      $login_err = "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
    }

    // Cerrar la declaración
    $stmt->close();
  }

  // Cerrar la conexión
  $conn->close();
}
?>

  <?php include('includes/menu.php'); ?>

  <div class="screen">
    <div class="container-form">
      <h2>Iniciar Sesión</h2>

      <div class="space"></div>
      <?php
        if (!empty($login_err)) {
          echo '<p class="alert-danger">' . $login_err . '</p>';
        } else {
          echo '<p class="alert-green">' . $initial_msg . '</p>';
        }
      ?>
      <div class="space"></div>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
          <label for="username">Nombre de Usuario:</label>
          <input type="text" id="username" name="username" required autocomplete="username" placeholder="Ingrese su nombre de usuario">
        </div>
        <div class="form-group">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Ingrese su contraseña">
        </div>
        <div class="register-action-group">
          <button type="submit" class="btn btn-wine" id="send">Enviar</button>
          <a href="register.php" class="button-link">¿No tienes cuenta?</a>
        </div>
      </form>
    </div>
  </div>

  <?php include('includes/footer.php'); ?>
        