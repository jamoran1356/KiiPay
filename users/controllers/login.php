<?php 
session_start();
require_once '../models/login.php';
require_once '../models/captcha.php';

if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];


    switch($option){
        case 'login':
            if($_POST){
                $correo = trim($_POST['logemail']);
                $clave = trim($_POST['logpassword']);
            
                $objPrs = new Login();
                $rs = $objPrs->login($correo, $clave);
            
                if ($rs == 1) { 
                    $arrResp = array('status' => true, 'msg' => "LOGIN"); 
                } 
                if ($rs == 0) { 
                    $arrResp = array('status' => false, 'msg' => "ERROR_01");  //contraseña errada
                }
                if  ($rs == 3) { 
                    $arrResp = array('status' => false, 'msg' => "ERROR_02"); //usuario no encontrado
                }
                echo json_encode($arrResp);
            }
        break;  
        
        case 'logout':
            session_destroy();
            header("Location: ../index.php");
        break;  
    }

}

?>