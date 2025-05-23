<?php

include("includes/menu-cliente.php");


if (!isset($_GET['huerto_id']) || !is_numeric($_GET['huerto_id'])) {
    echo "Error: Huerto no válido.";
    exit;
}


$usuario_id = $_SESSION["usuario_id"];
$huerto_id = $_GET['huerto_id']; 
$sql_huerto = "SELECT nombre FROM Huertos WHERE huerto_id = ?";
$stmt_huerto = $conn->prepare($sql_huerto);
$stmt_huerto->bind_param("i", $huerto_id);
$stmt_huerto->execute();
$result_huerto = $stmt_huerto->get_result();

// Verificar si se encontró el huerto
if ($result_huerto->num_rows > 0) {
    $row_huerto = $result_huerto->fetch_assoc();
    $nombre_huerto = $row_huerto['nombre'];
} else {
    echo "Error: Huerto no encontrado.";
    exit;
}

// Consulta SQL para obtener todas las instalaciones del huerto del usuario
$sql = "SELECT i.instalacion_id, i.fecha_instalacion, h.nombre AS nombre_huerto, m.fecha_medicion, m.tipo_medicion, m.valor 
        FROM Instalaciones i
        INNER JOIN Huertos h ON i.huerto_id = h.huerto_id
        LEFT JOIN Mediciones m ON i.instalacion_id = m.instalacion_id
        INNER JOIN Usuarios_Huertos uh ON i.huerto_id = uh.huerto_id
        WHERE uh.usuario_id = ? AND i.huerto_id = ?";

// Preparar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $usuario_id, $huerto_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize an array to store the instalaciones
$instalaciones = [];


while ($row = $result->fetch_assoc()) {
  
    $found = false;
    foreach ($instalaciones as &$inst) {
        if ($inst['id'] == $row['instalacion_id']) {
            $found = true;

           
            if (!isset($inst['measurements'])) {
                $inst['measurements'] = [];
            }

          
            $measurementFound = false;
            foreach ($inst['measurements'] as &$measurement) {
                if ($measurement['date'] == date('Y-m-d', strtotime($row['fecha_medicion']))) {
                    $measurementFound = true;
                 
                    switch ($row['tipo_medicion']) {
                        case 'Humedad':
                            $measurement['humidity'] = floatval($row['valor']);
                            break;
                        case 'Luminosidad':
                            $measurement['luminosity'] = floatval($row['valor']);
                            break;
                        case 'Ph':
                            $measurement['ph'] = floatval($row['valor']);
                            break;
                        case 'Salinidad':
                            $measurement['salinity'] = floatval($row['valor']);
                            break;
                        case 'Temperatura':
                            $measurement['temperature'] = floatval($row['valor']);
                            break;
                        default:
                            break;
                    }
                    break;
                }
            }

        
            if (!$measurementFound) {
                $inst['measurements'][] = [
                    'date' => date('Y-m-d', strtotime($row['fecha_medicion'])),
                    'humidity' => ($row['tipo_medicion'] == 'Humedad') ? floatval($row['valor']) : null,
                    'luminosity' => ($row['tipo_medicion'] == 'Luminosidad') ? floatval($row['valor']) : null,
                    'ph' => ($row['tipo_medicion'] == 'Ph') ? floatval($row['valor']) : null,
                    'salinity' => ($row['tipo_medicion'] == 'Salinidad') ? floatval($row['valor']) : null,
                    'temperature' => ($row['tipo_medicion'] == 'Temperatura') ? floatval($row['valor']) : null
                ];
            }

            break;
        }
    }

    
    if (!$found) {
        $instalaciones[] = [
            'id' => $row['instalacion_id'],
            'name' => "Instalación " . $row['instalacion_id'],
            'measurements' => [
                [
                    'date' => date('Y-m-d', strtotime($row['fecha_medicion'])),
                    'humidity' => ($row['tipo_medicion'] == 'Humedad') ? floatval($row['valor']) : null,
                    'luminosity' => ($row['tipo_medicion'] == 'Luminosidad') ? floatval($row['valor']) : null,
                    'ph' => ($row['tipo_medicion'] == 'Ph') ? floatval($row['valor']) : null,
                    'salinity' => ($row['tipo_medicion'] == 'Salinidad') ? floatval($row['valor']) : null,
                    'temperature' => ($row['tipo_medicion'] == 'Temperatura') ? floatval($row['valor']) : null
                ]
            ]
        ];
    }
}

