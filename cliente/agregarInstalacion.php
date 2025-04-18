<?php
// Incluir el archivo de menú del cliente si es necesario
include("includes/menu-cliente.php");

// Definir variables para mensajes de éxito y error
$success_msg = $error_msg = '';

// Verificar si se proporcionó el parámetro huerto_id
if (!isset($_GET['huerto_id']) || !is_numeric($_GET['huerto_id'])) {
    $error_msg = "Error: Huerto no válido.";
} else {
    // Obtener el huerto_id desde el parámetro GET
    $huerto_id = $_GET['huerto_id'];

    // Procesar la lógica para agregar la instalación
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener el token enviado por el formulario
        $token = $_POST['token'] ?? '';

        if (!empty($token)) {
            // Simulación de validación de token (debe ajustarse según tu lógica real)
            if ($token === 'token_valido') {
                // Simulación de éxito al agregar la instalación
                $success_msg = "Instalación agregada correctamente.";

                // Simulación de inserción de instalación en la base de datos
                $fechaInstalacion = date('Y-m-d'); // Fecha de instalación actual

                // Generar un número aleatorio para instalacion_id (simulación)
                $instalacion_id = mt_rand(1001, 2000); // Ajusta el rango según tus necesidades

                // Obtener un token válido de la tabla Sondas (simulación)
                $sqlGetToken = "SELECT token FROM Sondas ORDER BY RAND() LIMIT 1"; // Obtener un token aleatorio
                $result = $conn->query($sqlGetToken);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $tokenSonda = $row['token'];

                    // Insertar la instalación en la tabla Instalaciones
                    $sqlInsertInstalacion = "INSERT INTO Instalaciones (instalacion_id, huerto_id, token, fecha_instalacion)
                                             VALUES ($instalacion_id, $huerto_id, '$tokenSonda', '$fechaInstalacion')";

                    if ($conn->query($sqlInsertInstalacion) === TRUE) {
                        // Generar las mediciones para cada tipo y cada día
                        $tiposMedicion = ['Temperatura', 'Humedad', 'Luminosidad', 'Ph', 'Salinidad'];
                        $numMedicionesPorTipo = 7;
                        $fechaInicio = '2024-05-01';
                        $fechaFin = '2024-05-07';

                        // Preparar la consulta SQL para inserción de mediciones
                        $sqlInsertMediciones = "INSERT INTO Mediciones (medicion_id, instalacion_id, fecha_medicion, tipo_medicion, valor)
                                                VALUES ";

                        // Obtener el máximo medicion_id actual en la tabla Mediciones
                        $sqlMaxMedicionId = "SELECT MAX(medicion_id) AS max_medicion_id FROM Mediciones";
                        $resultMaxMedicionId = $conn->query($sqlMaxMedicionId);

                        $maxMedicionId = 0;
                        if ($resultMaxMedicionId->num_rows > 0) {
                            $rowMaxMedicionId = $resultMaxMedicionId->fetch_assoc();
                            $maxMedicionId = $rowMaxMedicionId['max_medicion_id'];
                        }

                        // Incrementar el medicion_id para la nueva medición
                        $maxMedicionId++;

                        // Generar las mediciones para cada tipo y cada día
                        foreach ($tiposMedicion as $tipo) {
                            for ($i = 0; $i < $numMedicionesPorTipo; $i++) {
                                // Calcular la fecha de la medición (simulación de días aleatorios entre fechaInicio y fechaFin)
                                $fechaMedicion = date('Y-m-d', strtotime($fechaInicio . ' +' . $i . ' days'));

                                // Calcular un valor de medición aleatorio entre 0.1 y 100.0 (simulación)
                                $valor = mt_rand(1, 1000) / 10.0;

                                // Agregar los valores al SQL de inserción
                                $sqlInsertMediciones .= "($maxMedicionId, $instalacion_id, '$fechaMedicion', '$tipo', $valor),";

                                // Incrementar el contador de mediciones
                                $maxMedicionId++;
                            }
                        }

                        // Eliminar la última coma del SQL de inserción
                        $sqlInsertMediciones = rtrim($sqlInsertMediciones, ',');

                        // Ejecutar la consulta SQL $sqlInsertMediciones en tu base de datos
                        if ($conn->query($sqlInsertMediciones) === TRUE) {
                            // Si las mediciones se insertan correctamente, redireccionamos a instalaciones.php
                            header("Location: instalaciones.php?huerto_id=$huerto_id");
                            exit();
                        } else {
                            $error_msg = "Error al insertar mediciones: " . $conn->error;
                        }
                    } else {
                        $error_msg = "Error al agregar la instalación: " . $conn->error;
                    }
                } else {
                    $error_msg = "No se encontraron sondas disponibles.";
                }
            } else {
                $error_msg = "Error: Token no válido.";
            }
        } else {
            $error_msg = "Error: Debes proporcionar un token válido.";
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<div class="screen">
<div class="container-form">
    <div class="space"></div>
    <h2>Agregar Instalación</h2>
    <div class="space"></div>

    <?php if (!empty($success_msg)): ?>
        <p class="alert-success"><?php echo htmlspecialchars($success_msg); ?></p>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <p class="alert-danger"><?php echo htmlspecialchars($error_msg); ?></p>
    <?php endif; ?>

    <form action="agregarInstalacion.php?huerto_id=<?php echo $huerto_id; ?>" method="post">
        <div>
            <label for="token">Token:</label>
            <input type="text" id="token" name="token" required>
        </div>
        <div class="space"></div>
        <div class="register-action-group">
            <button type="submit" class="btn btn-wine">Agregar Instalación</button>
            <a href="instalaciones.php?huerto_id=<?php echo $huerto_id; ?>" class="button-link">Cancelar</a>
        </div>
    </form>

</div>
</div>
<?php include('includes/footer-cliente.php'); ?>
