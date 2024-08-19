
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
							<h1>Clientes</h1>
						</div>
						<div id="tblcliente">
						<div class="row">
							<div class="col-12 k-flex">
								<input type="text" class="form-search" placeholder="Buscar empresas clienets..." id="txtclientes" name="txtclientes">
									<div id="botonera" class="d-flex">
										<div class="tblbtn mr-10">
											<button title="Importar"  data-bs-toggle="modal" data-bs-target="#importar"><i class="align-middle" data-feather="upload-cloud"></i></button>
											</button>
										</div>
										<button class="btn btn-primary" id="addclientebtn"><i class="align-middle" data-feather="database"></i> Agregar</button>
									</div>
							</div>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<table class="table table-hover my-0">
						<thead>
							<tr>		
							<th>Cliente</th>
							<th class="d-none d-xl-table-cell">NIF</th>
							<th class="d-none d-xl-table-cell">Email</th>
							<th class="d-none d-xl-table-cell">Telefono</th>
							<th class="d-none d-xl-table-cell">Unidades</th>
							
							<th style="width:30px"></th>
							</tr>
						</thead>
						<tbody id="tbl-clientes">
						
						</tbody>
						</table>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_clientes" class="mr-25 ml-10"></div>
					</div>
				
					<div class="paginacion">
						<ul class="pagination" id="cliente-pagination">
						</ul>
						
					</div>	
					</div>	
						</div>
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
											<input type="hidden" name="idempresa" id="idempresa">
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
											<input type="hidden" name="empid" id="empid">
											<button id="save__empresa" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__empresa">Regresar</button>
										</div>

										</div>	

									</div>
									<!-- datos de la sede principal de la empresa -->
									
								</div>
								</form>
							</div>
						</div>	
						<!-- fin de agregar Empresa -->
						<div id="addunidades" class="hide">
						<div class="row mt-25">
							<div class="col-12 col-md-12">
							<form id="frmunidades" class="row">
									<div class="row g-3" id="crgfrm">
										<h3>Datos de la unidad</h3>
										<div class="col-md-3 rl">
											<label for="pcnombre" class="form-label">Empresa propietaria</label>
											<input type="hidden" name="idpcnombre" id="idpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="pcnombre" id="pcnombre" disabled>   
										</div>	
										<div class="col-md-3">
											<label for="ppu_tracto" class="form-label">Patente</label>
											<input type="text" class="form-control" name="ppu_tracto" id="ppu_tracto">
										</div>
										<!--div class="col-md-3">
											<label for="ppu_semi" class="form-label">PPU Semi</label>
											<input type="text" class="form-control" name="ppu_semi" id="ppu_semi">
										</div-->
										<div class="col-md-6">
											<label for="tipo" class="form-label">Tipo</label>
											<select class="form-control" name="tipo" id="tipo">
												<option value="" selected>Seleccione</option>
												<option value="TRACTOCAMIÓN">TRACTOCAMIÓN</option>
												<option value="SEMIREMOLQUE">SEMIREMOLQUE</option>
											</select>
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
											<select class="form-control" name="estatus" id="estatus">
												<option value="" selected>Seleccione</option>
												<option value="LIBERADO">LIBERADO</option>
												<option value="DESMOVILIZADO">DESMOVILIZADO</option>
												<option value="MOVILIZADO">MOVILIZADO</option>
												<option value="CONDICIONADO">CONDICIONADO</option>
											</select>
										</div>
										
										<div class="col-md-12">
											<label for="ubicacion" class="form-label">Ubicación unidad</label>
											<input type="text" class="form-control" name="ubicacion" id="ubicacion">
										</div>
										<div class="col-md-6">
											<label for="km_actual" class="form-label">Kilometraje Actual</label>
											<input type="number" class="form-control" name="km_actual" id="km_actual">
										</div>
										<div class="col-md-6">
											<label for="km_proximo" class="form-label">Kilometraje prox</label>
											<input type="number" class="form-control" name="km_proximo" id="km_proximo">
										</div>
										<div class="col-12 mt-25 mb-25">
											<button id="updx__unidades" class="btn btn-primary hide">Actualizar</button>
											<input type="hidden" name="idund" id="idund">
											<input type="hidden" name="empid" id="empid">
											<button id="save__unidades" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__und">Regresar</button>
										</div>
									</div>
								</form>
							</div>
						</div>	
						</div>
						<!-- fin guardar unidades -->
						<div id="tblveh_empresa" class="hide">
							<div class="row mt-25">
								<h4 id="titulo_empresa">Listado de unidades de la empresa </h4>
							</div>
						<div class="row">
						<input type="text" class="ml-15 form-search" placeholder="Buscar ppu..." id="txtunidades" name="txtunidades">
						<input type="hidden" name="idcompany" id="idcompany">
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<table class="table table-hover my-0">
						<thead>
							<tr>
							<th class="d-none d-xl-table-cell">Tipo</th>
							<th class="d-none d-xl-table-cell">Patente</th>
							<th class="d-none d-xl-table-cell">Marca</th>
							<th class="d-none d-xl-table-cell">Modelo</th>
							<th class="d-none d-xl-table-cell">N° de chasis</th>
							<th class="d-none d-xl-table-cell">Año</th>
							<th class="d-none d-xl-table-cell">Ubicación</th>
							<th class="d-none d-xl-table-cell">Status</th>
							<th style="width:30px"></th>
							</tr>
						</thead>
						<tbody id="tbl-veh_empresa">
						
						</tbody>
						</table>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_veh_empresa" class="mr-25 ml-10"></div>
					</div>
				
					<div class="paginacion">
						<ul class="pagination" id="veh_empresa-pagination">
						</ul>
						
					</div>	
					<button class="btn btn-warning wx-100" id="back__undx1">Regresar</button>
					</div>	
						</div>

					</div>
				</div>
			</div>
		</div>	
		</main>



		

