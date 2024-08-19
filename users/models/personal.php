<?php 

require_once 'connect.php';

class Empleado {
    private $tbhist = "persona_laboral";
    private $tbmenu = "persona_menu";
    private $tb = "persona_profile";
    private $tbaddress = "persona_address";
    private $tbmanager = "departamento_manager";
    private $conexion;
    
    public function __construct(){
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    public function __save($nombre, $apellido, $identificacion, $telefono, $email, $nacimiento, $password, $imagen, $has_access, $tipo){
        $fecha = date('Y-m-d');
        $clave = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->tb (nombre, apellido, identificacion, telefono, email, fecha_nacimiento, clave, imagen, has_access, tipo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $apellido, $identificacion, $telefono, $email, $nacimiento, $clave, $imagen, $has_access, $tipo]);
        $data = $this->conexion->LastInsertId();
        return $data;
    }

    public function __savedireccion($idpersona, $direccion, $ciudad){
        $sql = "INSERT INTO $this->tbaddress (idpersona, address_line1, city) VALUES (?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $direccion, $ciudad]);
        $data = $smts->rowCount();
        return $data;
    }

    public function upd_direccion($idpersona, $direccion, $ciudad){
        $sql = "UPDATE $this->tbaddress SET address_line1 = ?, city = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$direccion, $ciudad, $idpersona]);
        $data = $smts->rowCount();
        return $data;
    }

    public function verificar_imagen($imagen, $id){
        $sql = "SELECT imagen FROM $this->tb WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchColumn();
        if($data !== 'no-image.webp' && $data !== $imagen){
            if(unlink('../assest/images/personal/'.$data)){
                return 1;
            } else {
                return 2;
            }
        } else {
            return 0;
        }
    } 

    public function __update($id, $nombre, $apellido, $identificacion, $sexo, $telefono, $email, $nacimiento, $imagen, $has_access, $tipo){
            $sql = "UPDATE $this->tb SET nombre = ?, apellido = ?, identificacion = ?, sexo = ?, telefono = ?, email = ?, fecha_nacimiento = ?, imagen = ?, has_access = ?, tipo = ? WHERE idpersona = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$nombre, $apellido, $identificacion, $sexo, $telefono, $email, $nacimiento, $imagen, $has_access, $tipo, $id]);
            $data = $smts->rowCount();
            return $data;
    }

