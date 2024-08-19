
<main class="content">
	<div class="container-fluid p-0">
	<div id="clpvisualizar" class="dvpview hide">
		<div id="canvas-img" class="img-container">
			<img src="" id="clpvimg" class="pview">
		</div>
		<button type="button" class="btn btn-dark svtb hide" id="clsv__crop">Recortar</button>
	</div> 
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
						<div class="text-center mt-4">
							<h1>Unidades</h1>
						</div>
						<div id="tblunidades">
						<div class="row">
							<div class="col-12 text-right"><button class="btn btn-primary" id="addunidadbtn"><i class="align-middle" data-feather="truck"></i> Agregar</button></div>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<table class="table table-hover my-0">
						<thead>
							<tr>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">Tipo</th>
							<th class="d-none d-xl-table-cell">Patente</th>
							<th class="d-none d-xl-table-cell">DV</th>
							<th class="d-none d-xl-table-cell">Marca</th>
							<th class="d-none d-xl-table-cell">Modelo</th>
							<th class="d-none d-xl-table-cell">N° de chasis</th>
							<th class="d-none d-xl-table-cell">Año</th>
							<th class="d-none d-xl-table-cell">Ubicación</th>
							<th style="width:30px"></th>
							</tr>
						</thead>
						<tbody id="tbl-unidades">
						
						</tbody>
						</table>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_unidades" class="mr-25 ml-10"></div>
					</div>
				
					<div class="paginacion">
						<ul class="pagination" id="unidades-pagination">
						</ul>
						
					</div>	
					</div>	
						</div>
						<!--agregar unidades -->
						<div id="addunidades" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-12">
							<form id="frmunidades" class="row">
								
									<div class="row g-3">
										<h3>Datos de la unidad</h3>
										<div class="col-md-3 rl">
											<label for="pcnombre" class="form-label">Empresa</label>
											<input type="hidden" name="idpcnombre" id="idpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="pcnombre" id="pcnombre">   
											<ul id="lista_empresa" class="lista hide">
											</ul>
										</div>	
										<div class="col-md-3">
											<label for="ppu_tracto" class="form-label">Patente</label>
											<input type="text" class="form-control" name="ppu_tracto" id="ppu_tracto">
										</div>
										<div class="col-md-3">
											<label for="ppu_semi" class="form-label">PPU Semi</label>
											<input type="text" class="form-control" name="ppu_semi" id="ppu_semi">
										</div>
										<div class="col-md-3">
											<label for="tipo" class="form-label">Tipo</label>
											<input type="text" class="form-control" name="tipo" id="tipo">
										</div>
										<div class="col-md-4">
											<label for="marca" class="form-label">Marca</label>
											<input type="text" class="form-control" name="marca" id="marca">
										</div>
										<div class="col-md-2">
											<label for="modelo" class="form-label">Modelo</label>
											<input type="text" class="form-control" name="modelo" id="modelo">
										</div>
										<div class="col-md-2">
											<label for="year" class="form-label">Año</label>
											<input type="text" class="form-control" name="year" id="year">
										</div>
										
										<div class="col-md-2">
											<label for="chasis" class="form-label">N° de chasis</label>
											<input type="text" class="form-control" name="chasis" id="chasis">
										</div>
										<div class="col-md-2">
											<label for="estatus" class="form-label">Estatus</label>
											<input type="text" class="form-control" name="estatus" id="estatus">
										</div>
										
										<div class="col-md-12">
											<label for="ubicacion" class="form-label">Ubicación unidad</label>
											<input type="text" class="form-control" name="ubicacion" id="ubicacion">
										</div>
										<div class="col-md-3">
											<label for="dv" class="form-label">DV</label>
											<input type="text" class="form-control" name="dv" id="dv">
										</div>
										<div class="col-md-3">
											<label for="contrato" class="form-label">Contrato</label>
											<input type="text" class="form-control" name="contrato" id="contrato">
										</div>
										<div class="col-md-3">
											<label for="km_actual" class="form-label">Kilometraje Actual</label>
											<input type="number" class="form-control" name="km_actual" id="km_actual">
										</div>
										<div class="col-md-3">
											<label for="km_proximo" class="form-label">Kilometraje prox</label>
											<input type="number" class="form-control" name="km_proximo" id="km_proximo">
										</div>
										<div class="col-12 mt-25 mb-25">
											<input type="hidden" name="empid" id="empid">
											<input type="hidden" name="idund" id="idund">
											<button id="upd__unidades" class="btn btn-primary hide">Actualizar</button>
											<button id="sv__unidades" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__unidades">Regresar</button>
										</div>
									</div>
									<!-- datos de la sede principal de la empresa -->
								</form>
							</div>
						</div>	
					</div>
						<!-- fin de agregar unidades -->
						<div id="addcliente" class="hide">
						<!--agregar personal -->
						<div class="row mt-25">
							<div class="col-12 col-md-12">
							<form id="frmcliente" class="row">
								<div class="col-md-4 order-0 dig-flex">
									<div class="preview_img">
										<img id="climg__pv" src="assest/images/no-profile.webp" alt="no image" class="preview-img">
									</div>
									<input type="file" class="hide" name="climagen" id="climagen" accept="image/*">
									<div id="clpick_img" class="pick_img">Seleccionar logo</div>
									<input type="hidden" name="climg__base64" id="climg__base64">
									 
								</div>
								<div class="col-md-7">
									<div class="row g-3">
										<h3>Datos de la empresa</h3>
										<div class="col-md-6">
											<label for="empnombre" class="form-label">Nombre de la empresa</label>
											<input type="text" class="form-control" name="empnombre" id="empnombre">	
										</div>		
										<div class="col-md-6">
											<label for="empNIF" class="form-label">NIF</label>
											<input type="text" class="form-control" name="empNIF" id="empNIF">
										</div>
										<div class="col-md-4">
											<label for="empwebsite" class="form-label">Website</label>
											<input type="text" class="form-control" name="empwebsite" id="empwebsite">
										</div>
										<div class="col-md-4">
											<label for="empcorreo" class="form-label">Dirección de correo</label>
											<input type="email" class="form-control" name="empcorreo" id="empcorreo">
										</div>
										<div class="col-md-4">
											<label for="movil" class="form-label">Teléfono</label>
											<input type="text" class="form-control" name="movil" id="movil">
										</div>
										<div class="col-12">
											<label for="empdireccion" class="form-label">Dirección</label>
											<input type="text" class="form-control" name="empdireccion" id="empdireccion">
										</div>
										<div class="col-md-6">
											<label for="empciudad" class="form-label">Ciudad</label>
											<input type="text" class="form-control" name="empciudad" id="empciudad">
										</div>
										<div class="col-md-6">
											<label for="empprovincia" class="form-label">Provincia</label>
											<input type="text" class="form-control" name="empprovincia" id="empprovincia">
										</div>
										<div class="col-12 mt-25 mb-25">
											<button id="upd__empresa" class="btn btn-primary hide">Actualizar</button>
											
											<button id="sv__empresa_fu" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__company">Regresar</button>
										</div>

										</div>	

									</div>
									<!-- datos de la sede principal de la empresa -->
									
								</div>
								</form>
							</div>
						</div>	
				</div>
			</div>
		</div>	
	</div>