$stmt->close();
$conn->close();
?>

<?php

$success_msg = $_GET['success_msg'] ?? '';
$error_msg = $_GET['error_msg'] ?? '';

?>

<div class="instalaciones-page">


    

    

        <div class="">
        

        <div class="instalaciones-title">

            <h1><?php echo htmlspecialchars($nombre_huerto); ?></h1>
            <h4>Selecciona una de tus Instalaciones</h4>
        </div>

        <div class="instalaciones-container">

            <div class="instalacion_controls">
            
                
            <div class="s1">
                <label for="instalacion">Seleccionar Instalación:</label>
                <select id="instalacion">
                    <?php foreach ($instalaciones as $instalacion): ?>
                        <option value="<?php echo $instalacion['id']; ?>"><?php echo $instalacion['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="s1">
                <label for="filtro-medidas">Mostrar últimas:</label>
                <select id="filtro-medidas" onchange="filtrarMediciones()">
                    <option value="7">7 medidas</option>
                    <option value="5">5 medidas</option>
                    <option value="3">3 medidas</option>
                </select>
            </div>
            <script>
            
            function reorderOptions() {
                const select = document.getElementById('filtro-medidas');
                const options = Array.from(select.options);
                
                if (window.innerWidth < 700) { // aquí defines el ancho que quieras
                    // Reordenar para pantallas pequeñas
                    select.innerHTML = '';
                    select.add(new Option('3 medidas', '3'));
                    select.add(new Option('5 medidas', '5'));
                    select.add(new Option('7 medidas', '7'));
                } else {
                    // Orden original para pantallas grandes
                    select.innerHTML = '';
                    select.add(new Option('7 medidas', '7'));
                    select.add(new Option('5 medidas', '5'));
                    select.add(new Option('3 medidas', '3'));
                }


                filtrarMediciones();
                
                }

            // Ejecutar al cargar la página
            window.addEventListener('load', reorderOptions);

            // Ejecutar cuando redimensionan la ventana
            window.addEventListener('resize', reorderOptions);

            </script>

            <div class="s1">
                <a href="agregarInstalacion.php?huerto_id=<?php echo $huerto_id; ?>" class="edit-link2">Agregar Instalación</a>
                
            </div>
            <div class="s1">
                <a href="eliminarInstalacion.php?huerto_id=<?php echo $huerto_id; ?>" class="edit-link2">Quitar Instalación</a>
            </div>

        </div>

        <div class="chart-buttons">
            <button id="btn-humedad" class="toggle-btn on" onclick="toggleDataset(0)">Humedad<i class="bi bi-droplet"></i>
            </button>
            <button id="btn-luminosidad" class="toggle-btn on" onclick="toggleDataset(1)">Luminosidad <i class="bi bi-brightness-high"></i>
            </button>
            <button id="btn-ph" class="toggle-btn on" onclick="toggleDataset(2)">Ph <i class="bi bi-droplet-half"></i>

            </button>
            <button id="btn-Salinidad" class="toggle-btn on" onclick="toggleDataset(3)">Salinidad<i class="bi bi-moisture"></i>
            </button>
            <button id="btn-Temperatura" class="toggle-btn on" onclick="toggleDataset(4)">Temperatura <i class="bi bi-thermometer-half"></i></button>
            <button id="btn-all" class="toggle-btn on" onclick="selectAll()">Todos<i class="bi bi-check-all"></i>
            </button>
            <button id="btn-none" class="toggle-btn on" onclick="selectNone()">Ninguno<i class="bi bi-x"></i>
            </button>
        </div>

        <div class="chart-container">
            <div class="chart">
                <?php if (empty($instalaciones)): ?>
                    <h3>No tiene instalaciones disponibles</h3>
                    <canvas id="chart" style="display: none !important;"></canvas>
                <?php else: ?>
                    <canvas id="chart"></canvas>
                <?php endif; ?>
            </div>
        </div>
        
        </div>
       

  
    </div>
</div>
<script src="js/datos.js"></script>

<script>
    // Convert PHP variable $instalaciones to JSON format and output it as JavaScript variable
    const instalaciones = <?php echo json_encode($instalaciones, JSON_NUMERIC_CHECK); ?>;
    console.log(instalaciones); // Log the variable to console for inspection
</script>

<script src="js/ProcesandoDatos.js"></script>

<script src="js/chart-functionalities.js"></script>

<?php include('includes/footer-cliente.php'); ?>