    public function __delete($id){
        $sql = "DELETE FROM $this->tb WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->rowCount();
        return $data;
    }
    public function __get($id){
        $sql = "SELECT idpersona, nombre, apellido, telefono, email, fecha_nacimiento, clave, has_access, tipo FROM $this->tb WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function __getall(){
        $sql = "SELECT idpersona, nombre, apellido, telefono, email, fecha_nacimiento, clave, has_access, tipo FROM $this->tb";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function contar_personas(){
        $sql = "SELECT COUNT(*) AS total FROM $this->tb";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchColumn();
        return $data['total'];
    }

    function save_historial_laboral($idpersona, $ingreso, $cargo, $ismanager, $iddepartamento){
        $sql = "INSERT INTO $this->tbhist (idpersona, fecha_ingreso, cargo, is_manager, departamento) VALUES (?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $ingreso, $cargo, $ismanager, $iddepartamento]);
        $data = $smts->rowCount();
        return $data;
    }

    function upd_historial_laboral($idpersona, $ingreso, $cargo, $ismanager, $iddepartamento){
        $sql = "UPDATE $this->tbhist SET fecha_ingreso = ?, cargo = ?, is_manager = ?, departamento = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$ingreso, $cargo, $ismanager, $iddepartamento, $idpersona]);
        $data = $smts->rowCount();
        return $data;
    }

    function save_persona_menu($idpersona, $menu, $acceso){
        $sql = "INSERT INTO $this->tbmenu (idpersona, menu, acceso) VALUES (?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $menu, $acceso]);
        $data = $smts->rowCount();
        return $data;
    }

    function upd_persona_menu($idpersona, $menu, $acceso){
        $sql = "UPDATE $this->tbmenu SET menu = ?, acceso = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$menu, $acceso, $idpersona]);
        $data = $smts->rowCount();
        return $data;
    }

    function check_acceso_menu($idpersona, $menu){
        $sql = "SELECT acceso FROM $this->tbmenu WHERE idpersona = ? AND menu = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $menu]);
        $data = $smts->fetchColumn();
        if(!empty($data)){
            return $data;
        } else {
            return 0;
        }
        
    }

    function setManagerDpto($idpersona, $iddepartamento){
        $sql = "INSERT INTO $this->tbmanager (idpersona, departamento_id) VALUES (?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona, $iddepartamento]);
        $data = $smts->rowCount();
        return $data;
    }

    function upd_ManagerDpto($idpersona, $iddepartamento){
        $sql = "SELECT * FROM $this->tbmanager WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona]);
        $data = $smts->fetchColumn();
        if($data > 0){
            $sql = "UPDATE $this->tbmanager SET departamento_id = ? WHERE idpersona = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$iddepartamento, $idpersona]);
            $data = $smts->rowCount();
            return $data;
        } else {
            $sql = "INSERT INTO $this->tbmanager (idpersona, departamento_id) VALUES (?,?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idpersona, $iddepartamento]);
            $data = $smts->rowCount();
            return $data;
        }
    }

    public function setEmpleado($nombre, $apellido, $identificacion, $telefono, $email, $nacimiento, $password, $imagen, $has_access, $tipo, $direccion, $ciudad, $ingreso, $cargo, $ismanager, $iddepartamento){
        $idpersona = $this->__save($nombre, $apellido, $identificacion, $telefono, $email, $nacimiento, $password, $imagen, $has_access, $tipo);
        if($idpersona > 0){
            if($ismanager){
                $idmanager = $this->setManagerDpto($idpersona, $iddepartamento);
            }
            $iad = $this->__savedireccion($idpersona, $direccion, $ciudad);
            $idhist = $this->save_historial_laboral($idpersona, $ingreso, $cargo, $ismanager, $iddepartamento);
        return $idpersona;
        } else {
            return 0;
        }
    }

    public function contar_empleados(){
        $sql = "SELECT COUNT(*) AS total FROM persona_laboral";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchColumn();
        return $data;
    }

    public function getempleados_paginado($inicio, $registros, $orden){
        $sql = "SELECT pl.idpersona, pl.fecha_ingreso, pl.cargo, pl.departamento, p.nombre, p.apellido, p.email, p.telefono, p.tipo, p.imagen, dp.titulo
        FROM persona_laboral pl
        INNER JOIN persona_profile p ON pl.idpersona = p.idpersona
        INNER JOIN departamento dp ON pl.departamento = dp.iddepartamento
        ORDER BY pl.idpersona $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll();
        return $data;
    }

    public function getempleados($iddepartamento, $txtbuscar){
        $sql = "SELECT pl.idpersona, pl.departamento, p.nombre, p.apellido, p.imagen 
        FROM persona_laboral pl
        LEFT JOIN persona_profile p ON pl.idpersona = p.idpersona
        WHERE pl.departamento = ? AND (p.nombre LIKE ? OR p.apellido LIKE ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$iddepartamento, '%'.$txtbuscar.'%', '%'.$txtbuscar.'%']);
        $data = $smts->fetchAll();
        return $data;
    }

    function contar_inspectores($iddepartamento){
        $sql = "SELECT COUNT(*) AS total FROM persona_laboral WHERE departamento = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$iddepartamento]);
        $data = $smts->fetchColumn();
        return $data;
    }


    public function del_empleado($idempleado){
        $sql = "SELECT imagen FROM persona_profile WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data3 = $smts->fetchColumn();
        if ($data3!=='no-image.webp'){
            unlink('../assest/images/personal/'.$data3);
        }
        
        $sql = "DELETE FROM persona_profile WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->rowCount();
        
        $sql = "DELETE FROM persona_address WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data2 = $smts->rowCount();
        
        $sql = "DELETE FROM persona_menu WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data4 = $smts->rowCount();
        
        $sql = "DELETE FROM persona_laboral WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data5 = $smts->rowCount();
        
        return $data;


    }
    public function getEmpId($idempleado){
        $sql = "SELECT pl.idpersona, pl.fecha_ingreso, pl.cargo, pl.is_manager, pl.departamento, p.nombre, p.apellido, p.identificacion, p.sexo, p.fecha_nacimiento, p.email, p.telefono, p.tipo, pa.address_line1, pa.city, p.imagen, p.has_access, dp.titulo
        FROM persona_laboral pl
        LEFT JOIN persona_profile p ON pl.idpersona = p.idpersona
        LEFT JOIN persona_address pa ON pl.idpersona = pa.idpersona
        LEFT JOIN departamento dp ON pl.departamento = dp.iddepartamento
        LEFT JOIN persona_menu mn ON pl.idpersona = mn.idpersona
        WHERE pl.idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->fetchAll();
        return $data;
    }

