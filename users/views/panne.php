<?php 

$ord = (isset($_GET['od']) && $_GET['od'] == 'close') ? $_GET['od'] : "";

?>
<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
						<div class="text-center mt-4">
							<h1>Panne</h1>
						</div>
						<div id="tblpanne">
						<div class="row">
						
						<?php if ($_SESSION['r9l']=='Administrador') { ?>
							<div class="col-12 d-flexj">
							<div id="complementos_tools">	
								<select class="textbuscar" name="verclosepn" id="verclosepn">
									<option value="" selected>Ver solicitudes</option>
									<option value="=">Cerradas</option>
									<option value="!=">Abiertas</option>
								</select>
								<input type="text" class="textbuscar" id="txtbuscarpanne" name="txtbuscarpanne" placeholder="Buscar por ppu, empresa...">
							</div>
							<button class="btn btn-primary" id="addpannebtn"><i class="align-middle" data-feather="calendar"></i> Crear</button></div>
						<?php } ?>
						<?php if ($_SESSION['r9l']=='ambipar') { ?>
							<div class="col-12 d-flexj">
							<div id="complementos_tools">	
								<select class="textbuscar" name="ambverclosepn" id="ambverclosepn">
									<option value="" selected>Ver solicitudes</option>
									<option value="=">Cerradas</option>
									<option value="!=">Abiertas</option>
								</select>
								<input type="text" class="textbuscar" id="ambtxtbuscarpanne" name="ambtxtbuscarpanne" placeholder="Buscar por ppu, empresa...">
							</div>
							<button class="btn btn-primary" id="addpannebtn"><i class="align-middle" data-feather="calendar"></i> Crear</button></div>
						<?php } ?>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<?php if ($_SESSION['r9l']=='Administrador' || $_SESSION['r9l']=='Manager') { ?>
					<?php if($ord == '') { ?>	
					<table class="table table-hover my-0" id="tbpnn">
						<thead>
							<tr>
							<th>Fecha solicitud</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">PPU Tracto</th>
							<th class="d-none d-xl-table-cell">KM Tracto</th>
							<th class="d-none d-xl-table-cell">PPU Semi</th>
							<th class="d-none d-xl-table-cell">KM Semi</th>
							<th class="d-none d-xl-table-cell">Conductor</th>
							<td></td>
							<td></td>
							</tr>
						</thead>
						<tbody id="tbl-panne">
						
						</tbody>
						</table>
					<?php }  if($ord == 'close') { 	?>
						<table class="table table-hover my-0" id="tbpnncl">
						<thead>
							<tr>
							<th>Fecha solicitud</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">PPU Tracto</th>
							<th class="d-none d-xl-table-cell">KM Tracto</th>
							<th class="d-none d-xl-table-cell">PPU Semi</th>
							<th class="d-none d-xl-table-cell">KM Semi</th>
							<th class="d-none d-xl-table-cell">Conductor</th>
							<td></td>
							<td></td>
							</tr>
						</thead>
						<tbody id="tbl-clpanne">
						
						</tbody>
						</table>
					<?php
					} 
				}
					if ($_SESSION['r9l']=='ambipar') { 
					?>	
						<table class="table table-hover my-0">
						<thead>
							<tr>
							<th>Fecha solicitud</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">PPU Tracto</th>
							<th class="d-none d-xl-table-cell">KM Tracto</th>
							<th class="d-none d-xl-table-cell">PPU Semi</th>
							<th class="d-none d-xl-table-cell">KM Semi</th>
							<th class="d-none d-xl-table-cell">Conductor</th>
							<td></td>
							<td></td>
							</tr>
						</thead>
						<tbody id="tbl-ambipar">
						
						</tbody>
						</table>
					<?php } ?>	
					</div>
				</div>	
				<div class="row">
				<?php if ($_SESSION['r9l']=='Administrador') { ?>
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_solicitudes_panne" class="mr-25 ml-10"></div>
					</div>
				<?php } else { ?>
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_panne_ambipar" class="mr-25 ml-10"></div>
					</div>
				<?php } ?>
					<div class="paginacion">
						<ul class="pagination" id="panne-pagination">
						</ul>
					</div>	
					</div>	
						</div>

						<!--crear solicitud -->
						<div id="addpanne" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-10">
							<form id="frmpanne" class="row">
									<div class="row g-3">
										<h3>Datos de la unidad</h3>
										<div class="col-md-4 rl">
											<label for="pcnombre" class="form-label">Empresa</label>
											<input type="hidden" name="idpcnombre" id="idpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="pcnombre" id="pcnombre">   
											<ul id="lista_empresa" class="lista hide">
											</ul>
										</div>	
										<div class="col-md-4">
											<label for="ppu_semi" class="form-label">PPU</label>
											<select class="form-control" name="ppu_semi" id="ppu_semi">
												<option value="" selected>Seleccione</option>
											</select>
										</div>
										<div class="col-md-4">
											<label for="ppu_semirremolque" class="form-label">PPU SEMI</label>
											<input type="text" class="form-control" id="ppu_semirremolque" name="ppu_semirremolque">
										</div>
										
										<div class="col-md-3">
											<label for="km_actual_und" class="form-label">KM actual unidad</label>
											<input type="text" class="form-control" name="km_actual_und" id="km_actual_und">
										</div>
										<div class="col-md-3">
											<label for="km_actual_semi" class="form-label">KM actual semi</label>
											<input type="text" class="form-control" name="km_actual_semi" id="km_actual_semi">
										</div>
										<div class="col-md-3">
											<label for="fecha" class="form-label">Fecha</label>
											<input type="date" class="form-control" name="fecha" id="fecha">
										</div>
										<div class="col-md-3">
											<label for="hora" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora" id="hora">
										</div>
										<div class="col-md-3">
											<label for="servicio" class="form-label">Servicio</label>
											<select class="form-control" name="servicio" id="servicio">
												<option value="" selected>Seleccione</option>
												<option value="CAL">CAL</option>
												<option value="CCVV">CCVV</option>
												<option value="CCEE">CCEE</option>
												<option value="COCU">COCU</option>
												<option value="AI">AI</option>
												<option value="ESC">ESC</option>
											</select>
										</div>
										<div class="col-md-3">
											<label for="tipofalla" class="form-label">Tipo de falla</label>
											<select class="form-control" name="tipofalla" id="tipofalla">
												<option value="" selected>Seleccione</option>
												<option value="LEVE">LEVE</option>
												<option value="GRAVE">GRAVE</option>
											</select>
										</div>
										<div class="col-md-3">
											<label for="transportista" class="form-label">Conductor: </label>
											<input type="text" class="form-control" name="transportista" id="transportista">
										</div>
										<div class="col-md-3">
											<label for="supervisor" class="form-label">Supervisor: </label>
											<input type="text" class="form-control" name="supervisor" id="supervisor">
										</div>
										<div class="col-md-12">
											<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
											<input type="text" class="form-control" name="ubicacion" id="ubicacion">
										</div>
										<div class="col-md-12">
											<label for="falla_preliminar" class="form-label">Falla preliminar: </label>
											<div id="wysepreliminar"></div>
											<input type="hidden" name="falla_preliminar" id="falla_preliminar">
										</div>
										<div class="col-12 mt-25 mb-25">
											<button id="upd__tareas" class="btn btn-primary hide">Actualizar</button>
											<button id="sv__panne" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__panne">Regresar</button>
										</div>
										
									</div>
								</form>
							</div>
						</div>	
					</div>
					<!-- fin de solicitudes -->
					
					
					<!--comienzo de carga de solicitud de liberación -->
					<div id="addreporte" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-10">
									<div class="row g-3">
									<h3>Datos de la solicitud</h3>
									<div class="col-md-4">
											<label class="form-label">Empresa</label>
											<input type="text" autocomplete="off" class="form-control" id="empresa1" disabled>   
										</div>	
										<div class="col-md-4">
											<label class="form-label">PPU</label>
											<input class="form-control" id="ppu1" disabled>
										</div>
										<div class="col-md-4">
											<label class="form-label">PPU SEMI</label>
											<input type="text" class="form-control" id="ppus1" disabled>
										</div>
										
										<div class="col-md-3">
											<label class="form-label">KM actual unidad</label>
											<input type="text" class="form-control" id="kma1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">KM actual semi</label>
											<input type="text" class="form-control" id="kms1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Fecha</label>
											<input type="date" class="form-control" id="fecha1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Hora</label>
											<input type="time" class="form-control" id="hora1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Servicio</label>
											<input class="form-control"  id="servicio1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Tipo de falla</label>
											<input class="form-control" id="tipo_falla1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Transportista: </label>
											<input type="text" class="form-control" id="transp1" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Supervisor: </label>
											<input type="text" class="form-control" id="sup1"  disabled>
										</div>
										<div class="col-md-12">
											<label class="form-label">Ubicación de la unidad: </label>
											<input type="text" class="form-control" id="ub1" disabled>
										</div>
										<div class="col-md-12">
											<label class="form-label">Falla preliminar: </label>
											<div class="htmtexto disabled" id="falla1"></div>
										</div>	
										
										<form id="frmreporte" class="row g-3">
										<input type="hidden" name="idsolpanne" id="idsolpanne">
										<h3 class="mt-50">Solicitud de liberación</h3>
										
										<div class="col-md-12">
											<label for="pn_falla" class="form-label">Falla:</label>
											<input type="text" class="form-control" name="pn_falla" id="pn_falla">
										</div>
										<div class="col-md-12">
											<label for="pn_causa" class="form-label">Causa:</label>
											<input type="text" class="form-control" name="pn_causa" id="pn_causa">
										</div>
										<div class="col-md-12">
											<label for="pn_accion" class="form-label">Acción:</label>
											<div id="wyseaccion"></div>
											<input type="hidden" name="pn_accion" id="pn_accion">
										</div>
										<div class="col-md-12">
											<label for="pn_observaciones" class="form-label">Observaciones:</label>
											<textarea class="form-control" name="pn_observaciones" id="pn_observaciones"></textarea>
										</div>
										<div class="col-md-12">
											<label for="panne_files" class="form-label">Archivos adjuntos:</label>
											<input type="file" class="form-control" name="panne_files[]" id="panne_files" multiple>
										</div>
										
										<div class="col-12 mt-25 mb-25">
										<button id="sv__updpanne" class="btn btn-primary">Actualizar Panne</button>	
										<a href="index.php?p=panne" class="btn btn-warning" >Regresar</a>
										</div>
									</form>
										
										
										<div class="col-md-12  mb-25" id="pvpanne">

										</div>
										<hr id="hrseparador" class="hide">
										<form id="frmclosepnn" class="row g-3 hide">
										<input type="hidden" name="idsolp" id="idsolp">
										<h3>Categorización y liberación de la unidad</h3>
										
										<div class="col-md-12">
											<label for="lb_falla" class="form-label">Tipo de Falla:</label>
											<select class="form-control" name="lb_falla" id="lb_falla">
												<option value="" selected>Seleccione</option>
												<option value="LEVE">LEVE</option>
												<option value="GRAVE">GRAVE</option>
											</select>	
										</div>
										<div class="col-md-12">
											<label for="lb_accion" class="form-label">Acción tomada:</label>
											<div id="wyseliberacion"></div>
											<input type="hidden" name="lb_accion" id="lb_accion">
										</div>
										<div class="col-md-12">
											<label for="lb_observaciones" class="form-label">Observaciones:</label>
											<textarea class="form-control" name="lb_observaciones" id="lb_observaciones"></textarea>
										</div>
										<div class="col-md-12">
											<label for="lb_files" class="form-label">Archivos adjuntos:</label>
											<input type="file" class="form-control" name="lb_files[]" id="lb_files" multiple>
										</div>
										<div class="col-md-12">
											<label for="lb_files" class="form-label">Actualizar estado unidad:</label>
											<select class="form-control" name="lb_unidad" id="lb_unidad">
												<option value="" selected>Seleccione</option>
												<option value="CONDICIONADA">CONDICIONADA</option>
												<option value="MOVILIZADA">MOVILIZADA</option>
												<option value="DESMOVILIZADA">DESMOVILIZADA</option>
												<option value="LIBERADA">LIBERADA</option>
											</select>
										</div>
										<div class="col-12 mt-25 mb-25">
										<button id="sv__closepanne" class="btn btn-primary">Cerrar Panne</button>	
										<a href="index.php?p=panne" class="btn btn-warning" >Regresar</a>
										</div>
										</form>	
								</div>	
							</div>	
						</div>	
				</div>
			</div>
		</div>	
	</div>
</main>


<!-- Modal -->
<div class="modal fade" id="galleryMdl" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	<div class="modal-header">
        <h5 class="modal-title">Vista previa de imagen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    
      <div class="modal-body">
        <img id="img01" class="galleryimg">
		<div id="link_full"></div>
      </div>
    </div>
  </div>
</div>