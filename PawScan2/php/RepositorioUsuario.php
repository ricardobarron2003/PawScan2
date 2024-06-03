<?php
class RepositorioUsuario {
    public static function obtener_numero_usuarios($conexion) {
        $total_usuarios = 0;

        if (isset($conexion)) {
            try {
                $sql = "SELECT COUNT(*) as total FROM usuarios";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                    $total_usuarios = $resultado['total'];
                }
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }

        return $total_usuarios;
    }
    public static function obtener_usuario_por_email($conexion, $email) {
        $usuario = null;

        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM usuarios WHERE email_usuario = :email LIMIT 1";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia->execute();
                
                $resultado = $sentencia->fetch();
                
                if (!empty($resultado)) {
                    $usuario = $resultado;
                }
            } catch (PDOException $ex) {
                print 'ERROR ' . $ex->getMessage();
            }
        }

        return $usuario;
    }
    
    public static function obtener_usuario_por_id($conexion, $id_usuario) {
        $usuario = null;
        if (isset($conexion)) {
            try {
                $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $sentencia->execute();
                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
                if (!empty($resultado)) {
                    $usuario = $resultado;
                }
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $usuario;
    }
    
    public static function actualizar_usuario($conexion, $usuario_id, $nombre, $email, $password, $telefono, $direccion) {
    try {
        // Verificar si el usuario existe antes de intentar actualizar
        $usuario_actual = self::obtener_usuario_por_id($conexion, $usuario_id);

        if ($usuario_actual) {
            // Actualizar los datos del usuario
            $sql = "UPDATE usuarios SET nombre_usuario = :nombre, email_usuario = :email, password = :password, telefono_usuario = :telefono, direccion_usuario = :direccion WHERE id_usuario = :usuario_id";
            $stmt = $conexion->prepare($sql);
            
            // Enlazar los parámetros
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

            // Ejecutar la consulta y retornar el resultado
            $resultado = $stmt->execute();
            return $resultado;
        } else {
            print 'ERROR: No se encontró el usuario.';
            return false;
        }
    } catch (PDOException $ex) {
        print 'ERROR: ' . $ex->getMessage();
        return false;
    }
}


}
?>
