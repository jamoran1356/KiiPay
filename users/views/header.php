<?php
$pg = isset($_GET['p']) ? $_GET['p'] : 'default';

require_once 'models/personal.php';

$mn = new Empleado();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Panel administrativo Grupo CIF">
	<meta name="author" content="Jesus Moran">
	<meta name="keywords" content="Panel administrativo V1.03">
	<title>Área administrativa SOPROCERT</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="assest/css/app.css" rel="stylesheet">
	<link rel="icon" type="image/webp" sizes="48x48" href="assest/images/favicon.webp">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<!--Hojas para el rich text -->
	<link href="assest/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="assest/fontawesome/css/brands.css" rel="stylesheet">
    <link href="assest/fontawesome/css/solid.css" rel="stylesheet">
	<link href="assest/css/pydti.css" rel="stylesheet">
	<?php $version = filemtime("assest/css/styles.css"); ?>
	<link href="assest/css/styles.css?v=<?php echo $version; ?>" rel="stylesheet">
	<link rel="stylesheet" href="assest/cropper/cropper.css">
	

</head>

<body>
<div id="loader" class="loader">
  <div class="loader-content"></div>
</div>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.php">
					<figure>
						<img class="brand-logo" src="assest/images/logo_bk.webp" alt="logo">
					</figure>
        		</a>
				<ul class="sidebar-nav">
					<li class="sidebar-item 
						<?php if($pg=='default'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php">
              				<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            			</a>
					</li>
					<li class="sidebar-header">
						CONFIGURACIÓN
					</li>
					<li class="sidebar-item 
						<?php if($pg=='account'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=account">
              				<i class="align-middle" data-feather="users"></i> <span class="align-middle">Datos</span>
            			</a>
					</li>
					<li class="sidebar-item 
						<?php if($pg=='settings'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=settings">
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle">Configuración</span>
						</a>
					</li>
					
					
					<li class="sidebar-header">
						ADMINISTRATIVO
					</li>
					<?php if($mn->check_acceso_menu($_SESSION['id999822'], 'departamentos')==1){ ?>
					<li class="sidebar-item 
						<?php if($pg=='departamentos'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=departamentos">
							<i class="align-middle" data-feather="monitor"></i> <span class="align-middle">Departamentos</span>
						</a>
					</li>
					<?php } if($mn->check_acceso_menu($_SESSION['id999822'], 'personal')==1){ ?>
					<li class="sidebar-item 
						<?php if($pg=='personal'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=personal">
							<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Usuarios</span>
						</a>
					</li>
					<?php } if($mn->check_acceso_menu($_SESSION['id999822'], 'equipos')==1){  ?>
					<li class="sidebar-item 
						<?php if($pg=='equipos'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=equipos">
							<i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Equipos</span>
						</a>
					</li>
					<?php } if($mn->check_acceso_menu($_SESSION['id999822'], 'empresa')==1){  ?>
					<li class="sidebar-item 
						<?php if($pg=='empresa'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=empresa">
							<i class="align-middle" data-feather="database"></i> <span class="align-middle">Empresas</span>
						</a>
					</li>
					<?php } if($mn->check_acceso_menu($_SESSION['id999822'], 'tallerip')==1){  ?>
					<li class="sidebar-item 
						<?php if($pg=='tallerip'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=tallerip">
							<i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Taller IP/PM</span>
						</a>
					</li>
					<?php } if($mn->check_acceso_menu($_SESSION['id999822'], 'panne')==1){  ?>
					<li class="sidebar-item 
						<?php if($pg=='panne'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=panne">
							<i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Panne</span>
						</a>
					</li>
					<?php } if($mn->check_acceso_menu($_SESSION['id999822'], 'spot')==1){  ?>
					<li class="sidebar-item 
						<?php if($pg=='spot'){ echo 'active'; } ?>">
						<a class="sidebar-link" href="index.php?p=spot">
							<i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Spot</span>
						</a>
					</li>
					<?php }?>	
				</ul><!-- Fin link menu lateral -->

				
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

		<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
					<li class="nav-item">
					<a class="nav-link d-none d-sm-inline-block" href="logout.php">
					<?php if(isset($_SESSION['nm167852'])){ echo $_SESSION['nm167852']; } else { echo "No name"; } ?>
					<i class="align-middle" data-feather="log-out"></i>
					</span>
              		</a>
						</li>
					</ul>
				</div>
			</nav>
