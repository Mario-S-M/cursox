<?php
require_once 'conexion.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = trim($_POST['id_usuario']);
    $nombre     = mb_strtolower(trim($_POST['nombre'], 'UTF-8'));
    $telefono   = trim($_POST['telefono']);
    $id_existe = true;
    while ($id_existe) {
        $consulta_check = $conexionServidor->prepare("SELECT ID FROM maestros WHERE ID = ?");
        $consulta_check->bind_param("s", $id_usuario);
        $consulta_check->execute();
        $consulta_check->store_result();
       if ($consulta_check->num_rows > 0) {
            $id_usuario = (string)random_int(1000000000, 9999999999);
            $consulta_check->close(); 
        } else {
            $id_existe = false;
            $consulta_check->close();
        }
    }
    $sql = "INSERT INTO maestros (ID, Nombre, Tel) VALUES (?, ?, ?)";
    $stmt = $conexionServidor->prepare($sql);
    $stmt->bind_param("sss", $id_usuario, $nombre, $telefono);
    if ($stmt->execute()) {
        echo "<script>
                alert('¡Perfil registrado con éxito! Tu ID final asignada es: " . $id_usuario . "');
                window.location.href = 'Cursox.html';
              </script>";
    } else {
        echo "Error al guardar en la base de datos: " . $stmt->error;
    }
    $stmt->close();
}
$conexionServidor->close();
?>
