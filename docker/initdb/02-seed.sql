-- Datos de prueba. Las fotos apuntan a archivos que ya existen en el proyecto.
SET NAMES utf8mb4;
USE cursox;

INSERT INTO maestros (ID, Nombre, Tel, Curso, Tcurso, Costo, Foto) VALUES
  ('2134061617', 'emmanuel soto tovar',  '5512345678', 'programación en php',      'online',     '180', 'uploads/1789098521_curso_2134061617.jpg'),
  ('7515559061', 'angel cuevas gonzales','5523456789', 'bases de datos con mysql', 'presencial', '220', 'uploads/1789097238_curso_7515559061.jpg'),
  ('3632077762', 'laura méndez ríos',    '5534567890', 'diseño web con css',       'online',     '150', 'uploads/1789097858_curso_3632077762.jpg'),
  ('8336201294', 'ricardo pérez lara',   '5545678901', 'matemáticas para bachillerato', 'presencial', '200', 'uploads/1789172223_curso_8336201294.jpeg'),
  ('2460725609', 'sofía navarro gil',    '5556789012', 'inglés conversacional',    'online',     '170', 'uploads/1789178843_curso_2460725609.jpeg'),
  ('1122334455', 'daniel ortega vargas', '5567890123', 'guitarra desde cero',      'presencial', '190', 'auron.jpeg'),
  ('6677889900', 'mariana lópez cruz',   '5578901234', 'repostería básica',        'presencial', '240', 'misa.jpeg'),
  ('9090909090', 'german ruiz salas',    '5589012345', 'edición de video',         'online',     '260', 'german.jpeg')
ON DUPLICATE KEY UPDATE ID = ID;

-- Un maestro registrado sólo con perfil (aún sin curso), como lo deja guardar_perfil.php.
INSERT INTO maestros (ID, Nombre, Tel) VALUES
  ('5555555555', 'perfil sin curso', '5590123456')
ON DUPLICATE KEY UPDATE ID = ID;

INSERT INTO reseñas (maestro_id, texto) VALUES
  (2134061617, 'Explica muy claro, aprendí PHP en pocas semanas.'),
  (2134061617, 'Buen maestro, aunque las clases se pasan volando.'),
  (2134061617, 'Muy paciente con los principiantes. Recomendado.'),
  (7515559061, 'Las prácticas de MySQL están muy bien armadas.'),
  (7515559061, 'Domina el tema y resuelve todas las dudas.'),
  (3632077762, 'Aprendí a maquetar sin frameworks, excelente.'),
  (8336201294, 'Me ayudó a pasar el examen de admisión.'),
  (2460725609, 'Clases dinámicas, se practica hablar desde el día uno.');
