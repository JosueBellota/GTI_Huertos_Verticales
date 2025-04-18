<table class="perfil-table">
    <thead>
        <tr>
            <th>Nombre del Huerto</th>
            <th>Ubicación</th>
        </tr>
    </thead>
    <tbody>
        <?php
        
        $sql_huertos = "SELECT H.nombre, H.ubicacion FROM Huertos H
                        INNER JOIN Usuarios_Huertos UH ON H.huerto_id = UH.huerto_id
                        WHERE UH.usuario_id = ?";
        
        if ($stmt_huertos = $conn->prepare($sql_huertos)) {
            $stmt_huertos->bind_param("i", $usuario_id);
            
            if ($stmt_huertos->execute()) {
                $result_huertos = $stmt_huertos->get_result();
                
                if ($result_huertos->num_rows > 0) {
                    while ($huerto = $result_huertos->fetch_assoc()) {
                        echo "<tr><td>" . htmlspecialchars($huerto['nombre']) . "</td><td>" . htmlspecialchars($huerto['ubicacion']) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No se encontraron huertos.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Error: No se pudo ejecutar la consulta.</td></tr>";
            }
            
            $stmt_huertos->close();
        } else {
            echo "<tr><td colspan='2'>Error: No se pudo preparar la consulta.</td></tr>";
        }

        ?>
    </tbody>
</table>