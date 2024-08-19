<?php
require_once 'connect.php';

class Departamento {
    private $conexion;
    private $tbdpto = "departamento";
    
    public function __construct(){
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    public function savedepto($idpersona, $nombre, $descripcion){
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO departamento (creado_por, titulo, descripcion, fecha_creado) VALUES (?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $nombre, $descripcion, $fecha]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    public function upddepto($idpersona, $nombre, $descripcion, $id){
        $sql = "UPDATE departamento SET titulo = ?, descripcion = ? WHERE creado_por = ? AND iddepartamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $descripcion, $idpersona, $id]);
        $data = $smts->rowCount();
        return $data;
    }

    public function getdptos_paginado($inicio, $registros, $orden){
        $sql = "SELECT iddepartamento, titulo
        FROM departamento
        ORDER BY titulo $orden 
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['total_empleados'] = self::contar_empleados_dpto($value['iddepartamento']);
        }
        return $data;
    }

    public function getManagerDpto($iddepartamento){
        $sql = "SELECT dm.idpersona, p.nombre, p.apellido, p.imagen FROM departamento_manager dm
        INNER JOIN persona_profile p ON dm.idpersona = p.idpersona
        WHERE dm.departamento_id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$iddepartamento]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function check_Manager_Dpto($idempleado){
        $sql = "SELECT COUNT(*) AS total FROM departamento_manager WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->fetchColumn();
        return $data;
    }

    public function contar_dptos(){
        $sql = "SELECT COUNT(*) AS total FROM $this->tbdpto";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchColumn();
        return $data;
    }

    public function get_dptos(){
        $sql = "SELECT iddepartamento, titulo FROM $this->tbdpto ORDER BY titulo ASC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchAll();
        return $data;
    }

    public function get_dptos_by_id($id){
        $sql = "SELECT iddepartamento, titulo, descripcion FROM $this->tbdpto WHERE iddepartamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll();
        return $data;
    }

    function del_depto($idpersona, $id){
        if($id == 15 || $id == 16 || $id == 19){
            return 'E1'; //Departamentos no se pueden eliminar
        } else {
            $sql = "DELETE FROM $this->tbdpto WHERE iddepartamento = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$id]);
            $data = $smts->rowCount();
            if($data>0){
                self::grabar_log($idpersona, 'Ha eliminado el departamento # '.$id, 'eliminación');
                return 1;
            } else {
                return 0;
            }
        }
        
    }

    public function get_dptos_select($idpersona){
        $sql = "SELECT iddepartamento as id, titulo as nombre FROM $this->tbdpto WHERE creado_por = ? ORDER BY titulo ASC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona]);
        $data = $smts->fetchAll();
        return $data;
    }

    function grabar_log($idpersona, $accion, $tipo){
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO persona_log (idpersona, accion, tipo, fecha_incidencia) VALUES (?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $accion, $tipo, $fecha]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    public function contar_empleados_dpto($iddepartamento){
        $sql = "SELECT COUNT(*) AS total FROM persona_laboral WHERE $this->tbdpto = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$iddepartamento]);
        $data = $smts->fetchColumn();
        return $data;
    }

}
?>
