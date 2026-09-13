<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once 'conexion.php';
if (!isset($_GET['id']) || empty(trim($_GET['id']))) {
    echo json_encode(["status" => "error", "message" => "❌ No se escribió ninguna ID."]);
    exit();
}
$id_usuario = trim($_GET['id']);
if (!isset($conexionServidor) && isset($conexion)) {
    $conexionServidor = $conexion;
}
if (!isset($conexionServidor)) {
    echo json_encode(["status" => "error", "message" => "❌ Error: No se encontró la variable de conexión (\$conexionServidor)."]);
    exit();
}
$sql = "SELECT Nombre, Tel, Curso, Tcurso, Costo, Foto FROM maestros WHERE ID = ?";
$stmt = $conexionServidor->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $id_usuario);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($r_nombre, $r_telefono, $r_curso, $r_tcurso, $r_costo, $r_foto);
        $stmt->fetch();
        echo json_encode([
            "status" => "success",
            "nombre" => $r_nombre,
            "telefono" => $r_telefono,
            "curso" => $r_curso,
            "tcurso" => $r_tcurso,
            "costo" => $r_costo,
            "foto" => $r_foto
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "❌ No se encontró a nadie con la ID: " . $id_usuario]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "❌ Error en la consulta SQL: " . $conexionServidor->error]);
}
$conexionServidor->close();
?>