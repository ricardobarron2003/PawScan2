<?php
include_once 'Conexion.php';

class RepositorioMascota {
    // Función para registrar una mascota
    public static function registrar_mascota($conexion, $id_usuario, $nombre_mascota, $foto_mascota, $edad_mascota, $vacunas_mascota, $caracteristicas_mascota) {
        $mascota_registrada = false;

        if (isset($conexion)) {
            try {
                $sql = 'INSERT INTO mascotas(id_usuario, nombre_mascota, foto_mascota, edad_mascota, vacunas_mascota, caracteristicas_mascota) VALUES(:id_usuario, :nombre_mascota, :foto_mascota, :edad_mascota, :vacunas_mascota, :caracteristicas_mascota)';

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $sentencia->bindParam(':nombre_mascota', $nombre_mascota, PDO::PARAM_STR);
                $sentencia->bindParam(':foto_mascota', $foto_mascota, PDO::PARAM_STR);
                $sentencia->bindParam(':edad_mascota', $edad_mascota, PDO::PARAM_INT);
                $sentencia->bindParam(':vacunas_mascota', $vacunas_mascota, PDO::PARAM_STR);
                $sentencia->bindParam(':caracteristicas_mascota', $caracteristicas_mascota, PDO::PARAM_STR);

                $mascota_registrada = $sentencia->execute();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }

        return $mascota_registrada;
    }

    // Función para obtener las mascotas por usuario
    public static function obtener_mascotas_por_usuario($conexion, $id_usuario) {
        $mascotas = [];

        if (isset($conexion)) {
            try {
                $sql = 'SELECT * FROM mascotas WHERE id_usuario = :id_usuario';

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $sentencia->execute();

                $resultado = $sentencia->fetchAll();

                if (!empty($resultado)) {
                    foreach ($resultado as $fila) {
                        $mascotas[] = [
                            'id_mascota' => $fila['id_mascota'],
                            'nombre_mascota' => $fila['nombre_mascota'],
                            'foto_mascota' => $fila['foto_mascota'],
                            'edad_mascota' => $fila['edad_mascota'],
                            'vacunas_mascota' => $fila['vacunas_mascota'],
                            'caracteristicas_mascota' => $fila['caracteristicas_mascota'],
                        ];
                    }
                }
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }

        return $mascotas;
    }

    // Función para eliminar todas las mascotas de un usuario
    public static function eliminar_mascotas_por_usuario($conexion, $id_usuario) {
        if (isset($conexion)) {
            try {
                $sql = 'DELETE FROM mascotas WHERE id_usuario = :id_usuario';

                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

                $sentencia->execute();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
    }
    
    public static function obtener_mascota_por_id($conexion, $id_mascota) {
        $mascota = null;
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM mascotas WHERE id_mascota = :id_mascota";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                if (!empty($resultado)) {
                    $mascota = $resultado;
                }
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $mascota;
    }
    
    public static function actualizar_mascota($conexion, $id_mascota, $nombre_mascota, $ruta_imagen, $edad_mascota, $vacunas_mascota, $caracteristicas_mascota) {
        if (isset($conexion)) {
            try {
                $sql = "UPDATE mascotas SET nombre_mascota = :nombre_mascota, foto_mascota = :foto_mascota, edad_mascota = :edad_mascota, vacunas_mascota = :vacunas_mascota, caracteristicas_mascota = :caracteristicas_mascota WHERE id_mascota = :id_mascota";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
                $sentencia->bindParam(':nombre_mascota', $nombre_mascota, PDO::PARAM_STR);
                $sentencia->bindParam(':foto_mascota', $ruta_imagen, PDO::PARAM_STR);
                $sentencia->bindParam(':edad_mascota', $edad_mascota, PDO::PARAM_INT);
                $sentencia->bindParam(':vacunas_mascota', $vacunas_mascota, PDO::PARAM_STR);
                $sentencia->bindParam(':caracteristicas_mascota', $caracteristicas_mascota, PDO::PARAM_STR);
                $sentencia->execute();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
    }
    
    public static function eliminar_mascota($conexion, $id_mascota) {
    if (isset($conexion)) {
        try {
            $sql = "DELETE FROM mascotas WHERE id_mascota = :id_mascota";
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
            $sentencia->execute();
        } catch (PDOException $ex) {
            print 'ERROR: ' . $ex->getMessage();
        }
    }
}

}
?>
