<?php

$initial_msg = "Rellena tus credenciales";
$login_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


  require_once "config/constants.php"; 
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);
  $sql = "SELECT usuario_id, nombre, contrasena FROM Usuarios WHERE usuario = ?";

  if ($stmt = $conn->prepare($sql)) {
  
    $stmt->bind_param("s", $param_username);
    $param_username = $username;


    if ($stmt->execute()) {
     
      $stmt->store_result();

      if ($stmt->num_rows == 1) {

        $stmt->bind_result($usuario_id, $nombre, $contrasena_hash);

        if ($stmt->fetch()) {
        
          if (password_verify($password, $contrasena_hash)) {
          
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["usuario_id"] = $usuario_id;
            $_SESSION["nombre"] = $nombre;
            header("location: cliente/index.php");
            exit; 
            
          } else {

            $login_err = "Nombre de usuario o contraseña incorrectos.";
          }
        }
      } else {

        $login_err = "Nombre de usuario o contraseña incorrectos.";
      }
    } else {

      $login_err = "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
    }

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
        