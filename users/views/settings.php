<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-10 col-xxl-10 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
					<div class="text-center mt-4">
							<h1>Configuración</h1>
						</div>
						<div class="row mt-25">
							<div class="col-12 col-md-12">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Contraseña</button>
								</li>
							</ul>
							<div class="tab-content mb-50" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<form id="frmpass" class="mt-50">
    <h4>Actualizar contraseña</h4>

  <div class="col-md-6 mt-15">
      <label class="form-label">Ingrese contraseña actual</label>
      <input class="form-control" type="text" name="clave_actual" id="clave_actual"/>
  </div>
  <div class="col-md-6 mt-15">
      <label for="nueva_clave1" class="form-label">Nueva clave</label>
      <input class="form-control" type="password" name="nueva_clave1" id="nueva_clave1"/>
  </div>
  <div class="col-md-6 mt-15">
      <label for="nueva_clave2" class="form-label">Repite clave</label>
      <input class="form-control" type="password" name="nueva_clave2" id="nueva_clave2"/>
	  <div id="error_msg'"></div>
  </div>
  <div class=" col-md-12 text-center mt-25">
      <button type="submit" class="btn btn-primary" id="btnupdateclave">Guardar</button> 
      <a href="index.php" class="btn btn-warning">Regresar</a> 
  </div>

</form>
        </div>
					</div>
				</div>
			</div>
		</div>	
		</main>
			
