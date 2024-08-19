<?php
require_once 'connect.php';

class Captcha {
    private $conexion;
    private $tbl = "google_captcha";
    
    public function __construct(){
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    public function setCaptcha($publica, $privada, $activo){
        $sql = "INSERT INTO $this->tbl (clave_publica, clave_privada, activo) VALUES (?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$publica, $privada, $activo]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    public function getCaptcha(){
        $sql = "SELECT * FROM $this->tbl WHERE id = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getPrivateKey(){
        $sql = "SELECT clave_privada FROM $this->tbl WHERE activo = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchColumn();
        return $data;
    }

    public function getPublicKey(){
        $sql = "SELECT clave_publica FROM $this->tbl WHERE activo = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchColumn();
        return $data;
    }

    public function updCaptcha($publica, $privada, $activo){
        $sql = "UPDATE $this->tbl SET clave_publica = ?, clave_privada = ?, activo = ? WHERE id = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$publica, $privada, $activo]);
        $data = $smts->rowCount();
        return $data;
    }

    public function updCaptchaActivo($activo){
        $sql = "UPDATE $this->tbl SET activo = ? WHERE id = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$activo]);
        $data = $smts->rowCount();
        return $data;
    }

    public function gc_isActive(){
        $sql = "SELECT activo FROM $this->tbl WHERE id = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchColumn();
        return $data;
    }

    
}
?>
