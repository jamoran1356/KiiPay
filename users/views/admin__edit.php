<?php

require_once 'models/manager.php';

$idmanager = intval($_GET['id']);

$ed = new Manage();
$ed = $ed-> mostrar_admin($idmanager);
?>
<div class="container d-flex flex-column">
	
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Editar Administrador</h1>
							
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<form id="frmUpdateAdmin">
										<div class="mb-3">
											<label class="form-label">Nombre</label>
											<input class="form-control form-control-lg" type="text" name="nombre" value="<?= $ed['nombre']; ?>">
											<input type="hidden" name="idmanager" value="<?= $idmanager; ?>">
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" value="<?= $ed['correo']; ?>"/>
										</div>
										<div class="text-center mt-3">
											<button type="submit" class="btn btn-lg btn-primary" id="btnUpdadmin">Guardar</button> 
											<a href="index.php?p=listadmin" class="btn btn-lg btn-warning">Regresar</a> 
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>