    public function getMenu($idempleado){
        $sql = "SELECT * FROM persona_menu WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempleado]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function select_paises(){
        $sql = "SELECT id, nombre FROM paises ORDER BY id ASC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchAll();
        return $data;
    }

    public function getprofile($idpersona){
        $sql = "SELECT p.nombre, p.apellido, p.identificacion, p.email, p.telefono, a.address_line1, a.city, a.pais, a.zipcode
        FROM $this->tb p
        INNER JOIN $this->tbaddress a ON p.idpersona = a.idpersona
        WHERE p.idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpersona]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function daracceso($id, $has_access){
        $sql = "UPDATE $this->tb SET has_access = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$has_access, $id]);
        $data = $smts->rowCount();
        return $data;
    }

    public function updEmpleado($id, $nombre, $apellido, $identificacion, $sexo, $telefono, $email, $nacimiento,  $imagen, $has_access, $direccion, $ciudad, $tipo, $ingreso, $cargo, $ismanager, $iddepartamento,  $pagos, $departamentos, $personal, $iconos, $feedback, $desarrollo, $tickets, $planes, $clientes){
        $sql1 = $this->__update($id, $nombre, $apellido, $identificacion, $sexo, $telefono, $email, $nacimiento, $imagen, $has_access, $tipo);
        if($ismanager==1){
            $sql5 = $this->upd_ManagerDpto($id, $iddepartamento);
        } else {
            $sql5 = 0;
        }
        $sql2 = $this->upd_direccion($id, $direccion, $ciudad);
        $sql3 = $this->upd_historial_laboral($id, $ingreso, $cargo, $ismanager, $iddepartamento);
        $sql4 = $this->upd_persona_menu($id, $pagos, $departamentos, $personal, $iconos, $feedback, $desarrollo, $tickets, $planes, $clientes);
        if($sql1 > 0 || $sql2 > 0 || $sql3 > 0 || $sql4 > 0 || $sql5 > 0){
            return 1;
        } else {
            return 0;
        }
            
    }

    function update_admin_data($idpersona, $nombre, $apellido, $identificacion, $email, $celular){
        $sql = "UPDATE persona_profile SET nombre = ?, apellido = ?, identificacion = ?, email = ?, telefono = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $apellido, $identificacion, $email, $celular, $idpersona]);
        $data = $smts->rowCount();
        return $data;
    }

    function update_admin_direccion($idpersona, $direccion, $ciudad, $pais, $zipcode){
        $sql = "UPDATE persona_address SET address_line1 = ?, city = ?, pais = ?, zipcode = ? WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$direccion, $ciudad, $pais, $zipcode, $idpersona]);
        $data = $smts->rowCount();
        return $data;
    }

    public function getAdminProfile(){
        $sql = "SELECT p.nombre, p.apellido, p.identificacion, p.email, p.telefono, a.address_line1, a.city, a.pais, a.zipcode
        FROM persona_profile p
        LEFT JOIN persona_address a ON p.idpersona = a.idpersona
        WHERE p.idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$_SESSION['id999822']]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function updateProfile($idpersona, $nombre, $apellido, $identificacion, $email, $telefono, $direccion, $ciudad, $pais, $codigo){
        $rs = self::update_admin_data($idpersona, $nombre, $apellido, $identificacion, $email, $telefono);
        $rs2 = self::update_admin_direccion($idpersona, $direccion, $ciudad, $pais, $codigo);
        $rx = $rs + $rs2;
        if($rx > 0 ){
            $_SESSION['nm167852'] = $nombre;
            return 1;
        } else {
            return 0;
        } 
    }

    public function changepass($id, $clave_actual, $nueva_clave1){
        $sql = "SELECT clave FROM $this->tb WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchColumn();
        if(password_verify($clave_actual, $data)){
            $clave = password_hash($nueva_clave1, PASSWORD_DEFAULT);
            $sql = "UPDATE $this->tb SET clave = ? WHERE idpersona = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$clave, $id]);
            $data = $smts->rowCount();
            return $data;
        } else {
            return 0;
        }
    }


}







?>