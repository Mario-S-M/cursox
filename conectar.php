<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "", "cursox");
if ($conexion->connect_error) { 
    echo json_encode(["status" => "error"]);
    exit;
}
$conexion->set_charset("utf8");
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 2;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$sql = "SELECT * FROM maestros 
        WHERE Nombre IS NOT NULL AND Nombre != '' 
          AND Curso IS NOT NULL AND Curso != '' 
          AND Tcurso IS NOT NULL AND Tcurso != '' 
          AND Costo IS NOT NULL AND Costo > 0 
          AND Tel IS NOT NULL AND Tel != '' 
          AND Foto IS NOT NULL AND Foto != '' 
        ORDER BY Nombre ASC LIMIT " . $limit . " OFFSET " . $offset;
$resultado = $conexion->query($sql);
$maestrosValidos = [];
while ($fila = $resultado->fetch_assoc()) {
    $maestrosValidos[] = $fila;
}
if (count($maestrosValidos) > 0) {
    echo json_encode(["status" => "success", "data" => $maestrosValidos]);
} else {
    echo json_encode(["status" => "success", "data" => []]);
}
$conexion->close();
?>