<?php include('includes/menu.php'); ?>


<div class="landing-page">
    <div class="content-container">
        <div class="content">
            <h1>SENSORES <br>
                VERDES  <br>
                INTELIGENTES 
            </h1>
            <p>¡Cultiva tu jardín vertical sin estrés!
                Nuestros sensores te aseguran un jardín siempre vibrante con mínimo esfuerzo.
            </p>
            <button class="btn btn-green" onclick="redirectToProduct()">Ver mas</button>
            <script>
                function redirectToProduct() {
                    // Redirect to product.html
                    window.location.href = "producto.php";
                }
            </script>
        </div>
    </div>
</div>    


<?php include('includes/footer.php'); ?>



