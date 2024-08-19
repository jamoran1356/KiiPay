
<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
						<div class="text-center mt-4">
							<h1>Actividades</h1>
						</div>
						<div id="tblactividades">
						<div class="row">
							<div class="col-12 text-right"><button class="btn btn-primary" id="addtareabtn"><i class="align-middle" data-feather="calendar"></i> Agregar</button></div>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<table class="table table-hover my-0">
						<thead>
							<tr>
							<th>Cliente</th>
							<th class="d-none d-xl-table-cell">Tipo de solicitud</th>
							<th class="d-none d-xl-table-cell">PPU Semi/Tracto</th>
							<th class="d-none d-xl-table-cell">Fecha solicitud</th>
							<th class="d-none d-xl-table-cell">Fecha revisión</th>
							<th class="d-none d-xl-table-cell">Solicitado por</th>
							<th class="d-none d-xl-table-cell">Asignado a</th>
							<th class="d-none d-xl-table-cell">Status</th>
							<th style="width:30px"></th>
							</tr>
						</thead>
						<tbody id="tbl-actividades">
						
						</tbody>
						</table>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_actividades" class="mr-25 ml-10"></div>
					</div>
				
					<div class="paginacion">
						<ul class="pagination" id="actividades-pagination">
						</ul>
						
					</div>	
					</div>	
						</div>
						<!--agregar unidades -->
						<div id="addtareas" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-10">
							<form id="frmactividades" class="row">
									<div class="row g-3">
										<h3>Datos de la unidades</h3>
										<div class="col-md-6 rl">
											<label for="pcnombre" class="form-label">Empresa propietaria</label>
											<input type="hidden" name="idpcnombre" id="idpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="pcnombre" id="pcnombre" placeholder="Ingresa el nombre de la empresa">   
											<ul id="lista_empresa" class="lista hide">
											</ul>
										</div>	
										<div class="col-md-6">
											<label for="ppu_semi" class="form-label">PPU Semi/Tracto</label>
											<select class="form-control" name="ppu_semi" id="ppu_semi">
												<option value="" selected>Seleccione</option>
											</select>
										</div>
										<div class="col-md-6">
										<div class="form-check form-switch">
											<input class="form-check-input " type="checkbox" name="detallesunit" id="detallesunit">
											<label class="form-check-label" for="detallesunit">Mostrar detalles de la unidad</label>
										</div>	
										</div>
										<div id="detalles_unidad" class="row g-3 hide">
											<div class="col-md-4">
												<label for="tipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" name="tipo" id="tipo">
											</div>
											<div class="col-md-4">
												<label for="marca" class="form-label">Marca</label>
												<input type="text" class="form-control" name="marca" id="marca">
											</div>
											<div class="col-md-4">
												<label for="modelo" class="form-label">Modelo</label>
												<input type="text" class="form-control" name="modelo" id="modelo">
											</div>
											<div class="col-md-4">
												<label for="color" class="form-label">Color</label>
												<input type="text" class="form-control" name="color" id="color">
											</div>
											<div class="col-md-4">
												<label for="year" class="form-label">Año</label>
												<input type="number" class="form-control" name="year" id="year">
											</div>
											<div class="col-md-4">
												<label for="km_actual" class="form-label">Kilometraje Actual</label>
												<input type="number" class="form-control" name="km_actual" id="km_actual">
											</div>
										</div>
										<h3>Datos de la actividad</h3>
										<div class="col-md-4">
											<label for="fecha_solicitud" class="form-label">Fecha Solicitud</label>
											<input type="date" class="form-control" name="fecha_solicitud" id="fecha_solicitud">
										</div>
										<div class="col-md-4">
											<label for="fecha_agendada" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_agendada" id="fecha_agendada">
										</div>
										<div class="col-md-4">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada">
										</div>
										<div class="col-md-4">
											<label for="tipo_actividad" class="form-label">Tipo de actividad</label>
											<select class="form-control" name="tipo_actividad" id="tipo_actividad">
												<option value="" selected>Seleccione</option>
												<option value="1">Mantenimiento Preventivo</option>
												<option value="2">IP Pauta</option>
												<option value="3">Spot</option>
												<option value="4">PANNE</option>
												<option value="4">Peritaje</option>
												</select>
										</div>
										<div class="col-md-4">
											<label for="solicitado" class="form-label">Solicitado por: </label>
											<input type="text" class="form-control" name="solicitado" id="solicitado">
										</div>
										<div class="col-md-4">
											<label for="aprobado_por" class="form-label">Aprobado por: </label>
											<input type="text" class="form-control" name="aprobado_por" id="aprobado_por">
										</div>
										<div class="col-md-9">
											<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
											<input type="text" class="form-control" name="ubicacion" id="ubicacion" placeholder="Ingresa la ubicación de la unidad">
										</div>
										<div class="col-md-3">
											<label for="estado" class="form-label">Estado: </label>
											<select class="form-control" name="estado" id="estado">
												<option value="" Selected>Seleccione</option>
												<option value="1">Desmovilizado</option>
												<option value="1">Movilizado</option>
											</select>	
										</div>
										<div class="col-md-8 rl">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" placeholder="Ingresa el nombre del inspector">
											<input type="hidden" name="idinspector" id="idinspector">
											<ul class="lista hide" id="lista_inspectores">
										</div>
										<div class="col-md-4">
											<div class="form-check form-switch mt-25">
												<input class="form-check-input " type="checkbox" name="multiples_inspectores" id="multiples_inspectores">
												<label class="form-check-label" for="multiples_inspectores">Multiples Inspectores</label>
											</div>		
										</div>
										<div class="col-md-8 hide" id="mulinspectores">
											<div id="inspectores_seleccionados" class="inspect"></div>
										</div>
										<div class="col-md-12 mt-25">
										<label class="form-label">Observaciones: </label>
											<div id="editor" class="mt--25"></div>	
											<input type="hidden" name="econtent" id="econtent">
										</div>
										
										<div class="col-md-6">
											<label for="archivos" class="form-label">Adjuntos: </label>
											<input type="file" class="form-control" name="archivos[]" id="archivos" multiple>
											<ul id="archivosList"></ul>
										</div>
										<div class="col-12 mt-25 mb-25">
											<button id="upd__tareas" class="btn btn-primary hide">Actualizar</button>
											<button id="sv__tareas" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__tareas">Regresar</button>
										</div>
									</div>
									<!-- datos de la sede principal de la empresa -->
								</form>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</div>
</main>
