<?php
include("includes/menu-cliente.php");

// Mensajes de éxito (si existen)
$success_msg = isset($_SESSION["success_msg"]) ? $_SESSION["success_msg"] : '';
unset($_SESSION["success_msg"]);
?>
<div class="perfil-page">
    <div class="perfil-container">
        <h2>Perfil de Usuario</h2>
        
        <?php if (!empty($success_msg)): ?>
            <p class="alert-success"><?php echo htmlspecialchars($success_msg); ?></p>
        <?php endif; ?>
        
        <div class="perfil-info">
            <p><strong>Nombre:</strong> <span id="nombre"><?php echo htmlspecialchars($usuario['nombre']); ?></span></p>
            <p><strong>Nombre de Usuario:</strong> <span id="usuario"><?php echo htmlspecialchars($usuario['usuario']); ?></span></p>
            <p><strong>Correo Electrónico:</strong> <span id="email"><?php echo htmlspecialchars($usuario['email']); ?></span></p>
        </div>
        <div class="space"></div>
        <div class="perfil-actions">
            <a href="editarPerfil.php" id="editProfile" class="edit-profile-link">Editar Perfil</a>
            <a href="cambiarContrasena.php" id="editProfile" class="edit-profile-link2">Cambiar Contraseña</a>
        </div>
        <div class="space"></div>
        <h3>Huertos</h3>
        <div class="space"></div>
        <div class="table-responsive">
            <!-- Tabla Huertos -->
            <?php include("includes/tablaHuertos.php"); ?>
        </div>
        <div class="space"></div>
        <h3>Instalaciones</h3>
        <div class="space"></div>
        <div class="table-responsive">
            <!-- Tabla Instalaciones -->
            <?php include("includes/tablaInstalaciones.php"); ?>
        </div>
    </div>
</div>
<?php
include("includes/footer-cliente.php");
?>
