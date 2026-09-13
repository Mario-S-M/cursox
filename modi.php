<?php 
require_once 'conexion.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id_usuario = trim($_POST['id_usuario']); 
    $nombre = trim($_POST['nom']); 
    $telefono = trim($_POST['tel']); 
    $nombre_curso = mb_strtolower(trim($_POST['curso']), 'UTF-8'); 
    $modalidad = mb_strtolower(trim($_POST['mo']), 'UTF-8'); 
    $costo = trim($_POST['costo']); 
    if (empty($id_usuario)) { 
        echo "<script> alert('❌ Error: No se recibió la ID del usuario.'); window.history.back(); </script>"; 
        exit(); 
    } 
    $stmt = null; 
    if (!empty($_FILES['ftc']['name'])) { 
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
            $sql = "UPDATE maestros SET Nombre = ?, Tel = ?, Curso = ?, Tcurso = ?, Costo = ?, Foto = ? WHERE ID = ?"; 
            $stmt = $conexionServidor->prepare($sql); 
            $stmt->bind_param("sssssss", $nombre, $telefono, $nombre_curso, $modalidad, $costo, $ruta_final_foto, $id_usuario); 
        } else { 
            echo "Error al subir la nueva imagen de presentación al servidor físico."; 
            exit(); 
        } 
    } else { 
        $sql = "UPDATE maestros SET Nombre = ?, Tel = ?, Curso = ?, Tcurso = ?, Costo = ? WHERE ID = ?"; 
        $stmt = $conexionServidor->prepare($sql); 
        $stmt->bind_param("ssssss", $nombre, $telefono, $nombre_curso, $modalidad, $costo, $id_usuario); 
    } 
    if ($stmt && $stmt->execute()) { 
        echo "<script> alert('¡Tus cambios han sido guardados correctamente!'); window.location.href = 'Cursox.html'; </script>"; 
    } else { 
        echo "Error al actualizar los datos en la base de datos: " . ($stmt ? $stmt->error : $conexionServidor->error); 
    } 
    if ($stmt) {
        $stmt->close(); 
    }
} 
$conexionServidor->close(); 
?>