<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-10 col-xxl-10 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
					<div class="text-center mt-4">
							<h1>Datos del Administrador</h1>
						</div>
						<div class="row mt-25">
							<div class="col-12 col-md-12">
							<form id="frmcuenta" class="row g-3">
								<div class="col-md-6">
									<label for="nombre" class="form-label">Nombre</label>
									<input type="text" class="form-control" name="nombre" id="nombre">
								</div>
								<div class="col-md-6">
									<label for="apellido" class="form-label">Apellido</label>
									<input type="text" class="form-control" name="apellido" id="apellido">
								</div>
								<div class="col-md-4">
									<label for="identificacion" class="form-label">Identificación</label>
									<input type="text" class="form-control" name="identificacion" id="identificacion">
								</div>
								<div class="col-md-4">
									<label for="correo" class="form-label">Dirección de correo</label>
									<input type="email" class="form-control" name="correo" id="correo">
								</div>
								<div class="col-md-4">
									<label for="movil" class="form-label">Movil</label>
									<input type="text" class="form-control" name="movil" id="movil">
								</div>
								<div class="col-129">
									<label for="direccion" class="form-label">Dirección</label>
									<input type="text" class="form-control" name="direccion" id="direccion">
								</div>
								<div class="col-md-4">
									<label for="ciudad" class="form-label">Ciudad</label>
									<input type="text" class="form-control" name="ciudad" id="ciudad">
								</div>
								<div class="col-md-4">
									<label for="pais" class="form-label">País</label>
									<select id="pais" name="pais" class="form-select">
									<option selected>Selecciona...</option>
									
									</select>
								</div>
								<div class="col-md-4">
									<label for="postal" class="form-label">Código postal</label>
									<input type="text" class="form-control" name="postal" id="postal">
								</div>
								<!-- datos de la sede principal de la empresa -->
								<div class="col-12">
									<button id="guardarprofile" class="btn btn-primary">Guardar</button>
									<a href="index.php" class="btn btn-warning">Regresar</a>
								</div>
								</form>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
		</main>
