<?php
session_start();
require_once 'models/login.php';

//se verifica que solo exista una sesion por usuario
$cl = new Login();
if(isset($_SESSION['id999822'])){
    $session = $cl->verificar_acceso($_SESSION['id999822']);

    if ($session['ip'] != $_SERVER['REMOTE_ADDR']) {
        // Si la IP de la sesión no coincide con la IP actual, cerrar la sesión
        session_unset();     // eliminar las variables de sesión
        session_destroy();   // destruir la sesión
        header('Location: login.php');
        exit;
    }

    // Actualizar la última actividad del usuario en la base de datos
    $cl->actualizar_acceso($_SESSION['id999822'], session_id());
    
    $vida_session = 1800; // 30 minutos en segundos

    if (empty($_SESSION['em158325'])) {
      session_unset();     // eliminar las variables de sesión
      session_destroy();   // destruir la sesión
      header('Location: login.php');
      exit;
    }

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $vida_session)) {
        session_unset();     // eliminar las variables de sesión
        session_destroy();   // destruir la sesión
        header('Location: login.php');
        exit;
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // actualizar la última actividad del usuario

    if (isset($_GET['p'])) {
        // If the parameter is set but empty, use 'default'
        $pagina = ($_GET['p'] === '') ? 'default' : strtolower($_GET['p']);
    } else {
        // If the parameter is not set, use 'default'
        $p='default';
        $pagina = 'default';
    }
    
    require_once 'views/header.php';
    require_once 'views/'.$pagina.'.php';
    require_once 'views/footer.php';

} else {
    header('Location: login.php');
    exit;
} 

?>