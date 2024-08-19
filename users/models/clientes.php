<?php

require_once 'connect.php';
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;


class Clientes {
    private $tblemp = "empresa_profile";
    private $tblcam = "unidades_profile";
    private $conexion;


    function __construct() {
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    public function total_registros(){
        $sql = "SELECT COUNT(*) AS total FROM $this->tblemp";
        $execute = $this->conexion->query($sql);
        $request = $execute->fetch(PDO::FETCH_ASSOC);
        return $request['total'];
    }

    public function total_unidades(){
        $sql = "SELECT COUNT(*) AS total FROM $this->tblcam";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $request = $smts->fetch(PDO::FETCH_ASSOC);
        return $request['total'];
    }

    public function total_unidades_emp($idempresa){
        $sql = "SELECT COUNT(*) AS total FROM $this->tblcam WHERE idempresa = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $request = $smts->fetch(PDO::FETCH_ASSOC);
        return $request['total'];
    }

    public function obtener_clientes_paginados($inicio, $registros, $orden){
        $sql = "SELECT id, nombre, nif, correo, telefono FROM $this->tblemp LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['unidades'] = self::total_unidades_emp($value['id']);
        }
        return $data;
    }

    public function busqueda_clientes_($txtbuscar){
        $sql = "SELECT id, nombre, nif, correo, telefono FROM $this->tblemp 
        WHERE nombre LIKE '%$txtbuscar%' OR nif LIKE '%$txtbuscar%' OR correo LIKE '%$txtbuscar%' OR telefono LIKE '%$txtbuscar%'";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['unidades'] = self::total_unidades_emp($value['id']);
        }
        return $data;
    }

    public function borrar_imagen_empresa($id){
        $sql = "SELECT imagen FROM $this->tblemp WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        if ($data['imagen'] != 'assest/images/no-image.webp') {
            unlink('../'.$data['imagen']);
        }
    }

    public function obtener_cliente($id){
        $sql = "SELECT id, nombre, nif, correo, telefono, direccion, ciudad, provincia, imagen FROM $this->tblemp WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function obtener_ultimo_historial_unidad($id){
        $sql = "SELECT estado FROM actividad_unidad_estados WHERE idunidad = ? ORDER BY id DESC LIMIT 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchColumn();
        return $data;
    }

    public function obtener_unidades_paginados($inicio, $registros, $orden){
        $sql = "SELECT un.*, em.nombre 
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        ORDER BY un.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function obtener_unidades_emp_paginados($idempresa, $inicio, $registros, $orden){
        $sql = "SELECT un.idempresa, un.tipo, un.marca, un.ppu, un.modelo, un.year, un.chasis, un.ubicacion, un.estatus, un.id, em.nombre, em.imagen 
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        WHERE un.idempresa = ?
        ORDER BY un.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $historial = self::obtener_ultimo_historial_unidad($value['id']);
            if($historial){
                $data[$key]['und_last_hist'] = $historial;
            } else {
                $data[$key]['und_last_hist'] = 0;
            }
            
        }
        return $data;
    }

    public function buscar_unidades_emp_paginados($txt, $idempresa){
        $sql = "SELECT un.idempresa, un.tipo, un.marca, un.ppu, un.modelo, un.year, un.chasis, un.ubicacion, un.estatus, un.id, em.nombre, em.imagen 
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        WHERE un.idempresa = ? AND (un.ppu LIKE '%$txt%' OR un.tipo LIKE '%$txt%' OR un.marca LIKE '%$txt%' OR un.modelo LIKE '%$txt%' OR un.year LIKE '%$txt%' OR un.chasis LIKE '%$txt%' OR un.ubicacion LIKE '%$txt%' OR un.estatus LIKE '%$txt%')
        ORDER BY un.id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['und_last_hist'] = self::obtener_ultimo_historial_unidad($value['id']);
        }
        return $data;
    }

    public function obtener_unidades_emp($id){
        $sql = "SELECT * FROM $this->tblcam WHERE idempresa = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function obtener_unidades($id){
        $sql = "SELECT und.*, em.id as idempresa, em.nombre, em.imagen 
        FROM $this->tblcam und
        LEFT JOIN $this->tblemp em ON und.idempresa = em.id
        WHERE und.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function guardar_unidades($idempresa, $ppu_tracto, $ppu_semi, $tipo, $marca, $modelo, $year, $km_actual, $km_proximo, $chasis, $ubicacion, $estatus){
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO $this->tblcam (idempresa, ppu, ppu_semi, tipo, marca, modelo, year, chasis, km_actual, km_proximo, ubicacion, estatus, fecha_creado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa, $ppu_tracto, $ppu_semi, $tipo, $marca, $modelo, $year, $chasis, $km_actual, $km_proximo, $ubicacion, $estatus, $fecha]);
        $data = $this->conexion->lastInsertId();
        if($data > 0){
            $sql = "INSERT INTO actividad_unidad_estados (idempresa, idunidad, estado, descripcion, actualizado_por, fecha_actualizado) VALUES (?, ?, ?, ?, ?, ?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idempresa, $data, $estatus, 'Unidad creada', $_SESSION['id999822'], $fecha]);
        }
        return $data;
    }

    function guardar_unidades_bulk($empresa, $ppu_tracto, $ppu_semi, $tipo, $marca, $modelo, $year, $km_actual, $km_proximo, $chasis, $ubicacion, $estatus){
        $idempresa = self::obtener_id_empresa($empresa);
        if($idempresa==0){
            return 'E01';
        } else {
            $fecha = date('Y-m-d');

            $sql = "SELECT COUNT(*) FROM $this->tblcam WHERE idempresa = ? AND ppu = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idempresa, $ppu_tracto]);
            $data = $smts->fetchColumn();
            if($data > 0){
                return 'E02';
            } else {
                $sql = "INSERT INTO $this->tblcam (idempresa, ppu, ppu_semi, tipo, marca, modelo, year, chasis, km_actual, km_proximo, ubicacion, estatus, fecha_creado, contrato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $smts = $this->conexion->prepare($sql);
                $smts->execute([$idempresa, $ppu_tracto, $ppu_semi, $tipo, $marca, $modelo, $year, $chasis, $km_actual, $km_proximo, $ubicacion, $estatus, $fecha, '']);
                $data = $this->conexion->lastInsertId();
                    if($data > 0){
                        $sql = "INSERT INTO actividad_unidad_estados (idempresa, idunidad, estado, descripcion, actualizado_por, fecha_actualizado) VALUES (?, ?, ?, ?, ?, ?)";
                        $smts = $this->conexion->prepare($sql);
                        $smts->execute([$idempresa, $data, $estatus, 'Unidad creada', $_SESSION['id999822'], $fecha]);
                        return $data;
                    } else {
                        return 'E02'; // Error al guardar
                    }
            }
        }
    }

    function actualizar_unidades($idunidad, $idempresa, $ppu_tracto, $tipo, $marca, $modelo, $year, $chasis,$estatus, $ubicacion, $km_actual, $km_proximo){
        $sq = "SELECT estatus FROM $this->tblcam WHERE id = ? AND idempresa = ?";
        $stmt = $this->conexion->prepare($sq);
        $stmt->execute([$idunidad, $idempresa]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data['estatus'] != $estatus) {
            $fecha = date('Y-m-d');
            $sql = "INSERT INTO actividad_unidad_estados (idempresa, idunidad, estado, descripcion, actualizado_por, fecha_actualizado) VALUES (?, ?, ?, ?, ?, ?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idempresa, $idunidad, $estatus, 'Unidad actualizada', $_SESSION['id999822'], $fecha]);
        }
        $sql = "UPDATE $this->tblcam SET ppu = ?, tipo = ?, marca = ?, modelo = ?, year = ?, chasis = ?, ubicacion = ?, estatus = ?, km_actual = ?, km_proximo = ? WHERE id = ? AND idempresa= ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$ppu_tracto, $tipo, $marca, $modelo, $year, $chasis, $ubicacion, $estatus, $km_actual, $km_proximo, $idunidad, $idempresa]);
        $data = $smts->rowCount();
        return $data;
    }

    function borrar_unidades($idunidad){
        $sql = "DELETE FROM $this->tblcam WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idunidad]);
        $data = $smts->rowCount();
        return $data;
    }

    function obtener_unidades_id($idunidad){
        $sql = "SELECT * FROM $this->tblcam WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idunidad]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    
    function guardar_cliente($nombre, $nif, $email, $telefono, $direccion, $web, $ciudad, $provincia, $imagen){
        $clave = password_hash($nif, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->tblemp (nombre, nif, correo, clave, telefono, direccion, website, ciudad, provincia, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $nif, $email, $clave, $telefono, $direccion, $web, $ciudad, $provincia, $imagen]);
        $data = $this->conexion->lastInsertId();
        return $data;
    }

    function actualizar_cliente($idempresa, $nombre, $nif, $email, $telefono, $direccion, $web, $ciudad, $provincia, $imagen){
        $sql = "SELECT imagen FROM $this->tblemp WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        if ($data['imagen'] != $imagen) {
            if ($data['imagen'] != 'assest/images/no-image.webp') {
                unlink('..'.$data['imagen']);
            }
        }
        $sql = "UPDATE $this->tblemp SET nombre = ?, nif = ?, correo = ?, telefono = ?, direccion = ?, website = ?, ciudad = ?, provincia = ?, imagen = ? WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre, $nif, $email, $telefono, $direccion, $web, $ciudad, $provincia, $imagen, $idempresa]);
        $data = $smts->rowCount();
        return $data;
    }

    function borrar_camiones($idempresa){
        $sql = "DELETE FROM $this->tblcam WHERE idempresa = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->rowCount();
        return $data;
    }

    function borrar_unidad($id){
        $sql = "DELETE FROM $this->tblcam WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->rowCount();
        return $data;
    }

    function borrar_cliente($idempresa){
        $sql = "SELECT imagen FROM $this->tblemp WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        if ($data['imagen'] !== 'assest/images/no-image.webp') {
            unlink('../'.$data['imagen']);
        }

        $rs = $this->borrar_camiones($idempresa);


        $sql = "DELETE FROM $this->tblemp WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->rowCount();
        return $data;

    }

    function obtener_lista($busqueda){
        $sql = "SELECT id, nombre FROM $this->tblemp WHERE nombre LIKE '%$busqueda%' OR nif ='%$busqueda%' OR correo =  '%$busqueda%' ORDER BY nombre ASC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function obtener_datos_unidad($idunidad){
        $sql = "SELECT un.ppu, un.idempresa, em.nombre, un.tipo 
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        WHERE un.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idunidad]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data[0];
    }

    function obtener_empresa($idempresa){
        $sql = "SELECT nombre FROM $this->tblemp WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        return $data['nombre'];
    }

    function obtener_historial_unidad($id){
        $sql = "SELECT * FROM actividad_unidad_estados WHERE idunidad = ? ORDER BY id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function obtener_id_empresa($nombre){
        $sql = "SELECT id FROM $this->tblemp WHERE nombre = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$nombre]);
        $data = $smts->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)){
            return $data['id'];
        } else {
            return 0;
        }
        
    }


    public function obtener_unidades_spot_paginados($inicio, $registros, $orden){
        $sql = "SELECT un.idempresa, un.tipo, un.marca, un.id as idunidad, un.ppu, un.modelo, un.year,  un.ubicacion, un.estatus, un.km_actual, em.nombre as empresa, ip.id,  um.fecha_revision  
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        LEFT JOIN actividades_solicitud ip ON un.id = ip.idunidad
        LEFT JOIN actividad_tallerip um ON ip.id = um.id
        ORDER BY un.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['und_last_hist'] = self::obtener_ultimo_historial_unidad($value['id']);
        }
        return $data;
    }

    public function buscar_unidades_spot_paginados($txt){
        $sql = "SELECT un.idempresa, un.tipo, un.marca, un.ppu, un.modelo, un.year, un.chasis, un.ubicacion, un.estatus, un.id, em.nombre, em.imagen 
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        WHERE un.ppu LIKE '%$txt%' OR un.tipo LIKE '%$txt%' OR un.marca LIKE '%$txt%' OR un.modelo LIKE '%$txt%' OR un.year LIKE '%$txt%' OR un.chasis LIKE '%$txt%' OR un.ubicacion LIKE '%$txt%' OR un.estatus LIKE '%$txt%'
        ORDER BY un.id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['und_last_hist'] = self::obtener_ultimo_historial_unidad($value['id']);
        }
        return $data;
    }

    public function buscar_unidades_spot_fechas($fecha){
        $sql = "SELECT un.idempresa, un.tipo, un.marca, un.ppu, un.modelo, un.year, un.chasis, un.ubicacion, un.estatus, un.id, em.nombre, em.imagen, hi.fecha_actualizado 
        FROM $this->tblcam un
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        LEFT JOIN actividad_unidad_estados hi ON un.id = hi.idunidad
        WHERE un.fecha_creado = ? 
        ORDER BY un.id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value) {
            $data[$key]['und_last_hist'] = self::obtener_ultimo_historial_unidad($value['id']);
        }
        return $data;
    }


    

} 