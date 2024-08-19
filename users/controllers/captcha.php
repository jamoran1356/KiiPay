<?php 
session_start();
require_once '../models/captcha.php';

if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];

    if($option=="prvcaptcha"){
        if($_GET){
            $nwad = new Captcha ();
            $rs = $nwad->getCaptcha();
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option == "updatecaptcha"){
        if($_POST){
            $publica = $_POST['google_publica'];
            $privada = $_POST['google_privada'];
            $activo = $_POST['activo'] == 'true' ? 1 : 0;
            $nwad = new Captcha ();
            $rs = $nwad->updCaptcha($publica, $privada, $activo);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false); 
                    echo json_encode($arrResp);
                }
        }
    }

    if($option == "chngcaptcha"){
        if($_POST){
            $activo = $_POST['activo'] == 'true' ? 1 : 0;
            $nwad = new Captcha ();
            $rs = $nwad->updCaptchaActivo($activo);
            if ($rs > 0) {
                $arrResp = array('status' => true, 'msg' => "OK"); 
                echo json_encode($arrResp);
            } else {
                $arrResp = array('status' => false); 
                echo json_encode($arrResp);
            }
        }
    }

    if($option == "getpublickey") {
        if($_GET){
            $nwad = new Captcha ();
            $rs = $nwad->getPublicKey();
            if ($rs > 0) {
                $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                echo json_encode($arrResp);
            } else {
                $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                echo json_encode($arrResp);
            }
        }
    }

    if($option == "isactive"){
        if($_GET){
            $nwad = new Captcha ();
            $rs = $nwad->gc_isActive();
            if ($rs > 0) {
                $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                echo json_encode($arrResp);
            } else {
                $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                echo json_encode($arrResp);
            }
        }
    }

    

}

?>