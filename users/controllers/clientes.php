<?php
session_start();
require_once '../models/clientes.php';

if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];

    switch($option){
        case 'getclpg':
            if($_POST){
                $tbl = new Clientes();
                $ts = $tbl->total_registros();
                $orden = 'ASC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->obtener_clientes_paginados($inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                    echo json_encode($arrResp);
            }
        break;   
        
        case 'getnumcl':
            if($_GET){
                $tbl = new Clientes();
                $rs = $tbl->total_registros();
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'data' => 0); 
                } 
                echo json_encode($arrResp);
            }
        break;  

        case 'svcl':
            if($_POST){
                $cl = new Clientes();
                $nombre = isset($_POST['empnombre']) ? $_POST['empnombre'] : '';
                $nif = isset($_POST['empNIF']) ? $_POST['empNIF'] : '';
                $email = isset($_POST['empcorreo']) ? $_POST['empcorreo'] : '';
                $telefono = isset($_POST['movil']) ? $_POST['movil'] : '';
                $direccion = isset($_POST['empdireccion']) ? $_POST['empdireccion'] : '';
                $web = isset($_POST['empwebsite']) ? $_POST['empwebsite'] : '';
                $ciudad = isset($_POST['empciudad']) ? $_POST['empciudad'] : '';
                $provincia = isset($_POST['empprovincia']) ? $_POST['empprovincia'] : '';
                
                if (isset($_FILES['image'])) {
                    $imagen = $_FILES['image'];
                    if ($imagen['error'] !== UPLOAD_ERR_OK) {
                        die("Error al cargar la imagen: " . $imagen['error']);
                    }
                    $nombreImagen = uniqid() . '.png';
                    $directorioImagenes = '../assest/images/clientes/';
                    if (!file_exists($directorioImagenes)) {
                        mkdir($directorioImagenes, 0777, true);
                    }
                    $rutaImagen = $directorioImagenes . $nombreImagen;
                    if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                        die("Error al mover la imagen al directorio de imágenes");
                    }
                    $imagen = 'assest/images/clientes/' . $nombreImagen;
                } else {
                    $imagen = 'assest/images/no-image.webp';
                }

                $rs = $cl->guardar_cliente($nombre, $nif, $email, $telefono, $direccion, $web, $ciudad, $provincia, $imagen);
                if ($rs) {
                    $arrResp = array('status' => true, 'msg' => "La empresa ha sido almacenada de forma exitosa"); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error al almacenar la empresa"); 
                }
                echo json_encode($arrResp);
            }
        break; 


        case 'updtcl':
            if($_POST){
                $cl = new Clientes();
                $idempresa = isset($_POST['idempresa']) ? $_POST['idempresa'] : '';
                $nombre = isset($_POST['empnombre']) ? $_POST['empnombre'] : '';
                $nif = isset($_POST['empNIF']) ? $_POST['empNIF'] : '';
                $email = isset($_POST['empcorreo']) ? $_POST['empcorreo'] : '';
                $telefono = isset($_POST['movil']) ? $_POST['movil'] : '';
                $direccion = isset($_POST['empdireccion']) ? $_POST['empdireccion'] : '';
                $web = isset($_POST['empwebsite']) ? $_POST['empwebsite'] : '';
                $ciudad = isset($_POST['empciudad']) ? $_POST['empciudad'] : '';
                $provincia = isset($_POST['empprovincia']) ? $_POST['empprovincia'] : '';
                
                if (isset($_FILES['image'])) {
                    $dlt = $cl->borrar_imagen_empresa($idempresa);
                    $imagen = $_FILES['image'];
                    if ($imagen['error'] !== UPLOAD_ERR_OK) {
                        die("Error al cargar la imagen: " . $imagen['error']);
                    }
                    $nombreImagen = uniqid() . '.png';
                    $directorioImagenes = '../assest/images/clientes/';
                    if (!file_exists($directorioImagenes)) {
                        mkdir($directorioImagenes, 0777, true);
                    }
                    $rutaImagen = $directorioImagenes . $nombreImagen;
                    if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                        die("Error al mover la imagen al directorio de imágenes");
                    }
                    $imagen = 'assest/images/clientes/' . $nombreImagen;
                } else {
                    $imagen = 'assest/images/no-image.webp';
                }

                $rs = $cl->actualizar_cliente($idempresa, $nombre, $nif, $email, $telefono, $direccion, $web, $ciudad, $provincia, $imagen);
                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => "La empresa ha sido actualizada de forma exitosa"); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error al actualizar la empresa"); 
                }
                echo json_encode($arrResp);
            }
        break; 

        case 'delclt':
            if($_GET){
                $cl = new Clientes();
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $rs = $cl->borrar_cliente($id);
                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => 'La empresa ha sido eliminada de forma exitosa'); 
                } else {
                    $arrResp = array('status' => false, 'msg' => 'Error al eliminar la empresa'); 
                } 
                echo json_encode($arrResp);
            }
        break; 

        case 'delund':
            if($_GET){
                $cl = new Clientes();
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $rs = $cl->borrar_unidad($id);
                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => 'La unidad ha sido eliminada de forma exitosa'); 
                } else {
                    $arrResp = array('status' => false, 'msg' => 'Error al eliminar la unidad'); 
                } 
                echo json_encode($arrResp);
            }
        break; 

        case 'clist':
            if($_GET){
                $cl = new Clientes();
                $busqueda = isset($_POST['txtbuscar']) ? $_POST['txtbuscar'] : "";
                $rs = $cl->obtener_lista($busqueda);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "No hay unidades para mostrar"); 
                } 
                echo json_encode($arrResp);
            }
        break; 

        case 'gallunits':
            if($_GET){
                $cl = new Clientes();
                $rs = $cl->total_unidades();
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'data' => 0); 
                } 
                echo json_encode($arrResp);
            }
        break;    

        case 'galleunits':
            if($_POST){
                $cl = new Clientes();
                $idempresa = isset($_POST['id']) ? $_POST['id'] : 0;
                
                $rs = $cl->total_unidades_emp($idempresa);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs,); 
                } else {
                    $arrResp = array('status' => false, 'data' => 0); 
                } 
                echo json_encode($arrResp);
            }
        break;    

        case 'lunds':
            if($_POST){
                $tbl = new Clientes();
                $ts = $tbl->total_unidades();
                $orden = 'ASC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 10;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $tbl->obtener_unidades_paginados($inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    } 
                    echo json_encode($arrResp);
            }
        break; 
        
        case 'svunds':
            if($_POST){
                $idempresa = isset($_POST['idpcnombre']) ? $_POST['idpcnombre'] : 0;
                $ppu_tracto = isset($_POST['ppu_tracto']) ? $_POST['ppu_tracto'] : '';
                $ppu_semi = isset($_POST['ppu_semi']) ? $_POST['ppu_semi'] : '';
                $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
                $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
                $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
                $year = isset($_POST['year']) ? $_POST['year'] : '';
                $chasis = isset($_POST['chasis']) ? $_POST['chasis'] : '';
                $ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : '';
                $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
                $km_actual = isset($_POST['km_actual']) ? $_POST['km_actual'] : '';
                $km_proximo = isset($_POST['km_proximo']) ? $_POST['km_proximo'] : '';
                $cl = new Clientes();
                $rs = $cl->guardar_unidades($idempresa, $ppu_tracto, $ppu_semi, $tipo, $marca, $modelo, $year, $km_actual, $km_proximo, $chasis, $ubicacion, $estatus);

                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => "La unidad ha sido almacenada de forma exitosa"); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error al almacenar la unidad"); 
                }
                echo json_encode($arrResp);
            }
        break; 
        
        case 'upunds':
            if($_POST){
                $idunidad = isset($_POST['idund']) ? $_POST['idund'] : 0;
                $idempresa = isset($_POST['idpcnombre']) ? $_POST['idpcnombre'] : 0;
                $ppu_tracto = isset($_POST['ppu_tracto']) ? $_POST['ppu_tracto'] : '';
                $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
                $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
                $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
                $year = isset($_POST['year']) ? $_POST['year'] : '';
                $chasis = isset($_POST['chasis']) ? $_POST['chasis'] : '';
                $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
                $ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : '';
                $km_actual = isset($_POST['km_actual']) ? $_POST['km_actual'] : '';
                $km_proximo = isset($_POST['km_proximo']) ? $_POST['km_proximo'] : '';
                $cl = new Clientes();
                $rs = $cl->actualizar_unidades($idunidad, $idempresa, $ppu_tracto, $tipo, $marca, $modelo, $year, $chasis,$estatus, $ubicacion, $km_actual, $km_proximo);
                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => "La unidad ha sido actualizada de forma exitosa"); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "Error al actualizar la unidad"); 
                }
                echo json_encode($arrResp);
            }
        break; 
        
        case 'lundsemp':
            if($_POST){
                $cl = new Clientes();
                $idempresa = isset($_POST['idempresa']) ? $_POST['idempresa'] : 0;
                $ts = $cl->total_unidades_emp($idempresa);
                $nombre_empresa = $cl->obtener_empresa($idempresa);
                $orden = 'ASC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 25;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $cl->obtener_unidades_emp_paginados($idempresa, $inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas, 'nombre_empresa' => $nombre_empresa); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "No hay datos para mostrar", 'nombre_empresa' => $nombre_empresa); 
                    } 
                    echo json_encode($arrResp);
            }
        break; 

        case 'getspot':
            if($_POST){
                $cl = new Clientes();
                $ts = $cl->total_unidades();
                $orden = 'ASC';
                $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
                $registros = 25;
                $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
                $total_paginas = ceil($ts/$registros); // Redondear hacia arriba
                $rs = $cl->obtener_unidades_spot_paginados($inicio, $registros, $orden);
                    if (!empty($rs)) {
                        $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    } else {
                        $arrResp = array('status' => false, 'msg' => "No hay datos para mostrar"); 
                    } 
                    echo json_encode($arrResp);
            }
        break; 

        case 'getcltbyid':
            if($_POST){
                $cl = new Clientes();
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $rs = $cl->obtener_cliente($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false); 
                } 
                echo json_encode($arrResp);
            }
        break;  
        
        case 'undbyidem':
            if($_POST){
                $cl = new Clientes();
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $rs = $cl->obtener_unidades_emp($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "No hay unidades para mostrar"); 
                } 
                echo json_encode($arrResp);
            }
        break;    

        case 'undbyid':
            if($_POST){
                $cl = new Clientes();
                $id = isset($_POST['id']) ? $_POST['id'] : 0;
                $rs = $cl->obtener_unidades($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false); 
                } 
                echo json_encode($arrResp);
            }
        break;    

        

        case 'undbyppu':
            if($_POST){
                $cl = new Clientes();
                $id = isset($_POST['idund']) ? $_POST['idund'] : '';
                $rs = $cl->obtener_unidades_id($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false); 
                } 
                echo json_encode($arrResp);
            }
        break;

        case 'undhistoryid':
            if($_POST){
                $cl = new Clientes();
                $id = isset($_POST['idund']) ? $_POST['idund'] : '';
                $rs = $cl->obtener_historial_unidad($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false); 
                } 
                echo json_encode($arrResp);
            }
        break;
        
        case 'importunidades':
            if($_POST){
                if (isset($_FILES['file'])) {
                    $excel = $_FILES['file'];
                    if ($excel['error'] !== UPLOAD_ERR_OK) {
                        die("Error al cargar el archivo: " . $excel['error']);
                    }
                    $nombrearchivo = uniqid() . '.xlsx';
                    $directorioImport = '../assest/documentos/uploads/';
                    if (!file_exists($directorioImport)) {
                        mkdir($directorioImport, 0777, true);
                    }
                    $rutaImport = $directorioImport . $nombrearchivo;
                    if (!move_uploaded_file($excel['tmp_name'], $rutaImport)) {
                        die("Error al mover el archivo al directorio de documentos");
                    }
                    $archivo = '../assest/documentos/uploads/' . $nombrearchivo;
                    $cl = new Clientes();
                    $rs = $cl->importar_unidades($archivo);
                    
                    if ($rs['total']>0) {
                        $arrResp = array('status' => true, 'msg' => "El archivo ha sido importado de forma exitosa"); 
                        unlink($archivo);
                    } 
                    if($rs=='E01'){
                        $arrResp = array('status' => false, 'msg' => "Error al importar el archivo, la empresa no está registrada en el sistema"); 
                        unlink($archivo);
                    }
                    echo json_encode($arrResp);
                }
            }
        break;  

        case 'srchcompany':
            if($_POST){
                $cl = new Clientes();
                $busqueda = isset($_POST['txtbuscar']) ? $_POST['txtbuscar'] : "";
                $rs = $cl->busqueda_clientes_($busqueda);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "No hay empresas para mostrar"); 
                } 
                echo json_encode($arrResp);
            }
        break;
        
        case 'srchunds':
            if($_POST){
                $cl = new Clientes();
                $id = isset($_POST['idcomp']) ? $_POST['idcomp'] : 0;
                $busqueda = isset($_POST['txtbuscar']) ? $_POST['txtbuscar'] : "";
                $rs = $cl->buscar_unidades_emp_paginados($busqueda, $id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "No hay unidades para mostrar"); 
                } 
                echo json_encode($arrResp);
            }
        break;    

        case 'bulkund':
            if($_POST){
                $empresa = isset($_POST['empresa']) ? $_POST['empresa'] : "";
                $ppu_tracto = isset($_POST['patente']) ? $_POST['patente'] : '';
                $ppu_semi = isset($_POST['ppu_semi']) ? $_POST['ppu_semi'] : '';
                $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
                $marca = isset($_POST['marca']) ? $_POST['marca'] : '';
                $modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';
                $year = isset($_POST['year']) ? $_POST['year'] : '';
                $chasis = isset($_POST['chasis']) ? $_POST['chasis'] : '';
                $ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : '';
                $estatus = isset($_POST['estatus']) ? $_POST['estatus'] : '';
                $km_actual = isset($_POST['km_actual']) ? $_POST['km_actual'] : '';
                $km_proximo = isset($_POST['km_proximo']) ? $_POST['km_proximo'] : '';
                $cl = new Clientes();
                $rs = $cl->guardar_unidades_bulk($empresa, $ppu_tracto, $ppu_semi, $tipo, $marca, $modelo, $year, $km_actual, $km_proximo, $chasis, $ubicacion, $estatus);
                if ($rs>0) {
                    $arrResp = array('status' => true); 
                } 
                if($rs=='E01'){
                    $arrResp = array('status' => false, 'msg' => "$empresa no está registrada en el sistema"); 
                } 
                if($rs=='E02'){
                    $arrResp = array('status' => false, 'msg' => "La unidad ya esta registrada"); 
                }
                echo json_encode($arrResp);
            }
        break;

    }

}



?>