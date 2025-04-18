<?php include('includes/menu.php'); ?>

    <div class="container container-product">
        <div class="gallery">
            <div class="main-image">
                <img id="mainImg" src="img/huerto-5.jpg" alt="Main Image">
            </div>
            <div class="thumbnails">
                <img class="thumbnail" src="img/huerto-1.jpg" alt="Thumbnail 1" onclick="changeImage(this, 'img/huerto-1.jpg')">
                <img class="thumbnail" src="img/huerto-2.jpg" alt="Thumbnail 2" onclick="changeImage(this, 'img/huerto-2.jpg')">
                <img class="thumbnail" src="img/huerto-3.jpg" alt="Thumbnail 3" onclick="changeImage(this, 'img/huerto-3.jpg')">
                <img class="thumbnail" src="img/huerto-4.jpg" alt="Thumbnail 4" onclick="changeImage(this, 'img/huerto-4.jpg')">
                <img class="thumbnail selected" src="img/huerto-5.jpg" alt="Reset Image" onclick="resetImage(this)">
            </div>

            <div class="slider-arrows">
                <p onclick="prevImage()">&#8249;</p>
                <p onclick="nextImage()">&#8250;</p>
            </div>

        </div>
        <div class="description">

            <h1>Sonda</h1>

            <p>
            ¡Optimiza tu huerto vertical con nuestra sonda de 5 sensores! Con esta innovadora herramienta, podrás monitorear de manera precisa y en tiempo real los niveles de humedad del suelo, la temperatura, la intensidad lumínica, la conductividad eléctrica y el pH, garantizando así un entorno óptimo para el crecimiento de tus plantas.
            </p>

            <h4>Disponible en las grandes superficies</h4>
        </div>
    </div>

    <script src="js/product-gallery.js"></script>

    
<?php include('includes/footer.php'); ?>
