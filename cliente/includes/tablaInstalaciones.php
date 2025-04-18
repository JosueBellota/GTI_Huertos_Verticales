<table class="perfil-table">
    <thead>
        <tr>
            <th>Instalación</th>
            <th>ID</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_instalaciones = "SELECT I.instalacion_id, CONCAT('Instalación ', I.instalacion_id) AS nombre_instalacion
                                FROM Instalaciones I
                                INNER JOIN Huertos H ON I.huerto_id = H.huerto_id
                                INNER JOIN Sondas S ON I.token = S.token
                                WHERE H.huerto_id IN (SELECT huerto_id FROM Usuarios_Huertos WHERE usuario_id = ?)";
        
        if ($stmt_instalaciones = $conn->prepare($sql_instalaciones)) {
            $stmt_instalaciones->bind_param("i", $usuario_id);
            
            if ($stmt_instalaciones->execute()) {
                $result_instalaciones = $stmt_instalaciones->get_result();
                
                if ($result_instalaciones->num_rows > 0) {
                    while ($instalacion = $result_instalaciones->fetch_assoc()) {
                        echo "<tr><td>" . htmlspecialchars($instalacion['nombre_instalacion']) . "</td><td>" . htmlspecialchars($instalacion['instalacion_id']) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No se encontraron instalaciones.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Error: No se pudo ejecutar la consulta.</td></tr>";
            }
            
            $stmt_instalaciones->close();
        } else {
            echo "<tr><td colspan='2'>Error: No se pudo preparar la consulta.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>
