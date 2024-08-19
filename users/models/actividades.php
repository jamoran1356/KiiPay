<?php

require_once 'connect.php';

class Actividad{
    private $conexion;
    private $tblemp = "empresa_profile";
    private $tblcam = "unidades_profile";
    
    public function __construct(){
        $this->conexion = new ConexionBDD();
        $this->conexion = $this->conexion->connect();
    }

    function grabar_actividad_ip($idsolicitud, $fecha_revision, $hora, $semana,  $solicitado_por, $autorizado_por, $inspector){

        $sql = "SELECT COUNT(*) FROM actividad_tallerip WHERE idsolicitud = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $result = $smts->fetch(PDO::FETCH_ASSOC);
        if($result['COUNT(*)'] > 0){
            return 'E01'; //ya existe una actividad para esta solicitud
        } else {
            $sql = "INSERT INTO actividad_tallerip (idsolicitud, fecha_revision, hora, semana,  solicitado_por, autorizado_por, estado_solicitud) VALUES (?,?,?,?,?,?,?)";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idsolicitud, $fecha_revision, $hora, $semana, $solicitado_por, $autorizado_por, 'Pendiente']);
            $result = $this->conexion->lastInsertId();

            if($result > 0 && !empty($inspector)){
                $inspector = explode(',', $inspector);
                for ($i=0; $i < count($inspector); $i++) { 
                    $this->asignar_actividades($result, $inspector[$i]);
                }

                $sql = "UPDATE actividades_solicitud SET estado_solicitud = 1 WHERE id = ?";
                $smts = $this->conexion->prepare($sql);
                $smts->execute([$idsolicitud]);

            }
            return $result;
        }

        
    }

    function actualizar_actividad_op($idactividad, $fecha_solicitud, $fecha_revision, $hora, $taller, $semana, $actividad, $ubicacion, $solicitado_por, $autorizado_por, $inspector){
        $sql = "UPDATE actividad_tallerip SET fecha_solicitud = ?, fecha_revision = ?, hora = ?, taller = ?, semana = ?, actividad = ?, ubicacion = ?, solicitado_por = ?, autorizado_por = ?, inspector = ? WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$fecha_solicitud, $fecha_revision, $hora, $taller, $semana, $actividad, $ubicacion, $solicitado_por, $autorizado_por, $inspector, $idactividad]);
        $result = $smts->rowCount();
        return $result;
    }

    function borrar_actividad($idactividad){
        $sql = "SELECT COUNT(*) FROM actividad_tallerip WHERE idsolicitud = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad]);
        $result = $smts->fetch(PDO::FETCH_ASSOC);
        if($result['COUNT(*)'] > 0){
            return 0;
        } else {
            $sql = "DELETE FROM actividades_solicitud WHERE id = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idactividad]);
            $result = $smts->rowCount();
            return $result;
        }
        
    }

    function crear_actualizaciones($idactividad, $estado_actividad, $estado_unidad, $checklist, $comentario, $actualizado_por, $solicitado_por, $fecha_actividad, $hora_actividad){
        $fecha_actualizacion = date('Y-m-d H:i:s');
        $sql = "INSERT INTO actividad_actualizaciones_ip (idactividad, estado_actividad,  estado_unidad, checklist, comentario, actualizado_por, solicitado_por, fecha_actividad, hora_actividad, fecha_actualizacion) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad, $estado_actividad, $estado_unidad, $checklist, $comentario, $actualizado_por, $solicitado_por, $fecha_actividad, $hora_actividad, $fecha_actualizacion]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function actualizar_actualizaciones($idactualizacion, $idactividad, $estado, $status, $checklist, $comentario, $fecha_actualizacion, $inspector){
        $sql = "UPDATE actividad_actualizaciones_ip SET estado = ?, status = ?, checklist = ?, comentario = ?, fecha_actualizacion = ?, inspector = ? WHERE id = ? AND idactividad = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$estado, $status, $checklist, $comentario, $fecha_actualizacion, $inspector, $idactualizacion, $idactividad]);
        $result = $smts->rowCount();
        return $result;
    }

    function grabar_solicitud($idempresa, $idunidad, $km_actual, $km_ultima, $fecha_ultima, $tipo, $servicio, $taller, $ubicacion, $observaciones, $estatus){
        $fecha = date('Y-m-d');  
        $sql = "INSERT INTO actividades_solicitud (idempresa, idunidad, km_actual, km_ultima, fecha_ultima, tipo_servicio, contrato, taller, ubicacion, estado_unidad, observaciones, estado_solicitud, fecha_solicitud, idusuario) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa, $idunidad, $km_actual, $km_ultima, $fecha_ultima, $tipo, $servicio, $taller, $ubicacion, $estatus, $observaciones, 0, $fecha, $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();
        if($result > 0){
            $sql = "UPDATE unidades_profile SET km_actual = ?, estatus = ? WHERE id = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$km_actual, $estatus, $idunidad]);
        }
        return $result;
    }

    
    function total_registros_ip(){
        $sql = "SELECT COUNT(*) FROM actividad_tallerip";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $result = $smts->fetchColumn();
        return $result;
    }

    function total_registros_solicitudes(){
        $sql = "SELECT COUNT(*) FROM actividades_solicitud";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $result = $smts->fetchColumn();
        return $result;
    }

    function total_registros_insp($idusuario){
        $sql = "SELECT COUNT(*) FROM asignaciones_inspector WHERE idinspector = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idusuario]);
        $result = $smts->fetchColumn();
        return $result;
    }

    function listado_actividades_paginado($inicio, $registros, $orden){
        $sql = "SELECT act.*, em.nombre as empresa, un.ppu, un.tipo, un.marca, un.modelo, un.km_actual, un.km_proximo, ai.idinspector, sn.nombre as insnombre, sn.apellido as insapellido
        FROM actividad_tallerip act
        LEFT JOIN unidades_profile un ON act.idunidad = un.id
        LEFT JOIN empresa_profile em ON act.idempresa = em.id
        LEFT JOIN asignaciones_inspector ai ON act.id = ai.idactividad
        LEFT JOIN persona_profile sn ON ai.idinspector = sn.idpersona
        ORDER BY act.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function obtener_inspectores($id){
        $sql = "SELECT nombre, apellido FROM persona_profile WHERE idpersona = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function obtener_solicitud_basica_id($id){
        $sql = "SELECT so.*, emp.nombre as empresa, un.ppu 
        FROM actividades_solicitud so 
        LEFT JOIN empresa_profile emp ON so.idempresa = emp.id
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        WHERE so.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


    function obtener_solicitud_rd($id){
        $sql = "SELECT so.*, emp.nombre as empresa, un.ppu, un.estatus, ip.*, ip.id as idactividad 
        FROM actividades_solicitud so
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        LEFT JOIN empresa_profile emp ON so.idempresa = emp.id
        LEFT JOIN actividad_tallerip ip ON so.id = ip.idsolicitud
        WHERE so.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)){
            $sql_inspectores = "SELECT idinspector 
            FROM asignaciones_inspector
            WHERE idactividad = ?";
            $smts = $this->conexion->prepare($sql_inspectores);
            $smts->execute([$data[0]['idactividad']]);
            $inspectores = $smts->fetchAll(PDO::FETCH_ASSOC);
            $arrayinspectores = [];
            foreach($inspectores as $inspector){
                $inspectorData = $this->obtener_inspectores($inspector['idinspector']);
                foreach($inspectorData as $inspectorDetail){
                    $arrayinspectores[] = $inspectorDetail['nombre'] . ' ' . $inspectorDetail['apellido'];
                }
            }
            $data[0]['inspectores'] = implode(", ", $arrayinspectores);
        }

       
    }

    function obtener_solicitud_id($id){
        $sql = "SELECT so.*, so.estado_solicitud as edosolicitud, emp.nombre as empresa, un.ppu, un.estatus, ip.*, ip.id as idactividad 
        FROM actividades_solicitud so
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        LEFT JOIN empresa_profile emp ON so.idempresa = emp.id
        LEFT JOIN actividad_tallerip ip ON so.id = ip.idsolicitud
        WHERE so.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($data)){
            $sql_inspectores = "SELECT idinspector 
            FROM asignaciones_inspector
            WHERE idactividad = ?";
            $smts = $this->conexion->prepare($sql_inspectores);
            $smts->execute([$data[0]['idactividad']]);
            $inspectores = $smts->fetchAll(PDO::FETCH_ASSOC);
            $arrayinspectores = [];
            foreach($inspectores as $inspector){
                $inspectorData = $this->obtener_inspectores($inspector['idinspector']);
                foreach($inspectorData as $inspectorDetail){
                    $arrayinspectores[] = $inspectorDetail['nombre'] . ' ' . $inspectorDetail['apellido'];
                }
            }
            $data[0]['inspectores'] = implode(", ", $arrayinspectores);
        }
        return $data;
    }

    function listado_solicitudes_paginado($inicio, $registros, $orden, $comparacion, $valor){
        $sql = "SELECT so.id, so.idempresa, so.idunidad, so.km_actual, so.km_ultima, so.fecha_ultima, so.tipo_servicio, so.fecha_solicitud, so.estado_solicitud, emp.nombre as empresa, un.ppu, un.estatus, ip.id as idactividad 
        FROM actividades_solicitud so
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        LEFT JOIN empresa_profile emp ON so.idempresa = emp.id
        LEFT JOIN asignaciones_inspector ai ON so.id = ai.idactividad
        LEFT JOIN persona_profile insp ON ai.idinspector = insp.idpersona
        LEFT JOIN actividad_tallerip ip ON so.id = ip.idsolicitud
        WHERE so.estado_solicitud $comparacion ?
        ORDER BY so.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $key => $value){
            $data[$key]['last_status'] = self::obtener_ultimo_historial_unidad($value['idunidad']);
        }
        if(!empty($data)){
            if($data[0]['idactividad'] != null){
                $sql_inspectores = "SELECT idinspector 
                FROM asignaciones_inspector
                WHERE idactividad = ?";
                $smts = $this->conexion->prepare($sql_inspectores);
                $smts->execute([$data[0]['idactividad']]);
                $inspectores = $smts->fetchAll(PDO::FETCH_ASSOC);
                if(!empty($inspectores)){
                        $data[0]['inspector_edo'][] = "Asignado";
                }
            } else {
                $data[0]['inspector_edo'][] = 0;
            }
            
        }
        return $data;
    }

    //getip mejorado 
    function listado_solicitudes_ip_paginado($inicio, $registros, $orden, $valor){
        $sql = "SELECT so.id, so.idempresa, so.idunidad, so.km_actual, so.km_ultima, so.fecha_ultima, so.tipo_servicio, so.fecha_solicitud, so.estado_solicitud, emp.nombre as empresa, un.ppu, un.estatus, ip.id as idactividad 
        FROM actividades_solicitud so
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        LEFT JOIN empresa_profile emp ON so.idempresa = emp.id
        LEFT JOIN asignaciones_inspector ai ON so.id = ai.idactividad
        LEFT JOIN persona_profile insp ON ai.idinspector = insp.idpersona
        LEFT JOIN actividad_tallerip ip ON so.id = ip.idsolicitud
        WHERE so.estado_solicitud = ?
        ORDER BY so.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $key => $value){
            $data[$key]['last_status'] = self::obtener_ultimo_historial_unidad($value['idunidad']);
        }
        if(!empty($data)){
            if($data[0]['idactividad'] != null){
                $sql_inspectores = "SELECT idinspector 
                FROM asignaciones_inspector
                WHERE idactividad = ?";
                $smts = $this->conexion->prepare($sql_inspectores);
                $smts->execute([$data[0]['idactividad']]);
                $inspectores = $smts->fetchAll(PDO::FETCH_ASSOC);
                if(!empty($inspectores)){
                        $data[0]['inspector_edo'][] = "Asignado";
                }
            } else {
                $data[0]['inspector_edo'][] = 0;
            }
            
        }
        return $data;
    }

    function esTextoValido($txt) {
        if (empty($txt)) {
            return false;
        }
        if (strlen($txt) > 100) {
            return false;
        }
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $txt)) {
            return false;
        }
        return true;
    }

    function listado_solicitudes_busqueda($txtbusqueda,$comparacion, $valor){
        $sql = "SELECT so.id, so.idempresa, so.idunidad, so.km_actual, so.km_ultima, so.fecha_ultima, so.tipo_servicio, so.fecha_solicitud, so.estado_solicitud, emp.nombre as empresa, un.ppu, un.estatus, ip.id as idactividad 
        FROM actividades_solicitud so
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        LEFT JOIN empresa_profile emp ON so.idempresa = emp.id
        LEFT JOIN asignaciones_inspector ai ON so.id = ai.idactividad
        LEFT JOIN persona_profile insp ON ai.idinspector = insp.idpersona
        LEFT JOIN actividad_tallerip ip ON so.id = ip.idsolicitud
        WHERE so.estado_solicitud $comparacion ? AND (un.ppu LIKE ? OR emp.nombre LIKE ? OR so.tipo_servicio LIKE ?)
        ORDER BY so.id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor, "%$txtbusqueda%", "%$txtbusqueda%", "%$txtbusqueda%"]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)){
            if($data[0]['idactividad'] != null){
                $sql_inspectores = "SELECT idinspector 
                FROM asignaciones_inspector
                WHERE idactividad = ?";
                $smts = $this->conexion->prepare($sql_inspectores);
                $smts->execute([$data[0]['idactividad']]);
                $inspectores = $smts->fetchAll(PDO::FETCH_ASSOC);
                if(!empty($inspectores)){
                        $data[0]['inspector_edo'][] = "Asignado";
                }
            } else {
                $data[0]['inspector_edo'][] = 0;
            }
            
        }
        return $data;
    }

    function listado_actividades_paginado_insp($idusuario, $inicio, $registros, $orden){
        $sql = "SELECT asg.idactividad, act.idsolicitud, sol.idunidad, sol.idempresa, em.nombre as empresa, un.ppu, un.tipo 
        FROM asignaciones_inspector asg
        LEFT JOIN actividad_tallerip act ON asg.idactividad = act.id
        LEFT JOIN actividades_solicitud sol ON act.idsolicitud = sol.id
        LEFT JOIN empresa_profile em ON sol.idempresa = em.id
        LEFT JOIN unidades_profile un ON sol.idunidad = un.id
        WHERE asg.idinspector = ? ORDER BY act.id DESC LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idusuario]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function get_actividad_by_id($idactividad){
        $sql = "SELECT act.*, em.nombre as empresa, un.ppu_semi, un.ppu, un.tipo, un.marca, un.modelo, un.km_actual, un.km_proximo, ai.idinspector, sn.nombre as insnombre, sn.apellido as insapellido
        FROM actividad_tallerip act
        LEFT JOIN unidades_profile un ON act.idunidad = un.id
        LEFT JOIN empresa_profile em ON act.idempresa = em.id
        LEFT JOIN asignaciones_inspector ai ON act.id = ai.idactividad
        LEFT JOIN persona_profile sn ON ai.idinspector = sn.idpersona
        WHERE act.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function asignar_actividades($idactividad, $idinspector){
        $sql = "INSERT INTO asignaciones_inspector (idactividad, tipo, idinspector) VALUES (?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad, 'IP', $idinspector]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function actualizar_estado_unidad($idempresa, $idunidad, $estatus, $descripcion){
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO actividad_unidad_estados (idempresa, idunidad, estado, descripcion, actualizado_por, fecha_actualizado) VALUES (?, ?, ?, ?, ?, ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa, $idunidad, $estatus, $descripcion, $_SESSION['id999822'], $fecha]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function desasignar_actividades($idactividad, $idinspector){
        $sql = "DELETE FROM asignaciones_inspector WHERE idactividad = ? AND idinspector = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad, $idinspector]);
        $result = $smts->rowCount();
        return $result;
    }

    function get_actividades_asignadas($idinspector){
        $sql = "SELECT act.*, em.nombre as empresa, un.ppu_semi, un.ppu, un.tipo, un.marca, un.modelo, un.km_actual, un.km_proximo, ai.idinspector, sn.nombre as insnombre, sn.apellido as insapellido
        FROM actividad_tallerip act
        LEFT JOIN unidades_profile un ON act.idunidad = un.id
        LEFT JOIN empresa_profile em ON act.idempresa = em.id
        LEFT JOIN asignaciones_inspector ai ON act.id = ai.idactividad AND ai.tipo = 'IP'
        LEFT JOIN persona_profile sn ON ai.idinspector = sn.idpersona
        WHERE ai.idinspector = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idinspector]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function total_registros_actividades_insp(){
        $sql = "SELECT COUNT(*) FROM asignaciones_inspector WHERE idinspector = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$_SESSION['id999822']]);
        $result = $smts->fetchColumn();
        return $result;
    }

    function listado_solicitudes_inspectores($inicio, $registros, $orden){
        $sql = "SELECT ai.idactividad, act.fecha_revision, act.hora, act.idsolicitud, so.ubicacion, so.estado_unidad, so.idempresa, so.id as idsolicitud, so.idunidad, em.nombre as empresa, un.tipo, un.ppu 
        FROM asignaciones_inspector ai
        LEFT JOIN actividad_tallerip act ON ai.idactividad = act.id
        LEFT JOIN actividades_solicitud so ON act.idsolicitud = so.id
        LEFT JOIN empresa_profile em ON so.idempresa = em.id
        LEFT JOIN unidades_profile un ON so.idunidad = un.id
        WHERE ai.idinspector = ?
        ORDER BY act.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$_SESSION['id999822']]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function guardar_avance_spot($idsolicitud, $fecha_realizado, $hora_ralizado, $realizo, $motivo, $estado_unidad, $observaciones){
        $sql = "INSERT INTO actividad_realizadas_spot (idsolicitud, fecha_inspeccion, hora_inspeccion, realizo, motivo, estado_unidad_sugerido, observaciones, fecha_actualizado, actualizado_por) VALUES (?,?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud, $fecha_realizado, $hora_ralizado, $realizo, $motivo, $estado_unidad, $observaciones, date('Y-m-d H:i:s'), $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function guardar_avance($idsolicitud, $fecha_realizado, $hora_ralizado, $realizo, $motivo, $estado_unidad, $observaciones){
        $sql = "INSERT INTO actividad_realizadas (idsolicitud, fecha_inspeccion, hora_inspeccion, realizo, motivo, estado_unidad_sugerido, observaciones, fecha_actualizado, actualizado_por) VALUES (?,?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud, $fecha_realizado, $hora_ralizado, $realizo, $motivo, $estado_unidad, $observaciones, date('Y-m-d H:i:s'), $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function guardar_archivos_actividad($idactividad, $tipo, $archivo){
        $sql = "INSERT INTO actividad_archivos (idactividad, tipo, archivo) VALUES (?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad, $tipo, $archivo]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function guardar_adjuntos_cierre_panne($idactividad, $tipo, $archivo){
        $sql = "INSERT INTO actividad_archivos_cierre (idreporte, tipo, archivo) VALUES (?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividad, $tipo, $archivo]);
        $result = $this->conexion->lastInsertId();
        return $result;
    }

    function mostrar_adjuntos_cierre($idpanne){
        $sql = "SELECT ac.id, fi.archivo FROM 
        actividad_panne_cierre ac
        LEFT JOIN actividad_archivos_cierre fi ON ac.id = fi.idreporte
        WHERE ac.idpanne = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idpanne]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;   
    }

    function mostrar_actualizaciones($idsolicitud){
        $sql = "SELECT ar.id as idar, ar.*, act.idsolicitud as solicitud, sol.estado_solicitud, pp.nombre, pp.apellido 
        FROM actividad_realizadas ar
        LEFT JOIN persona_profile pp ON ar.actualizado_por = pp.idpersona
        LEFT JOIN actividad_tallerip act ON ar.idsolicitud = act.id
        LEFT JOIN actividades_solicitud sol ON act.idsolicitud = sol.id
        WHERE ar.idsolicitud = ?
        ORDER BY ar.id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($data)){
            $sql_archivos = "SELECT archivo 
            FROM actividad_archivos
            WHERE idactividad = ? AND tipo = 'IP'";
            $smts = $this->conexion->prepare($sql_archivos);
            foreach ($data as $key => $value) {
                if($value['idar'] != null){
                    $smts->execute([$value['idar']]);
                    $archivos = $smts->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($archivos)){
                        $data[$key]['archivo'][] = $archivos;
                    }
                } 
            }
        }
        return $data;
    }

    function obtener_id_empresa($idunidad){
        $sql = "SELECT ep.id FROM empresa_profile ep
        LEFT JOIN unidades_profile up ON ep.id = up.idempresa
        WHERE up.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idunidad]);
        $data = $smts->fetchColumn();
        return $data;
    }

    function mostrar_actualizaciones_spot($idsolicitud){
        $sql = "SELECT ar.*, pp.nombre, pp.apellido 
        FROM actividad_realizadas_spot ar 
        LEFT JOIN persona_profile pp ON ar.actualizado_por = pp.idpersona
        WHERE idsolicitud = ? ORDER BY id DESC";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)){
            $sql_archivos = "SELECT archivo 
            FROM actividad_archivos
            WHERE idactividad = ? AND tipo = 'SPOT'";
            $smts = $this->conexion->prepare($sql_archivos);
            foreach ($data as $key => $value) {
                if($value['id'] != null){
                    $smts->execute([$value['id']]);
                    $archivos = $smts->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($archivos)){
                        $data[$key]['archivo'][] = $archivos;
                    }
                } 
            }
        }
        return $data;
    }

    function obtener_id_solicitud($idactividadip){
        $sql = "SELECT idsolicitud FROM actividad_tallerip WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idactividadip]);
        $data = $smts->fetchColumn();
        return $data;
    }

    function cerrar_actividad($id, $estado_unidad, $observaciones, $motivo){
        $idsol = self::obtener_id_solicitud($id);

        $sql = "INSERT INTO cerrar_actividad (idsolicitud, estado_unidad, motivo, observaciones, fecha_cierre, cerrado_por) VALUES (?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id, $estado_unidad, $motivo, $observaciones, date('Y-m-d H:i:s'), $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();


        $sql1 = "UPDATE actividades_solicitud SET estado_solicitud = 3, fecha_actualizado = ? WHERE id = ?";
        $smts = $this->conexion->prepare($sql1);
        $smts->execute([date('Y-m-d H:i:s'), $idsol]);
        $result = $smts->rowCount();

        $sql2 = "SELECT idunidad, idempresa FROM actividades_solicitud WHERE id = ?";
        $smts = $this->conexion->prepare($sql2);
        $smts->execute([$idsol]);
        $unidad = $smts->fetchAll();
        $idunidad = $unidad[0]['idunidad'];
        $idempresa = $unidad[0]['idempresa'];
        
        self::actualizar_estado_unidad($idempresa, $idunidad, $estado_unidad, 'Unidad actualizada');

        return $result;
        
    }

    function cerrar_actividad_spot($idsolicitud, $idempresa, $idunidad, $estado_unidad, $observaciones, $motivo){

        $sql = "INSERT INTO cerrar_actividad_spot (idsolicitud, estado_unidad, motivo, observaciones, fecha_cierre, cerrado_por) VALUES (?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud, $estado_unidad, $motivo, $observaciones, date('Y-m-d H:i:s'), $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();


        $sql1 = "UPDATE actividades_solicitud_spot SET estado = 3, fecha_actualizado = ? WHERE id = ?";
        $smts = $this->conexion->prepare($sql1);
        $smts->execute([date('Y-m-d H:i:s'), $idsolicitud]);
        $result = $smts->rowCount();
        
        self::actualizar_estado_unidad($idempresa, $idunidad, $estado_unidad, 'Unidad actualizada');

        return $result;
        
    }

    public function obtener_cierre($idsolicitud){
        $sql = "SELECT ca.*, pp.nombre, pp.apellido 
        FROM cerrar_actividad ca
        LEFT JOIN persona_profile pp ON ca.cerrado_por = pp.idpersona
        WHERE idsolicitud = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function obtener_cierre_spot($idsolicitud){
        $sql = "SELECT ca.*, pp.nombre, pp.apellido 
        FROM cerrar_actividad_spot ca
        LEFT JOIN persona_profile pp ON ca.cerrado_por = pp.idpersona
        WHERE idsolicitud = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function obtener_ultimo_historial_unidad($id){
        $sql = "SELECT estado FROM actividad_unidad_estados WHERE idunidad = ? ORDER BY id DESC LIMIT 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchColumn();
        return $data;
    }

    function comprobar_estado_solicitud($id){
        $sql = "SELECT estado_solicitud FROM actividades_solicitud WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $result = $smts->fetchColumn();
        return $result;
    }

    function grabar_panne($idempresa, $idunidad, $ppu_semi, $fecha, $hora, $tipo_falla, $km_tracto, $km_semi, $transportista, $supervisor, $ubicacion, $falla_preliminar, $estado_unidad, $servicio){
        $fecha_creado = date('Y-m-d H:i:s');
        $sql = "INSERT INTO actividades_solicitud_panne (idempresa, idunidad, ppu_semi, fecha, hora, km_actual_tracto, km_actual_semi, servicio, tipo_falla, transportista, supervisor, ubicacion, falla_preliminar, estado_solicitud, fecha_creado, creado_por) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa, $idunidad, $ppu_semi, $fecha, $hora, $km_tracto, $km_semi, $servicio, $tipo_falla, $transportista, $supervisor, $ubicacion, $falla_preliminar, 0, $fecha_creado, $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();
        if($result>0){
            self::actualizar_estado_unidad($idempresa, $idunidad, $estado_unidad, 'Unidad actualizada');
        }
        return $result;
    }

    function editar_panne($idpanne, $idempresa, $idunidad, $ppu_semi, $fecha, $hora, $km_tracto, $km_semi, $transportista, $supervisor, $ubicacion, $falla_preliminar){
        $sql = "UPDATE actividades_solicitud_panne SET idempresa = ?, idunidad = ?, ppu_semi = ?, fecha = ?, hora = ?, km_actual_tracto = ?, km_actual_semi = ?, transportista = ?, supervisor = ?, ubicacion = ?, falla_preliminar = ? WHERE id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idempresa, $idunidad, $ppu_semi, $fecha, $hora, $km_tracto, $km_semi, $transportista, $supervisor, $ubicacion, $falla_preliminar, $idpanne]);
        $result = $smts->rowCount();
        return $result;
    }

    function total_registros_panne(){
        $sql = "SELECT COUNT(*) FROM actividades_solicitud_panne";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $result = $smts->fetchColumn();
        return $result;
    }

    function listado_paginado_panne($inicio, $registros, $orden, $comparacion, $valor){
        $sql = "SELECT pan.idunidad, pan.idempresa, pan.transportista, pan.id as idsolicitud, pan.estado_solicitud, pan.fecha_creado, pan.km_actual_tracto, pan.ppu_semi, pan.km_actual_semi, emp.nombre as empresa, un.ppu
        FROM actividades_solicitud_panne pan
        LEFT JOIN empresa_profile emp ON pan.idempresa = emp.id
        LEFT JOIN unidades_profile un ON pan.idunidad = un.id
        WHERE pan.estado_solicitud $comparacion ?
        ORDER BY pan.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function listado_panne_busqueda($txtbusqueda, $comparacion, $valor){
        $sql = "SELECT pan.idunidad, pan.idempresa, pan.transportista, pan.id as idsolicitud, pan.estado_solicitud, pan.fecha_creado, pan.km_actual_tracto, pan.km_actual_semi, emp.nombre as empresa, un.ppu
        FROM actividades_solicitud_panne pan
        LEFT JOIN empresa_profile emp ON pan.idempresa = emp.id
        LEFT JOIN unidades_profile un ON pan.idunidad = un.id
        WHERE pan.estado_solicitud $comparacion ? AND (un.ppu LIKE ? OR emp.nombre LIKE ? OR pan.transportista LIKE ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor, "%$txtbusqueda%", "%$txtbusqueda%", "%$txtbusqueda%"]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }


    function listado_paginado_panne_ambipar($inicio, $registros, $orden, $comparacion, $valor){
        $sql = "SELECT pan.idunidad, pan.idempresa, pan.transportista, pan.id as idsolicitud, pan.estado_solicitud, CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00') as fecha_creado, pan.km_actual_tracto, pan.km_actual_semi, emp.nombre as empresa, un.ppu
        FROM actividades_solicitud_panne pan
        LEFT JOIN empresa_profile emp ON pan.idempresa = emp.id
        LEFT JOIN unidades_profile un ON pan.idunidad = un.id
        WHERE pan.estado_solicitud $comparacion ? AND (pan.tipo_falla = 'LEVE') 
        AND ((DAYOFWEEK(DATE(CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00'))) BETWEEN 2 AND 6 
        AND HOUR(CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00')) NOT BETWEEN 9 AND 17) 
        OR (DAYOFWEEK(DATE(CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00'))) IN (1, 7)))
        ORDER BY pan.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function listado_panne_busqueda_ambipar($txtbusqueda, $comparacion, $valor){
        $sql = "SELECT pan.idunidad, pan.idempresa, pan.transportista, pan.id as idsolicitud, pan.estado_solicitud, CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00') as fecha_creado, pan.km_actual_tracto, pan.km_actual_semi, emp.nombre as empresa, un.ppu
        FROM actividades_solicitud_panne pan
        LEFT JOIN empresa_profile emp ON pan.idempresa = emp.id
        LEFT JOIN unidades_profile un ON pan.idunidad = un.id
        WHERE pan.estado_solicitud $comparacion ? AND (pan.tipo_falla = 'LEVE') 
        AND ((DAYOFWEEK(DATE(CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00'))) BETWEEN 2 AND 6 
        AND HOUR(CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00')) NOT BETWEEN 9 AND 17) 
        OR (DAYOFWEEK(DATE(CONVERT_TZ(pan.fecha_creado, '+00:00', '-03:00'))) IN (1, 7)))
        AND (un.ppu LIKE ? OR emp.nombre LIKE ? OR pan.transportista LIKE ?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$valor, "%$txtbusqueda%", "%$txtbusqueda%", "%$txtbusqueda%"]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function mostrar_panne($id){
        $sql = "SELECT pan.*, emp.nombre as empresa, un.ppu
        FROM actividades_solicitud_panne pan
        LEFT JOIN empresa_profile emp ON pan.idempresa = emp.id
        LEFT JOIN unidades_profile un ON pan.idunidad = un.id
        WHERE pan.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function grabar_actividad_panne($idsolicitud, $falla, $causa, $accion, $observaciones){
        $sql = "INSERT INTO actividad_panne (idsolicitud, falla, causa, accion, observaciones, fecha_solicitud, solicitado_por) VALUES (?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud, $falla, $causa, $accion, $observaciones, date('Y-m-d H:i:s'), $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();
        if($result > 0){
            $sql = "UPDATE actividades_solicitud_panne SET estado_solicitud = 1 WHERE id = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idsolicitud]);
        }
        return $result;
    }

    
    function verificar_cierre_panne($idsolicitud){  
        $sql = "SELECT COUNT(*) FROM actividad_panne WHERE idsolicitud = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $result = $smts->fetchColumn();
        return $result;
    }

    function mostrar_actividades_panne($idsolicitud){
        $sql = "SELECT ap.*, pa.fecha, pa.hora, pa.fecha_creado, pp.nombre, pp.apellido 
        FROM actividad_panne ap
        LEFT JOIN persona_profile pp ON ap.solicitado_por = pp.idpersona
        LEFT JOIN actividades_solicitud_panne pa ON ap.idsolicitud = pa.id
        WHERE ap.idsolicitud = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($data)){
            $sql_archivos = "SELECT archivo 
            FROM actividad_archivos
            WHERE idactividad = ? AND tipo = 'PANNE'";
            $smts = $this->conexion->prepare($sql_archivos);
            foreach ($data as $key => $value) {
                if($value['id'] != null){
                    $smts->execute([$value['id']]);
                    $archivos = $smts->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($archivos)){
                        $data[$key]['archivo'][] = $archivos;
                    }
                } 
            }
        }
        return $data;
        
    }

    function cerrar_actividad_panne($idsolicitud, $falla, $accion, $estado_unidad, $observaciones){
        $sql = "INSERT INTO actividad_panne_cierre (idpanne, tipo_falla, accion, observaciones, estado_unidad, fecha_cierre, cerrado_por) VALUES (?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud, $falla, $accion, $observaciones, $estado_unidad, date('Y-m-d H:i:s'), $_SESSION['id999822']]);
        $result = $this->conexion->lastInsertId();
        if($result > 0){
            $sql = "UPDATE actividades_solicitud_panne SET estado_solicitud = 3 WHERE id = ?";
            $smts = $this->conexion->prepare($sql);
            $smts->execute([$idsolicitud]);
            $sql2 = "SELECT idunidad, idempresa FROM actividades_solicitud_panne WHERE id = ?";
            $smts = $this->conexion->prepare($sql2);
            $smts->execute([$idsolicitud]);
            $unidad = $smts->fetchAll();
            $idunidad = $unidad[0]['idunidad'];
            $idempresa = $unidad[0]['idempresa'];
            self::actualizar_estado_unidad($idempresa, $idunidad, $estado_unidad, 'Unidad actualizada');
        }
        return $result;
    }



    function mostrar_cierre_panne($idsolicitud){
        $sql = "SELECT ap.*, pp.nombre, pp.apellido 
        FROM actividad_panne_cierre ap
        LEFT JOIN persona_profile pp ON ap.cerrado_por = pp.idpersona
        WHERE ap.idpanne = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idsolicitud]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function obtener_detalle_panne_id($id){
        $sql = "SELECT pan.*, ap.*, pc.tipo_falla as falla_tecnica, pc.accion as accion_tecnica, pc.estado_unidad as unidad_cierre, pc.fecha_cierre, pc.observaciones as observaciones_cierre, pp.nombre, pp.apellido, emp.nombre as empresa, un.ppu
        FROM actividades_solicitud_panne pan
        LEFT JOIN actividad_panne ap ON pan.id = ap.idsolicitud
        LEFT JOIN empresa_profile emp ON pan.idempresa = emp.id
        LEFT JOIN unidades_profile un ON pan.idunidad = un.id
        LEFT JOIN persona_profile pp ON pan.creado_por = pp.idpersona
        LEFT JOIN actividad_panne_cierre pc ON pan.id = pc.idpanne
        WHERE pan.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function obtener_adjuntos_panne($id){
        $sql = "SELECT archivo, idactividad 
        FROM actividad_archivos
        WHERE idactividad = ? AND tipo = 'PANNE'";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    function grabar_actividad_spot($idunidad, $servicios, $ubicacion, $fecha_revision, $hora_agendada, $inspector){
        $fecha_creado = date('Y-m-d H:i:s');
        $sql = "INSERT INTO actividades_solicitud_spot (idunidad, servicios, ubicacion, fecha_programado, hora_agendada, fecha_creado, estado, creado_por) VALUES (?,?,?,?,?,?,?,?)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$idunidad, $servicios, $ubicacion, $fecha_revision, $hora_agendada,  $fecha_creado, 1,$_SESSION['id999822']]);
        $idsolicitud = $this->conexion->lastInsertId();
            if($idsolicitud > 0 && !empty($inspector)){
                $inspector = explode(',', $inspector);
                for ($i=0; $i < count($inspector); $i++) { 
                    $sql = "INSERT INTO asignaciones_inspector (idactividad, tipo, idinspector) VALUES (?,?,?)";
                    $smts = $this->conexion->prepare($sql);
                    $smts->execute([$idsolicitud, 'SPOT', $inspector[$i]]);
                }
            }   
        return $idsolicitud;
    }

    //obtener_spot
    public function obtener_unidades_spot_paginados($estado, $inicio, $registros, $orden){
        $sql = "SELECT sp.id as idspot, sp.estado, sp.idunidad, sp.ubicacion, sp.servicios, sp.fecha_programado, un.idempresa, un.fecha_creado, un.tipo, un.ppu, em.nombre as empresa, GROUP_CONCAT(CONCAT(ins.nombre, ' ', ins.apellido)) as inspectores
        FROM actividades_solicitud_spot sp 
        LEFT JOIN $this->tblcam un ON sp.idunidad = un.id
        LEFT JOIN $this->tblemp em ON un.idempresa = em.id
        LEFT JOIN asignaciones_inspector ai ON sp.id = ai.idactividad AND ai.tipo = 'SPOT'
        LEFT JOIN persona_profile ins ON ai.idinspector = ins.idpersona
        WHERE sp.estado = ?
        GROUP BY sp.id, sp.idunidad, sp.ubicacion, sp.servicios, sp.fecha_creado, sp.fecha_programado, un.idempresa, un.tipo, un.ppu, em.nombre
        ORDER BY sp.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$estado]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function total_spot_ppal(){
        $sql = "SELECT COUNT(*) FROM actividades_solicitud_spot WHERE estado = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $result = $smts->fetchColumn();
        return $result;
    }

    //obtener_spot_fecha
    public function obtener_unidades_spot_fecha_paginados($fechaFin, $inicio, $registros, $orden){
        $fechaInicio = $fechaFin - 1;
        $sql = "SELECT ip.idunidad, ip.ubicacion, ip.idempresa, ip.tipo_servicio, ip.fecha_ultima, un.ppu, un.tipo, un.fecha_creado, em.nombre as empresa
        FROM actividades_solicitud ip
        LEFT JOIN unidades_profile un ON ip.idunidad = un.id
        LEFT JOIN empresa_profile em ON ip.idempresa = em.id
        WHERE ip.fecha_ultima < DATE_SUB(CURDATE(), INTERVAL :fechaInicio MONTH)
        AND ip.fecha_ultima >= DATE_SUB(CURDATE(), INTERVAL :fechaFin MONTH)
        ORDER BY ip.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([':fechaInicio' => $fechaInicio, ':fechaFin' => $fechaFin]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function total_unidades_fecha($fecha){
        $sql = "SELECT COUNT(*) FROM actividades_solicitud WHERE fecha_ultima >= DATE_SUB(CURDATE(), INTERVAL :fecha MONTH)";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([':fecha' => $fecha]);
        $result = $smts->fetchColumn();
        return $result;
    }

    //obtener_spot_todos
    public function obtener_allunidades_spot_paginados($inicio, $registros, $orden){
        $sql = "SELECT un.idempresa, un.id, un.ppu, un.tipo, un.ubicacion, un.fecha_creado, em.nombre as empresa 
        FROM unidades_profile un
        LEFT JOIN empresa_profile em ON un.idempresa = em.id
        ORDER BY un.id $orden
        LIMIT $inicio, $registros";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function total_spot(){
        $sql = "SELECT COUNT(*) FROM actividades_solicitud_spot WHERE estado = 1";
        $smts = $this->conexion->prepare($sql);
        $smts->execute();
        $result = $smts->fetchColumn();
        return $result;
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

    public function obtener_solicitud_spot($id){
        $sql = "SELECT sp.*, ai.id, ins.nombre as insnombre, ins.apellido as insapellido 
        FROM actividades_solicitud_spot sp
        LEFT JOIN asignaciones_inspector ai ON sp.id = ai.idactividad AND ai.tipo = 'SPOT'
        LEFT JOIN persona_profile ins ON ai.idinspector = ins.idpersona
        WHERE sp.id = ?";
        $smts = $this->conexion->prepare($sql);
        $smts->execute([$id]);
        $data = $smts->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
   
}


?>