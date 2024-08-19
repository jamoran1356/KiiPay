<?php

require_once 'connect.php';

class Login {
    private $correo;
    private $clave;
    private $tabla = "persona_profile";
    private $conexion;
    

    function __construct() {
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    function grabar_acceso($idpersona){
        $ip = $_SERVER['REMOTE_ADDR'];
        $dispositivo = $_SERVER['HTTP_USER_AGENT'];
        $fecha = date('Y-m-d H:i:s');
        $sessionId = session_id();

        // Cierra las sesiones activas si la IP no coincide
        $sql = "UPDATE control_acceso SET estado = 'cerrada' WHERE idusuario = ? AND ip != ? AND estado = 'activa'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idpersona, $ip]);

        // Almacena la nueva sesión
        $sql = "INSERT INTO control_acceso (idusuario, ip, dispositivo, fecha_acceso, session_id, estado) VALUES (?, ?, ?, ?, ?, 'activa')";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idpersona, $ip, $dispositivo, $fecha, $sessionId]);

        return $this->conexion->lastInsertId();
    }

    function verificar_acceso($idpersona){
        $sql = "SELECT * FROM control_acceso WHERE idusuario = ? AND estado = 'activa'";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idpersona]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        return $session;
    }

    function actualizar_acceso($idcliente, $session_id){
        $sql = "UPDATE control_acceso SET fecha_acceso = ? WHERE idusuario = ? AND session_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([date('Y-m-d H:i:s'), $idcliente, $session_id]);
    }

    function crear_session_admin($correo, $idpersona, $username, $tipo){
        $_SESSION['em158325'] = $correo;
        $_SESSION['id999822'] = $idpersona;
        $_SESSION['nm167852'] = $username;
        $_SESSION['r9l'] = $tipo;
        $_SESSION['7pcli78nt8'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    
    public function login($correo, $clave) {
        $this->correo = $correo;
        $this->clave = $clave;
        //Verificar si el usuario existe
        $sql = "SELECT idpersona, nombre, apellido, email, clave, tipo FROM persona_profile WHERE email = ? ORDER BY idpersona DESC LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$this->correo]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data !== false) {
            $dbclave = $data['clave'];
            if(!empty($dbclave)){
                if(password_verify($this->clave, $dbclave)){
                    $nombre = isset($data['nombre']) ? $data['nombre'] : "";
                    $apellido = isset($data['apellido']) ? $data['apellido'] : "";
                    $username = $nombre .' ' . $apellido;
                    self::crear_session_admin($this->correo, $data['idpersona'], $username, $data['tipo']);
                    self::grabar_acceso($data['idpersona']); // Llama a grabar_acceso aquí
                    return 1;
                } else {
                    return 0; // contraseña incorrecta
                }
            } else {
                return 3; //usuario no existe
            }
        } else {
            return 3; //usuario no existe
        }
    }


}




?>