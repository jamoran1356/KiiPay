<?php
session_start();
require_once '../models/personal.php';


if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];

    if($option=="svemp"){
        if($_POST){
                $nombre = $_POST['empnombre'];
                $apellido = $_POST['empapellidos'];
                $nacimiento = $_POST['empnacimiento'];
                $sexo = $_POST['empsexo'];
                $identificacion = $_POST['empidentificacion'];
                $email = $_POST['empcorreo'];
                $telefono = $_POST['empmovil'];
                $direccion = $_POST['empdireccion'];
                $ciudad = $_POST['empciudad'];
                $ingreso = $_POST['empingreso'];
                $cargo = $_POST['empcargo'];
                $iddepartamento = $_POST['empdepartamento'];
                $password = "123456";
                
                $ismanager = isset($_POST['ismanager']) && $_POST['ismanager'] =='on' ? 1 : 0;
                $tipox = $ismanager == 1 ? "manager" : "empleado";
                $has_access = isset($_POST['hasaccess']) && $_POST['hasaccess'] =='on' ?  1 : 0;

                $tipo = isset($iddepartamento) && $iddepartamento == 19 ? "ambipar" : $tipox;
                

                if (isset($_FILES['imgfile']) && !empty($_FILES['imgfile']['tmp_name'])) {
                    $image = $_FILES['imgfile'];
                    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                    $pic = uniqid('', true) . '.' . $extension;
                    move_uploaded_file($image['tmp_name'], '../assest/images/personal/' . $pic);
                    $imagen = $pic;
                } else {
                    $imagen = 'no-image.webp';
                }

                $nwad = new Empleado ();
                
                $rs = $nwad->setEmpleado($nombre, $apellido, $identificacion, $telefono, $email, $nacimiento, $password, $imagen, $has_access, $tipo, $direccion, $ciudad, $ingreso, $cargo, $ismanager, $iddepartamento);

                //menu
                if($has_access==1){
                    $departamentos = isset($_POST['departamentos']) && $_POST['departamentos'] =='on' ? 1 : 0;
                    $nm = $nwad->save_persona_menu($rs, 'departamentos', $departamentos);
                    $personal = isset($_POST['personal']) && $_POST['personal'] =='on' ? 1 : 0;
                    $nm = $nwad->save_persona_menu($rs, 'personal', $personal);
                    $empresa = isset($_POST['empresa']) && $_POST['empresa'] =='on' ? 1 : 0;
                    $nm = $nwad->save_persona_menu($rs, 'empresa', $empresa);
                    $unidades = isset($_POST['unidades']) && $_POST['unidades'] =='on' ? 1 : 0;
                    $nm = $nwad->save_persona_menu($rs, 'unidades', $unidades);
                    $tallerip = isset($_POST['tallerip']) && $_POST['tallerip'] =='on' ? 1 : 0;
                    $nm = $nwad->save_persona_menu($rs, 'tallerip', $tallerip);
                    $panne = isset($_POST['panne']) && $_POST['panne'] =='on' ? 1 : 0;
                    $nm = $nwad->save_persona_menu($rs, 'panne', $panne);
                }
                


                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="getEmpdo"){
        if($_GET){
            $tbl = new Empleado();
            $tbl = $tbl->contar_empleados();
            $orden = 'ASC';

            $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
            $registros = 10;

            $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
            
            $total_paginas = ceil($tbl/$registros); // Redondear hacia arriba

            $nwad = new Empleado ();
            $rs = $nwad->getempleados_paginado($inicio, $registros, $orden);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                } 
        }
    }

    if($option=="updemp"){
        if($_POST){
                $nwad = new Empleado ();
                
                $id = $_POST['empid'];
                $nombre = $_POST['empnombre'];
                $apellido = $_POST['empapellidos'];
                $nacimiento = $_POST['empnacimiento'];
                $sexo = $_POST['empsexo'];
                $identificacion = $_POST['empidentificacion'];
                $email = $_POST['empcorreo'];
                $telefono = $_POST['empmovil'];
                $direccion = $_POST['empdireccion'];
                $ciudad = $_POST['empciudad'];
                $ingreso = $_POST['empingreso'];
                $cargo = $_POST['empcargo'];
                $iddepartamento = $_POST['empdepartamento'];
                $tipo = "empleado";
                $ismanager = isset($_POST['ismanager']) && $_POST['ismanager'] =='on' ? 1 : 0;
                $has_access = isset($_POST['hasaccess']) && $_POST['hasaccess'] =='on' ?  1 : 0;

                //menu
                $pagos = isset($_POST['pagos']) && $_POST['pagos'] =='on' ? 1 : 0;
                $departamentos = isset($_POST['departamentos']) && $_POST['departamentos'] =='on' ? 1 : 0;
                $personal = isset($_POST['personal']) && $_POST['personal'] =='on' ? 1 : 0;
                $iconos = isset($_POST['iconos']) && $_POST['iconos'] =='on' ? 1 : 0;
                $feedback = isset($_POST['feedback']) && $_POST['feedback'] =='on' ? 1 : 0;
                $desarrollo = isset($_POST['desarrollo']) && $_POST['desarrollo'] =='on' ? 1 : 0;
                $tickets = isset($_POST['tickets']) && $_POST['tickets'] =='on' ? 1 : 0;
                $planes = isset($_POST['planes']) && $_POST['planes'] =='on' ? 1 : 0;
                $clientes = isset($_POST['clientes']) && $_POST['clientes'] =='on' ? 1 : 0;


                if (isset($_FILES['imgfile']) && !empty($_FILES['imgfile']['tmp_name'])) {
                    $image = $_FILES['imgfile'];
                    $compare = $nwad->verificar_imagen($image['name'], $id);
                    if($compare==1){
                        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                        $pic = uniqid('', true) . '.' . $extension;
                        move_uploaded_file($image['tmp_name'], '../assest/images/personal/' . $pic);
                        $imagen = $pic;
                    } 
                    if($compare==0){
                        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                        $pic = uniqid('', true) . '.' . $extension;
                        move_uploaded_file($image['tmp_name'], '../assest/images/personal/' . $pic);
                        $imagen = $pic;
                    }
                    if($compare==2){
                        $imagen = 'error borrando imagen';
                    }
                } else {
                    $imagen = 'no-image.webp';
                }
                
                
                $rs = $nwad->updEmpleado($id, $nombre, $apellido, $identificacion, $sexo,  $telefono, $email, $nacimiento,  $imagen,  $has_access, $direccion, $ciudad, $tipo, $ingreso, $cargo, $ismanager, $iddepartamento,  $pagos, $departamentos, $personal, $iconos, $feedback, $desarrollo, $tickets, $planes, $clientes);
                if ($rs>0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
        }

    }


    if($option=="dltempleado"){
        if($_POST){
                $id = $_POST['id'];
                $nwad = new Empleado ();
                $rs = $nwad->del_empleado($id, $_SESSION['id999822']);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="totalemp"){
        if($_GET){
                $nwad = new Empleado ();
                $rs = $nwad->contar_empleados();
                    $arrResp = array('status' => true, 'msg' => "OK", 'data'=>$rs); 
                    echo json_encode($arrResp);
        }

    }

    if($option=="getEmpById"){
        if($_POST){
                $id = $_POST['id'];
                $nwad = new Empleado ();
                $rs = $nwad->getEmpId($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data'=>$rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="getAdmProfile"){
        if($_GET){
            $nwad = new Empleado ();
            $rs = $nwad->getAdminProfile();
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option == 'updacct'){
        if($_POST){
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $identificacion = $_POST['identificacion'];
            $email = $_POST['correo'];
            $telefono = $_POST['movil'];
            $direccion = $_POST['direccion'];
            $ciudad = $_POST['ciudad'];
            $pais = $_POST['pais'];
            $codigo = $_POST['postal'];
            
            $nwad = new Empleado ();
            $rs = $nwad->updateProfile($_SESSION['id999822'], $nombre, $apellido, $identificacion, $email, $telefono, $direccion, $ciudad, $pais, $codigo);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }
    }

    if($option=="getpaises"){
        if($_GET){
            $nwad = new Empleado ();
            $rs = $nwad->select_paises();
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="changepass"){
        $np = new Empleado();
        $id = $_SESSION['id999822'];
        $clave_actual = $_POST['clave_actual'];
        $nueva_clave1 = $_POST['nueva_clave1'];

        $rs = $np->changepass($id, $clave_actual, $nueva_clave1);
        if($rs>0){
            $arrResp = array('status' => true, 'msg' => "La clave ha sido actualizada correctamente"); 
        } else {
            $arrResp = array('status' => false, 'msg' => "Error al actualizar la clave"); 
        }
        echo json_encode($arrResp);
    }

    if($option=='gtempbydpt'){
        if($_POST){
            $txt = $_POST['txtbuscar'];
            $nwad = new Empleado ();
            $rs = $nwad->getempleados(16, $txt);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'data' => $rs); 
                } else {
                    $arrResp = array('status' => false, 'data' => 0); 
                }
                echo json_encode($arrResp);
        }
    }

    

}


?>