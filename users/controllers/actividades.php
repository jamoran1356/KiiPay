<?php
session_start();
ob_start();
require_once '../models/actividades.php';

if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];

    switch ($option) {
        case 'crtact':
            if($_POST){
                //datos de la actividad
                $idempresa = $_POST['idpcnombre'];
                $idunidad = $_POST['ppu_semi'];
                $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : 'IP';
                $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : 'IP';
                $km_actual = $_POST['km_actual'];
                $km_ultima = $_POST['km_ultima'];
                $fecha_ultima = $_POST['fecha_ultima'];
                $servicio = $_POST['servicio'];
                $taller = $_POST['taller'];
                $ubicacion = $_POST['ubicacion'];
                $observaciones = $_POST['observaciones'];
                $nwad = new Actividad ();
                $rs = $nwad->grabar_solicitud($idempresa, $idunidad, $km_actual, $km_ultima, $fecha_ultima, $tipo, $servicio, $taller, $ubicacion, $observaciones, $estatus);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha creado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error creando la actividad"); 
                }
                if($rs == 'E01'){
                    $arrResp = array('status' => false, 'msg' => "Esta solicitud ya tiene una actividad creada"); 
                }
                echo json_encode($arrResp);
            }
        break;  

        case 'crtasg':
            if($_POST){
                //datos de la actividad
                $idsol = $_POST['idsol'];
                $fecha_revision = $_POST['fecha_agendada'];
                $hora = $_POST['hora_agendada'];
                $semana = $_POST['semana'];
                $solicitado_por = $_POST['solicitado'];
                $autorizado_por = $_POST['aprobado_por'];
                $inspector = $_POST['idinspector'];
                $inspector = rtrim($inspector, ",");
                $nwad = new Actividad ();
                $rs = $nwad->grabar_actividad_ip($idsol, $fecha_revision, $hora, $semana,  $solicitado_por, $autorizado_por, $inspector);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha creado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error creando la actividad"); 
                }
                echo json_encode($arrResp);
            }
        break;  

        case 'getip':
            if($_POST){
                $tbl = new Actividad();
                $ts = $tbl->total_registros_solicitudes();
                $orden = 'DESC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $comparacion = isset($_POST['comp']) ? $_POST['comp'] : '!=';
                $valor = isset($_POST['vlr']) ? $_POST['vlr'] : 3;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->listado_solicitudes_paginado($inicio, $registros, $orden, $comparacion, $valor);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                    ob_end_clean();
                    echo json_encode($arrResp);
            }
        break; 

        case 'getregsol':
            if($_GET){
                $rs = new Actividad();
                $rs = $rs->total_registros_solicitudes();
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'data' => 0); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;    
        
        case 'getinsp':
            if($_POST){
                $tbl = new Actividad();
                $idusuario = $_SESSION['id999822'];
                $ts = $tbl->total_registros_insp($idusuario);
                $orden = 'ASC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->listado_actividades_paginado_insp($idusuario, $inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                    ob_end_clean();
                    echo json_encode($arrResp);
            }
        break; 
        
        case 'delip':
            if($_POST){
                $idactividad = $_POST['id'];
                $tbl = new Actividad();
                $rs = $tbl->borrar_actividad($idactividad);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha eliminado la solicitud correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error eliminando la solicitud, hay actividades asociadas"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        case 'getipbyid':
            if($_POST){
                $idactividad = $_POST['id'];
                $tbl = new Actividad();
                $rs = $tbl->get_actividad_by_id($idactividad);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                } 
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        case 'svactrv':
            if($_POST){
                $idactividad = $_POST['idtr'];
                $estado_actividad = $_POST['estado_solicitud'];
                $fecha_actividad = $_POST['trfecha_programada'];
                $hora_actividad = $_POST['trhora_programada'];
                $idinspector = $_POST['idtrinspector'];
                $tr = new Actividad();
                $rx = $tr->asignar_actividades($idactividad, $idinspector);
                $rs = $tr->crear_actualizaciones($idactividad, $estado_actividad, $estado_actividad, $estado_actividad, $estado_actividad, $estado_actividad, $estado_actividad, $fecha_actividad, $hora_actividad);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha actualizado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error actualizando la actividad"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);

            }
        break;
        
        case 'getsolbyid':
            if($_POST){
                $idsolicitud = $_POST['id'];
                $tbl = new Actividad();
                $rs = $tbl->obtener_solicitud_basica_id($idsolicitud);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;
        
        case 'getsobyid':
            if($_POST){
                $idsolicitud = $_POST['id'];
                $tbl = new Actividad();
                $rs = $tbl->obtener_solicitud_id($idsolicitud);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        case 'bsqip':
            if($_POST){
                $txtbusqueda = $_POST['txtbuscar'];
                $comparacion = (isset($_POST['comp']) && $_POST['comp'] !== '') ? $_POST['comp'] : '!=';
                $valor = 3;
                $tbl = new Actividad();
                $rs = $tbl->listado_solicitudes_busqueda($txtbusqueda, $comparacion, $valor);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;
        
        case 'getactinsp':
            if($_POST){
                $tbl = new Actividad();
                $ts = $tbl->total_registros_actividades_insp();
                $orden = 'DESC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->listado_solicitudes_inspectores($inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;    

        case 'gttlasg':
            if($_GET){
                $tbl = new Actividad();
                $ts = $tbl->total_registros_actividades_insp();
                if(!empty($ts)){
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $ts); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;   

        case 'svupdtactip':
            if($_POST){
                $idsolicitud = $_POST['rpidsol'];
                $fecha_realizado = $_POST['ip_fecha_inicio'];
                $hora_ralizado = $_POST['ip_hora_inicio'];
                $realizo = $_POST['ip_superviso'];
                $motivo = $_POST['ip_motivo'];
                $estado_unidad = $_POST['ip_edo_unidad'];
                $observaciones = $_POST['ip_texto'];
                $tipo = 'IP';
                $tbl = new Actividad();
                $rs = $tbl->guardar_avance($idsolicitud, $fecha_realizado, $hora_ralizado, $realizo, $motivo, $estado_unidad, $observaciones);

                // Procesar los archivos adjuntos
                $total = count($_FILES['ip_files']['name']);
                for ($i = 0; $i < $total; $i++) {
                    $archivo = $_FILES['ip_files']['tmp_name'][$i];
                    if ($archivo != "") {
                        // Mover el archivo a la carpeta de destino
                        $carpeta_destino = "../assest/clientes/IP/" . $idsolicitud . "/";
                        if (!file_exists($carpeta_destino)) {
                            mkdir($carpeta_destino, 0777, true);
                        }
                        $extension = pathinfo($_FILES['ip_files']['name'][$i], PATHINFO_EXTENSION);
                        $nombre_unico = uniqid() . '.' . $extension;
                        $destino = $carpeta_destino . $nombre_unico;
                        if (move_uploaded_file($archivo, $destino)) {
                            $tbl->guardar_archivos_actividad($rs, $tipo, $nombre_unico);
                        } else {
                            $arrResp = array('status' => false, 'msg' => "Error al subir el archivo");
                        }
                    }
                }
                $rs = 1;
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha actualizado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error actualizando la actividad"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;
        
        
        case 'svupdtactspot':
            if($_POST){
                $idsolicitud = $_POST['idsol'];
                $fecha_realizado = $_POST['spot_fecha_inicio'];
                $hora_ralizado = $_POST['spot_hora_inicio'];
                $realizo = $_POST['spot_superviso'];
                $motivo = $_POST['spot_motivo'];
                $estado_unidad = $_POST['spot_edo_unidad'];
                $observaciones = $_POST['spot_texto'];
                $tipo = 'SPOT';
                $tbl = new Actividad();
                $rs = $tbl->guardar_avance_spot($idsolicitud, $fecha_realizado, $hora_ralizado, $realizo, $motivo, $estado_unidad, $observaciones);

                // Procesar los archivos adjuntos
                $total = count($_FILES['spot_files']['name']);
                for ($i = 0; $i < $total; $i++) {
                    $archivo = $_FILES['spot_files']['tmp_name'][$i];
                    if ($archivo != "") {
                        // Mover el archivo a la carpeta de destino
                        $carpeta_destino = "../assest/clientes/SPOT/" . $idsolicitud . "/";
                        if (!file_exists($carpeta_destino)) {
                            mkdir($carpeta_destino, 0777, true);
                        }
                        $extension = pathinfo($_FILES['spot_files']['name'][$i], PATHINFO_EXTENSION);
                        $nombre_unico = uniqid() . '.' . $extension;
                        $destino = $carpeta_destino . $nombre_unico;
                        if (move_uploaded_file($archivo, $destino)) {
                            $tbl->guardar_archivos_actividad($rs, $tipo, $nombre_unico);
                        } else {
                            $arrResp = array('status' => false, 'msg' => "Error al subir el archivo");
                        }
                    }
                }
                $rs = 1;
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha actualizado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error actualizando la actividad"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

       
        

        case 'gtodactip':
            if($_POST){
                $id = $_POST['id'];
                $rs = new Actividad();
                $rs = $rs->mostrar_actualizaciones($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;   
        
        case 'svcloseip':
            if($_POST){
                $id = $_POST['cl_idsol'];
                $estado_unidad = $_POST['cl_edo_unidad'];
                $observaciones = $_POST['cl_observaciones'];
                $motivo = $_POST['cl_motivo'];

                $tbl = new Actividad();
                $rs = $tbl->cerrar_actividad($id, $estado_unidad, $observaciones, $motivo);
                
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha cerrado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error cerrando la actividad"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        //close spot
        case 'svclspot':
            if($_POST){
                $idunidad = $_POST['idunidad'];
                $idempresa = $_POST['idempresa'];
                $idsolicitud = $_POST['idsol'];
                $estado_unidad = $_POST['clsp_edo_unidad'];
                $observaciones = $_POST['clsp_observaciones'];
                $motivo = $_POST['clsp_motivo'];

                $tbl = new Actividad();
                $rs = $tbl->cerrar_actividad_spot($idsolicitud, $idempresa, $idunidad, $estado_unidad, $observaciones, $motivo);
                
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha cerrado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error cerrando la actividad"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;
        
        //Comienzo panne

        case 'svpanne':
            if($_POST){

                $idempresa = $_POST['idpcnombre'];
                $idunidad = $_POST['ppu_semi'];
                $ppu_semi = $_POST['ppu_semirremolque'];
                $fecha = $_POST['fecha'];
                $hora = $_POST['hora'];
                $servicio = $_POST['servicio'];
                $tipo_falla = $_POST['tipofalla'];
                $km_tracto = $_POST['km_actual_und'];
                $km_semi = $_POST['km_actual_semi'];
                $transportista = $_POST['transportista'];
                $supervisor = $_POST['supervisor'];
                $ubicacion = $_POST['ubicacion'];
                $falla_preliminar = $_POST['falla_preliminar'];
                $estado_unidad = 'DESMOVILIZADA';
                

                $nwad = new Actividad ();
                $rs = $nwad->grabar_panne($idempresa, $idunidad, $ppu_semi, $fecha, $hora, $tipo_falla, $km_tracto, $km_semi, $transportista, $supervisor, $ubicacion, $falla_preliminar, $estado_unidad, $servicio);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha creado el panne correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error creando el panne"); 
                }
                if($rs == 'E01'){
                    $arrResp = array('status' => false, 'msg' => "Esta solicitud ya tiene un panne creado"); 
                }
                echo json_encode($arrResp);




            }
        break;    

        case 'svpanne__act':
            if($_POST){
                $idsolicitud = $_POST['idsolpanne'];
                $falla = $_POST['pn_falla'];
                $causa = $_POST['pn_causa'];
                $accion = $_POST['pn_accion'];
                $observaciones = $_POST['pn_observaciones'];
                $tipo = 'PANNE';
                $tbl = new Actividad();
                $rs = $tbl->grabar_actividad_panne($idsolicitud, $falla, $causa, $accion, $observaciones);

                // Procesar los archivos adjuntos
                $total = count($_FILES['panne_files']['name']);
                for ($i = 0; $i < $total; $i++) {
                    $archivo = $_FILES['panne_files']['tmp_name'][$i];
                    if ($archivo != "") {
                        // Mover el archivo a la carpeta de destino
                        $carpeta_destino = "../assest/clientes/panne/" . $idsolicitud . "/";
                        if (!file_exists($carpeta_destino)) {
                            mkdir($carpeta_destino, 0777, true);
                        }
                        $extension = pathinfo($_FILES['panne_files']['name'][$i], PATHINFO_EXTENSION);
                        $nombre_unico = uniqid() . '.' . $extension;
                        $destino = $carpeta_destino . $nombre_unico;
                        if (move_uploaded_file($archivo, $destino)) {
                            $tbl->guardar_archivos_actividad($rs, $tipo, $nombre_unico);
                        } else {
                            $arrResp = array('status' => false, 'msg' => "Error al subir el archivo");
                        }
                    }
                }
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha actualizado el panne correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error actualizando el panne"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;  

        case 'getpanne':
            if($_POST){
                $tbl = new Actividad();
                $ts = $tbl->total_registros_panne();
                $orden = 'DESC';
                $comparacion = isset($_POST['comp']) ? $_POST['comp'] : '!=';
                $valor = isset($_POST['vlr']) ? $_POST['vlr'] : 3;
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->listado_paginado_panne($inicio, $registros, $orden, $comparacion, $valor);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                    ob_end_clean();
                    echo json_encode($arrResp);
            }
        break; 

        case 'ambgetpanne':
            if($_POST){
                $tbl = new Actividad();
                $ts = $tbl->total_registros_panne_ambipar();
                $orden = 'DESC';
                $comparacion = isset($_POST['comp']) ? $_POST['comp'] : '!=';
                $valor = isset($_POST['vlr']) ? $_POST['vlr'] : 3;
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->listado_paginado_panne_ambipar($inicio, $registros, $orden, $comparacion, $valor);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                    ob_end_clean();
                    echo json_encode($arrResp);
            }
        break; 

        

        case 'gtpanid':
            if($_POST){
                $id = $_POST['id'];
                $tbl = new Actividad();
                $rs = $tbl->mostrar_panne($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;
        
        case 'shpnne':
            if($_POST){
                $id = $_POST['id'];
                $tbl = new Actividad();
                $rs = $tbl->mostrar_actividades_panne($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;
       
        
        case 'svclosepanne':
            if($_POST){
                $idsolicitud = $_POST['idsolp'];
                $falla = $_POST['lb_falla'];
                $accion = $_POST['lb_accion'];
                $observaciones = $_POST['lb_observaciones'];
                $estado_unidad = $_POST['lb_unidad'];
                $tipo = 'PANNE';
                $tbl = new Actividad();
                $rs = $tbl->cerrar_actividad_panne($idsolicitud, $falla, $accion, $estado_unidad, $observaciones);


                $total = count($_FILES['lb_files']['name']);
                for ($i = 0; $i < $total; $i++) {
                    $archivo = $_FILES['lb_files']['tmp_name'][$i];
                    if ($archivo != "") {
                        // Mover el archivo a la carpeta de destino
                        $carpeta_destino = "../assest/clientes/panne/" . $idsolicitud . "/";
                        if (!file_exists($carpeta_destino)) {
                            mkdir($carpeta_destino, 0777, true);
                        }
                        $extension = pathinfo($_FILES['lb_files']['name'][$i], PATHINFO_EXTENSION);
                        $nombre_unico = uniqid() . '.' . $extension;
                        $destino = $carpeta_destino . $nombre_unico;
                        if (move_uploaded_file($archivo, $destino)) {
                            $tbl->guardar_adjuntos_cierre_panne($rs, $tipo, $nombre_unico);
                        } else {
                            $arrResp = array('status' => false, 'msg' => "Error al subir el archivo");
                        }
                    }
                }

                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha cerrado la actividad correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error cerrando la actividad"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        case 'bsqpanne':
            if($_POST){
                $txtbusqueda = $_POST['txtbuscar'];
                $comparacion = (isset($_POST['comp']) && $_POST['comp'] !== '') ? $_POST['comp'] : '!=';
                $valor = 3;
                $tbl = new Actividad();
                $rs = $tbl->listado_panne_busqueda($txtbusqueda, $comparacion, $valor);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        case 'ambbsqpanne':
            if($_POST){
                $txtbusqueda = $_POST['txtbuscar'];
                $comparacion = (isset($_POST['comp']) && $_POST['comp'] !== '') ? $_POST['comp'] : '!=';
                $valor = 3;
                $tbl = new Actividad();
                $rs = $tbl->listado_panne_busqueda_ambipar($txtbusqueda, $comparacion, $valor);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO DATOS"); 
                }
                ob_end_clean();
                echo json_encode($arrResp);
            }
        break;

        case 'svspot':
            if($_POST){
                //datos de la actividad
                $idunidad = $_POST['idunidad'];
                $servicios = $_POST['servicios'];
                $ubicacion = $_POST['ubicacion'];
                $fecha_revision = $_POST['fecha_revision'];
                $hora_agendada = $_POST['hora_agendada'];
                $idinspector = $_POST['idinspector'];
                $inspector = rtrim($idinspector, ",");
                $nwad = new Actividad ();
                $rs = $nwad->grabar_actividad_spot($idunidad, $servicios, $ubicacion, $fecha_revision, $hora_agendada, $inspector);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "Se ha creado el spot correctamente");
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error creando la solicitud de spot"); 
                }
                echo json_encode($arrResp);
            }
        break;

        //obtener_spot_todos    
        case 'getspotunits':
            if($_POST){
                $cl = new Actividad();
                $ts = $cl->total_spot();
                $orden = 'DESC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 25;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $cl->obtener_allunidades_spot_paginados($inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "No hay datos para mostrar"); 
                    } 
                    echo json_encode($arrResp);
            }
        break; 

        case 'getspotdate':
            if($_POST){
                $cl = new Actividad();
                $fecha = isset($_POST['fecha']) ? (int)$_POST['fecha'] : 1;
                $ts = $cl->total_unidades_fecha($fecha);
                $orden = 'DESC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 25;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $cl->obtener_unidades_spot_fecha_paginados($fecha, $inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "No hay datos para mostrar"); 
                    } 
                    echo json_encode($arrResp);
            }
        break; 

        case 'getspot':
            if($_POST){
                $cl = new Actividad();
                $fecha = isset($_POST['fecha']) ? (int)$_POST['fecha'] : 1;
                $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 1;
                $ts = $cl->total_spot_ppal();
                $orden = 'DESC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 25;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $cl->obtener_unidades_spot_paginados($estado, $inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "No hay datos para mostrar"); 
                    } 
                    echo json_encode($arrResp);
            }
        break; 

    }    
}

?>