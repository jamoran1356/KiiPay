<?php 
session_start();
require_once '../models/departamentos.php';

if(empty($_REQUEST['op'])){
    echo "error en la solicitud";
} else {
    $option = $_REQUEST['op'];

    if($option=="getpaises"){
        if($_GET){
            $nwad = new Departamento ();
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

    if($option=="svdpto"){
        if($_POST){
                $nombre = $_POST['departamento'];
                $descripcion = $_POST['descripcion'];
                $nwad = new Departamento ();
                $rs = $nwad->savedepto($_SESSION['id999822'],$nombre, $descripcion);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="uptdpto"){
        if($_POST){
                $id = $_POST['id'];
                $nombre = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $nwad = new Departamento ();
                $rs = $nwad->upddepto($_SESSION['id999822'],$nombre, $descripcion, $id);
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK"); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="getdpto"){
        if($_POST){
            $tbl = new Departamento();
            $tbl = $tbl->contar_dptos();
            $orden = 'ASC';

            $pagina = isset($_POST['pg']) ? (int)$_POST['pg'] : 1;
            $registros = 10;

            $inicio = ($pagina>1) ? (($pagina*$registros)-$registros) : 0;
            
            $total_paginas = ceil($tbl/$registros); // Redondear hacia arriba

            $nwad = new Departamento ();
            $rs = $nwad->getdptos_paginado($inicio, $registros, $orden);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs, 'total_paginas'=> $total_paginas); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="getnumdptos"){
        if($_GET){
            $nwad = new Departamento ();
            $rs = $nwad->contar_dptos();
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="getdptos"){
        if($_GET){
            $nwad = new Departamento ();
            $rs = $nwad->get_dptos();
                if ($rs > 0) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="getDptoById"){
        if($_POST){
                $id = $_POST['id'];
                $nwad = new Departamento ();
                $rs = $nwad->get_dptos_by_id($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data'=> $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR_01"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="dltdpto"){
        if($_POST){
            $id = $_POST['id'];
            $nwad = new Departamento ();
            $rs = $nwad->del_depto($_SESSION['id999822'], $id);
            if ($rs == 1) {
                $arrResp = array('status' => true, 'msg' => "Departamento eliminado"); 
            } else if ($rs=='E1') {
                $arrResp = array('status' => false, 'msg' => "El departamento es necesario para el funcionamiento del sistema y no puede ser eliminado"); 
            }
            echo json_encode($arrResp);
        }
    }
    
    if($option=="getsldptos"){
        if($_GET){
            $nwad = new Departamento ();
            $rs = $nwad->get_dptos_select($_SESSION['id999822']);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data' => $rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "NO_DATOS"); 
                    echo json_encode($arrResp);
                }
        }

    }

    if($option=="gmdpto"){
        if($_POST){
                $id = $_POST['id'];
                $nwad = new Departamento ();
                $rs = $nwad->getManagerDpto($id);
                if (!empty($rs)) {
                    $arrResp = array('status' => true, 'msg' => "OK", 'data'=>$rs); 
                    echo json_encode($arrResp);
                } else {
                    $arrResp = array('status' => false, 'msg' => "ERROR"); 
                    echo json_encode($arrResp);
                }
        }

    }


}

?>