<div class="offcanvas offcanvas-end" tabindex="-1" id="empdetalles" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title" id="ttldetalles"></h3>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
	<!-- detalle empresa -->
	<div id="empresa-detalles" class="hide">
		<div class="row g-3">
			<div class="d-flex flex-column align-items-center text-center">
                    <img src="" alt="imagen, logo" class="rounded-circle" width="150" id="companylogo">
                    <div class="mt-3">
                      <h4 id="companyname"></h4>
					  <div class="text-pr mt-15"><strong>NIF</strong></div>
					  <p class="text-secondary mb-1" id="companynif"></p> 
					  <div class="text-pr mt-15"><strong>Email</strong></div>
					  <p class="text-secondary mb-1" id="companyemail"></p> 
					  <div class="text-pr mt-15"><strong>Teléfono</strong></div>
					  <p class="text-secondary mb-1" id="companyphone"></p> 
					  <div class="text-pr mt-15"><strong>Dirección</strong></div>
					  <p class="text-secondary mb-1" id="companyaddress"></p>
					  <div class="text-pr mt-15"><strong>Ciudad</strong></div>
					  <p class="text-secondary mb-1" id="companycity"></p>
					  <div class="text-pr mt-15"><strong>Provincia</strong></div>
					  <p class="text-secondary mb-1" id="companystate"></p>
                  </div>
            </div>
		</div>
	</div>	
	<!-- fin detalle empresa -->
	<!-- detalle unidad -->
	<div id="unidad-detalles" class="hide">
		<div class="row g-3">
			<div class="d-flex flex-column align-items-center text-center m-top-50">
                    <img src="" alt="imagen, logo" class="rounded-circle" width="150" id="undcompanylogo">
                      <h4 id="undempresaname"></h4>
					  <div class="row">
						 <div class="col-md-12 mt-10">
						 	<strong>Patente</strong>
							<input type="text" class="form-control" name="undpatente" id="undpatente" disabled>
						 </div>
						 <div class="col-md-12 mt-10">
							 <strong>Tipo</</strong>
		 					 <input type="text" class="form-control" name="undtipo" id="undtipo" disabled>
						 </div>
						 <div class="col-md-12 mt-10">
						 	<strong>Marca</</strong>
							<input type="text" class="form-control" name="undmarca" id="undmarca" disabled>
						 </div>
						 <div class="col-md-12 mt-10">
	 						 <strong>Modelo</</strong>
	 						 <input type="text" class="form-control" name="undmodelo" id="undmodelo" disabled>
						 </div>
						 <div class="col-md-12 mt-10">						 
							 <strong>Año</</strong>
							 <input type="text" class="form-control" name="undyear" id="undyear" disabled>
						 </div>
						 <div class="col-md-12 mt-10">						 
							 <strong>N° Chasis</</strong>
							 <input type="text" class="form-control" name="undchasis" id="undchasis" disabled>
						 </div>
						 <div class="col-md-12 mt-10">						 
							 <strong>KM Actual</</strong>
							 <input type="text" class="form-control" name="undkmact" id="undkmact" disabled>
						 </div>
						 <div class="col-md-12 mt-10">						 
							 <strong>KM Próximo mantenimiento</</strong>
							 <input type="text" class="form-control" name="undkmprox" id="undkmprox" disabled>
						 </div>
						 <div class="col-md-12 mt-10">						 
							 <strong">Ubicación</</strong>
							 <input type="text" class="form-control" name="undubicacion" id="undubicacion" disabled>
						 </div>
						 <div class="col-md-12 mt-25">
							<h4>Status</h4>
							<table class="table table-hover striped my-0">
								<thead>
									<tr>
									<th class="d-none d-xl-table-cell">Fecha</th>
									<th class="d-none d-xl-table-cell">Descripción</th>
									<th class="d-none d-xl-table-cell">Estado</th>
									</tr>
								</thead>
								<tbody id="tbl-undstatus" class="tbhistorial">
								</tbody>
							</table>
						</div>
                  </div>
            </div>
		</div>
	</div>	
	<!-- fin detalle unidad -->
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="importar" tabindex="-1" aria-labelledby="ImportarData" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ImportarData">Importar datos</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeImport"></button>
      </div>
      <div class="modal-body bg-white">
	  	<p>Por favor usa el siguiente archivo como muestra para que los datos se puedan importar de forma correcta: </p>		
		<p><a target="_blank" href="assest/documentos/samples/modelo_unidades.xlsx">Descargar archivo de muestra</a></p>
		<br>
		<form id="importFile">
			<label for="ImpUnidades" class="form-label"><strong>Selecciona el archivo que deseas importar</strong></label>
			<input type="file" class="form-control" id="ImpUnidades" name="ImpUnidades">
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeImport">Close</button>
        <button type="button" class="btn btn-primary" id="importar_bulk">Importar</button>
      </div>
    </div>
  </div>
</div>



		
		
<!-- Modal -->
<div class="modal fade" id="progressmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
	  	
	  		<div class="progress" role="progressbar" aria-label="importación de archivo" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
    		<div id="progressbar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>
  		</div>
		<div id="error"></div>

      </div>
    </div>
  </div>
</div>		