<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "", "cursox");
$conexion->set_charset("utf8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maestro_id = isset($_POST['maestro_id']) ? intval($_POST['maestro_id']) : 0;
    $texto_reseña = isset($_POST['texto']) ? $conexion->real_escape_string(trim($_POST['texto'])) : '';
    
    if ($maestro_id > 0 && !empty($texto_reseña)) {
        $conexion->query("INSERT INTO reseñas (maestro_id, texto) VALUES ($maestro_id, '$texto_reseña')");
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $maestro_id = isset($_GET['maestro_id']) ? intval($_GET['maestro_id']) : 0;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 2;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    if ($maestro_id > 0) {
        $resultado = $conexion->query("SELECT texto FROM reseñas WHERE maestro_id = $maestro_id ORDER BY id DESC LIMIT " . $limit . " OFFSET " . $offset);
        $reseñas = [];
        while ($fila = $resultado->fetch_assoc()) { $reseñas[] = $fila['texto']; }
        echo json_encode($reseñas);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>
