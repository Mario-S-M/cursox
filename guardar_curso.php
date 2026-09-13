<?php
require_once 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = trim($_POST['id_usuario']);
    $nombre_curso = mb_strtolower(trim($_POST['curso'], 'UTF-8'));
    $modalidad = mb_strtolower(trim($_POST['mo'], 'UTF-8'));
    $costo = trim($_POST['cc']);
    $consulta_maestro = $conexionServidor->prepare("SELECT ID, Curso FROM maestros WHERE ID = ?");
    $consulta_maestro->bind_param("s", $id_usuario);
    $consulta_maestro->execute();
    $consulta_maestro->store_result();
    if ($consulta_maestro->num_rows == 0) {
        $consulta_maestro->close();
        echo "<script>
                alert('❌ Error: La ID ingresada no existe en el sistema. Por favor, crea tu perfil primero.');
                window.history.back();
              </script>";
        exit();
    }
    $consulta_maestro->bind_result($id_db, $curso_actual);
    $consulta_maestro->fetch();
    $consulta_maestro->close();
    if (!empty($curso_actual)) {
        echo "<script>
                alert('🚫 Acción denegada: Tu perfil ya cuenta con un curso registrado y no se permite modificarlo desde aquí.');
                window.location.href = 'Cursox.html';
              </script>";
        exit();
    }
    $foto_nombre = $_FILES['ftc']['name'];
    $foto_tmp = $_FILES['ftc']['tmp_name'];
    $carpeta_destino = 'uploads/';
    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0777, true);
    }
    $foto_extension = pathinfo($foto_nombre, PATHINFO_EXTENSION);
    $nuevo_nombre_foto = time() . "_curso_" . $id_usuario . "." . $foto_extension;
    $ruta_final_foto = $carpeta_destino . $nuevo_nombre_foto;
    if (move_uploaded_file($foto_tmp, $ruta_final_foto)) {
        $sql = "UPDATE maestros SET Curso = ?, Tcurso = ?, Costo = ?, Foto = ? WHERE ID = ?";
        $stmt = $conexionServidor->prepare($sql);
        $stmt->bind_param("sssss", $nombre_curso, $modalidad, $costo, $ruta_final_foto, $id_usuario);
        if ($stmt->execute()) {
            echo "<script>
                    alert('¡Tu curso ha sido correctamente creado y guardado!');
                    window.location.href = 'Cursox.html';
                  </script>";
        } else {
            echo "Error al guardar el curso en la base de datos: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al subir la imagen de presentación al servidor físico.";
    }
}
$conexionServidor->close();
?>