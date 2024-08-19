<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-12 col-xxl-12 col-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header">
						<div class="text-center mt-4">
								<h1>Departamentos</h1>
						</div>
						<div id="tabladpto">
						<div class="row">
							<div class="col-12 text-right"><button class="btn btn-primary" id="adddpto"><i class="align-middle" data-feather="monitor"></i> Crear</button></div>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<table class="table table-hover my-0">
						<thead>
							<tr>
							<th style="width:250px">Departamento</th>
							<th class="d-none d-xl-table-cell">Manager</th>
							<th style="width:250px" class="d-none d-xl-table-cell">Núm de empleados</th>
							<th></th>
							</tr>
						</thead>
						<tbody id="tbl-departamentos">
						
						</tbody>
						</table>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total de registros: <div id="total_departamentos" class="mr-25 ml-10"></div>
					</div>
				
					<div class="paginacion">
						<ul class="pagination" id="dptos-pagination">
						</ul>
						
					</div>	
					</div>	
						</div>
					
					<div class="row mt-25 hide" id="departamentos">
                  <div class="col-md-6 col-12">
                  <p class="notacp">Use esta opción para crear departamentos y asignar personas a su cargo. Los departamentos son las estructuras organizacionales de su empresa, use esta herramienta para clasificar al personal y tener un control de las personas</p>
                  <form id="frmdepartamento" class="row g-3">
								<div class="col-md-12">
									<label for="departamento" class="form-label">Nombre</label>
									<input type="text" class="form-control" name="departamento" id="departamento">
									<input type="hidden"name="dptoid" id="dptoid">
									
								</div>
                				<div class="col-md-12">
									<label for="descripcion" class="form-label">Descripción:</label>
									<textarea class="form-control" name="descripcion" id="descripcion"></textarea>
								</div>
								
                				<div class="col-12">
									<button id="btndepartamento" class="btn btn-primary mt-25 mb-25 ">Guardar</button>
									<button class="btn btn-warning mt-25 mb-25 ml-10" id="dptoback1">Regresar</button> 
								</div>
						</form>
                  </div>
                </div>
				<div class="row mt-25 hide" id="previewdpto">
                  <div class="col-md-6 col-12">
                  <p class="notacp">Use esta opción para crear departamentos y asignar personas a su cargo. Los departamentos son las estructuras organizacionales de su empresa, use esta herramienta para clasificar al personal y tener un control de las personas</p>
                  <form id="frmupddepartamento" class="row g-3">
								<div class="col-md-12">
									<label for="dptotitulo" class="form-label">Nombre</label>
									<input type="text" class="form-control" name="dptotitulo" id="dptotitulo">
									<input type="hidden"name="dptoid" id="dptoid">
									
								</div>
                				<div class="col-md-12">
									<label for="dptodescripcion" class="form-label">Descripción:</label>
									<textarea class="form-control" name="dptodescripcion" id="dptodescripcion"></textarea>
								</div>
                				<div class="col-12">
                  					  <button id="btnactualizardep" class="btn btn-primary mt-25 mb-25">Actualizar</button>
									  <button class="btn btn-warning mt-25 mb-25 ml-10" id="dptoback2">Regresar</button> 
								</div>
						</form>
                  </div>
                </div>
		 	   </div>
		    </div>
  	    </div>
	</div>	
</main>
    

    