<?php 
session_start();
require_once '../models/manager.php';

if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];

    
    switch ($option) {
        case 'svacct':
            if($_POST){
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $identificacion = $_POST['identificacion'];
                $correo = $_POST['correo'];
                $whatsapp = $_POST['movil'];
                $direccion = $_POST['direccion'];
                $ciudad = $_POST['ciudad'];
                $pais = $_POST['pais'];
                $codigo = $_POST['postal'];
                $rol = 'Administrador';
                $nwad = new Manage ();
                $rs = $nwad->updateProfile($_SESSION['id999822'],$nombre, $apellido, $identificacion, $correo, $whatsapp, $direccion, $ciudad, $pais, $codigo, $rol);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
            }
        break;

        case 'getendpoints':
            if($_POST){
                $titulo = $_POST['titulo'];
                $nwad = new Manage ();
                $rs = $nwad->getEndPoints($titulo);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data'=>$rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR"); 
                    echo json_encode($arrResp);
                }
            }
        break;    
        
        case 'updatemp':
            if($_POST){
                $idempleado = $_POST['empid'];
                $nombre = $_POST['empnombre'];
                $apellido = $_POST['empapellidos'];
                $nacimiento = $_POST['empnacimiento'];
                $sexo = $_POST['empsexo'];
                $identificacion = $_POST['empidentificacion'];
                $correo = $_POST['empcorreo'];
                $celular = $_POST['empmovil'];
                $direccion = $_POST['empdireccion'];
                $ciudad = $_POST['empciudad'];
                $fecha_ingreso = $_POST['empingreso'];
                $cargo = $_POST['empcargo'];
                $departamento = $_POST['empdepartamento'];
                $ismanager = isset($_POST['ismanager']) ? $_POST['ismanager'] : false;
                $hasaccess = isset($_POST['hasaccess']) ? $_POST['hasaccess'] : false;
                $isacceso = isset($_POST['accessLvl']) ? $_POST['accessLvl'] : false;
                $acceso = isset($_POST['empnivel_acceso']) ? $_POST['empnivel_acceso'] : 'no-acceso';

                if (isset($_FILES['imgfile']) && !empty($_FILES['imgfile']['tmp_name'])) {
                    $image = $_FILES['imgfile'];
                    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                    $pic = uniqid('', true) . '.' . $extension;
                    move_uploaded_file($image['tmp_name'], '../assest/images/personal/' . $pic);
                    $imagen = $pic;
                } else {
                    $imagen = 'no-image.webp';
                }
                
                $nwad = new Manage ();
                $rs = $nwad->updatePersonalProfile($idempleado, $nombre, $apellido, $nacimiento, $sexo, $identificacion, $correo, $celular, $acceso, $direccion, $ciudad, $imagen, $fecha_ingreso, $cargo, $departamento, $hasaccess, $ismanager, $_SESSION['id999822']);
                if ($rs == 1) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } 
                if ($rs == 0) {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
                if ($rs == 2) {
                    $arrResp = array('status' => false, 'msg' => "ERROR_02"); //error enviando el correo
                    echo json_encode($arrResp);
                }
                if ($rs == 3) {
                    $arrResp = array('status' => false, 'msg' => "ERROR_03"); //error enviando el correo
                    echo json_encode($arrResp);
                }
            }
        break;
        
        case 'crearclave':
            if($_POST){
                    $id = $_POST['idpersona'];
                    $clave = $_POST['regpassword'];
                    $nwad = new Manage ();
                    $rs = $nwad->crear_clave($id, $clave);
                    if ($rs>0) {
                        $arrResp = array('status' => true, 'msg' => "OK"); 
                        echo json_encode($arrResp);
                    } else {
                        $arrResp = array('status' => false, 'msg' => "ERROR"); 
                        echo json_encode($arrResp);
                    }
            }
        break;

        

        case 'getpaises':
            if($_GET){
                $gp = new Manage();
                $rs = $gp->get_paises();
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data'=>$rs); 
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR"); 
                }
                echo json_encode($arrResp);
            }
        break;
    }


    

    

    

    

}

?>