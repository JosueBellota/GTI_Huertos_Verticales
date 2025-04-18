<?php
include("includes/menu-cliente.php");

$usuario_id = $_SESSION["usuario_id"];
?>

<div class="landing-page">
    <div class="background-image">
    </div>
    <div class="content-container">
        <div class="content">
            <h1>BIENVENIDO <br>
                <?php echo htmlspecialchars($usuario["nombre"]); ?>
            </h1>
            <p>¡Cultiva tu jardín vertical sin estrés!
                Nuestros sensores te aseguran un jardín siempre vibrante con mínimo esfuerzo.
            </p>
            <button class="btn btn-green" onclick="redirectToProduct()">Mis Huertos</button>
            <script>
                function redirectToProduct() {
                    // Redirect to product.html
                    window.location.href = "huertos.php";
                }
            </script>
        </div>
    </div>
</div>    

<?php
include("includes/footer-cliente.php");
?>