</main>

<div class="offcanvas offcanvas-end" tabindex="-1" id="empdetalles" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h1 class="offcanvas-title" id="ttldetalles"></h1>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
	<!-- detalle unidad -->
	<div id="unidad-detalles" class="hide">
		<div class="row g-3">
			<div class="d-flex flex-column align-items-center text-center m-top-50">
                    <img src="" alt="imagen, logo" class="rounded-circle" width="150" id="undcompanylogo">
                    <div class="mt-3">
                      <h4 id="undcompanyname"></h4>
					  <div class="text-pr mt-15"><strong>Patente</strong></div>
					  <p class="text-secondary mb-1" id="undpatente"></p> 
					  <div class="text-pr mt-15"><strong>PPU Semi</strong></div>
					  <p class="text-secondary mb-1" id="undsemi"></p> 
					  <div class="text-pr mt-15"><strong>Tipo</strong></div>
					  <p class="text-secondary mb-1" id="undtipo"></p> 
					  <div class="text-pr mt-15"><strong>Marca</strong></div>
					  <p class="text-secondary mb-1" id="undmarca"></p>
					  <div class="text-pr mt-15"><strong>Modelo</strong></div>
					  <p class="text-secondary mb-1" id="undmodelo"></p>
					  <div class="text-pr mt-15"><strong>Año</strong></div>
					  <p class="text-secondary mb-1" id="undyear"></p>
					  <div class="text-pr mt-15"><strong>KM Actual</strong></div>
					  <p class="text-secondary mb-1" id="undkmactual"></p>
					  <div class="text-pr mt-15"><strong>KM Próxmo</strong></div>
					  <p class="text-secondary mb-1" id="undkmprox"></p>
					  <div class="text-pr mt-15"><strong>N° de chasis</strong></div>
					  <p class="text-secondary mb-1" id="undchasis"></p>
					  <div class="text-pr mt-15"><strong>Estatus</strong></div>
					  <p class="text-secondary mb-1" id="undstatus"></p>
					  <div class="text-pr mt-15"><strong>Ubicación</strong></div>
					  <p class="text-secondary mb-1" id="undubicacion"></p>
					  <div class="text-pr mt-15"><strong>DV</strong></div>
					  <p class="text-secondary mb-1" id="unddv"></p>
					  <div class="text-pr mt-15"><strong>Contrato</strong></div>
					  <p class="text-secondary mb-1" id="undcontrato"></p>
                  </div>
            </div>
		</div>
	</div>	
	<!-- fin detalle unidad -->
  </div>
</div>