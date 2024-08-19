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
							<h1>Taller IP</h1>
						</div>
						<div id="tblactividades">
						<div class="row">
						<?php if ($_SESSION['r9l']=='Administrador') { ?>
							<div class="col-12 d-flexj">
							<div id="complementos_tools">	
								<input type="hidden" name="ord" id="ord" value="<?= $ord; ?>">
								<select class="textbuscar" name="vercloseip" id="vercloseip">
									<option value="" selected>Ver solicitudes</option>
									<option value="=">Cerradas</option>
									<option value="!=">Abiertas</option>
								</select>
								<input type="text" class="textbuscar" id="buscartxt" name="buscartxt" placeholder="Buscar por ppu, empresa...">
							</div>
							<button class="btn btn-primary" id="addtareabtn"><i class="align-middle" data-feather="calendar"></i> Agregar</button></div>
						<?php } ?>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<?php if ($_SESSION['r9l']=='Administrador' || $_SESSION['r9l']=='Manager') { ?>
					<table class="table table-hover my-0" id="tblip">
						<thead>
							<tr>
							<th>Fecha solicitud</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">Patente</th>
							<th class="d-none d-xl-table-cell">KM Actual</th>
							<th class="d-none d-xl-table-cell">Estado Unidad</th>
							<th class="d-none d-xl-table-cell">Fecha Ú.M.</th>
							<th class="d-none d-xl-table-cell">Servicio</th>
							<th class="d-none d-xl-table-cell">Inspector</th>
							<th></th>
							</tr>
						</thead>
						<tbody id="tbl-actividadesip">
						
						</tbody>
						</table>
					<?php } else { ?>	
						<table class="table table-hover my-0">
						<thead>
							<tr>
							<th>Fecha de visita</th>
							<th>Hora</th>
							<th>Empresa</th>
							<th class="d-none d-xl-table-cell">Tipo de equipo</th>
							<th class="d-none d-xl-table-cell">PPU</th>
							<th class="d-none d-xl-table-cell">Ubicación</th>
							<th class="d-none d-xl-table-cell">Estado</th>
							<th></th>
							</tr>
						</thead>
						<tbody id="tbl-actividadesinsp">
						
						</tbody>
						</table>
					<?php } ?>	
					</div>
				</div>	
				<div class="row">
				<?php if ($_SESSION['r9l']=='Administrador' || $_SESSION['r9l']=='Manager') { ?>
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_solicitudes" class="mr-25 ml-10"></div>
					</div>
				<?php } else { ?>
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_actividadesinsp" class="mr-25 ml-10"></div>
					</div>
				<?php } ?>
					<div class="paginacion">
						<ul class="pagination" id="actividadesip-pagination">
						</ul>
						
					</div>	
					</div>	
						</div>
						<!--crear solicitud -->
						<div id="addsolicitud" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-10">
							<form id="frmsolicitud" class="row">
									<div class="row g-3">
										<h3>Datos de la unidad</h3>
										<div class="col-md-6 rl">
											<label for="pcnombre" class="form-label">Empresa</label>
											<input type="hidden" name="idpcnombre" id="idpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="pcnombre" id="pcnombre">   
											<ul id="lista_empresa" class="lista hide">
											</ul>
										</div>	
										<div class="col-md-6">
											<label for="ppu_semi" class="form-label">PPU</label>
											<select class="form-control" name="ppu_semi" id="ppu_semi">
												<option value="" selected>Seleccione</option>
											</select>
										</div>
										<div class="col-md-6">
											<label for="tipo" class="form-label">Tipo de solicitud</label>
											<select class="form-control" name="tipo" id="tipo">
												<option value="" selected>Seleccione</option>
												<option value="IP">IP</option>
												<option value="PM">PM</option>
											</select>
										</div>
										<div class="col-md-6">
											<label for="estatus" class="form-label">Estado unidad</label>
											<select class="form-control" name="estatus" id="estatus">
												<option value="" selected>Seleccione</option>
												<option value="LIBERADO">LIBERADA</option>
												<option value="DESMOVILIZADO">DESMOVILIZADA</option>
												<option value="MOVILIZADO">MOVILIZADA</option>
												<option value="CONDICIONADO">CONDICIONADA</option>
											</select>
											</select>
										</div>
										<div class="col-md-3">
											<label for="km_actual" class="form-label">KM actual</label>
											<input type="text" class="form-control" name="km_actual" id="km_actual">
										</div>
										<div class="col-md-3">
											<label for="km_ultima" class="form-label">KM última man.</label>
											<input type="text" class="form-control" name="km_ultima" id="km_ultima">
										</div>
										<div class="col-md-3">
											<label for="fecha_ultima" class="form-label">Fecha últ. man.</label>
											<input type="date" class="form-control" name="fecha_ultima" id="fecha_ultima">
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
										<div class="col-md-6">
											<label for="taller" class="form-label">Taller</label>
											<input type="text" class="form-control" name="taller" id="taller">
										</div>
										<div class="col-md-6 actdlls">
											<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
											<input type="text" class="form-control" name="ubicacion" id="ubicacion" placeholder="Ingresa la ubicación de la unidad">
										</div>
										<div class="col-md-12">
											<label for="observaciones" class="form-label">Observaciones: </label>
											<textarea class="form-control" name="observaciones" id="observaciones"></textarea>
										</div>
										<div class="col-12 mt-25 mb-25">
											<input type="hidden" name="idactividad" id="idactividad">
											<button id="upd__tareas" class="btn btn-primary hide">Actualizar</button>
											<button id="sv__tareas" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__sol">Regresar</button>
										</div>
									</div>
								</form>
							</div>
						</div>	
					</div>
					<!-- fin de solicitudes -->

					<!--comienzo de asignacion de inspectores -->
					<div id="addasignacion" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-10">
								<form id="frmasignacion" class="row">
									<div class="row g-3">
									<h3>Datos de la unidades <span class="ocultar_dv" id="dtllssolc">Ver detalles</span></h3>
										<div class="col-md-4 rl dtllssol">
											<label for="solpcnombre" class="form-label">Empresa</label>
											<input type="hidden" name="idsol" id="idsol">
											<input type="hidden" name="solidpcnombre" id="solidpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="solpcnombre" id="solpcnombre" disabled>   
										</div>	
										<div class="col-md-4 dtllssol">
											<label for="solppu_semi" class="form-label">PPU</label>
											<input type="text" class="form-control" name="solppu_semi" id="solppu_semi" disabled>
										</div>
										<div class="col-md-4 dtllssol">
												<label for="soltipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" name="soltipo" id="soltipo" disabled>
											</div>
										<div id="detalles_unidad" class="row g-3">
											<div class="col-md-3 dtllssol">
												<label for="solkm_actual" class="form-label">KM actual</label>
												<input type="text" class="form-control" name="solkm_actual" id="solkm_actual" disabled>
											</div>
											<div class="col-md-3 dtllssol">
												<label for="solkm_ultima" class="form-label">KM última man.</label>
												<input type="text" class="form-control" name="solkm_ultima" id="solkm_ultima" disabled>
											</div>
											<div class="col-md-3 dtllssol">
												<label for="solfecha_ultima" class="form-label">Fecha últ. man.</label>
												<input type="date" class="form-control" name="solfecha_ultima" id="solfecha_ultima" disabled>
											</div>
											<div class="col-md-3 dtllssol">
												<label for="solservicio" class="form-label">Servicio</label>
												<input type="text" class="form-control" name="solservicio" id="solservicio" disabled>
											</div>
											<div class="col-md-6 dtllssol">
											<label for="soltaller" class="form-label">Taller</label>
											<input type="text" class="form-control" name="soltaller" id="soltaller" disabled>
											</div>
											<div class="col-md-6 dtllssol">
												<label for="solubicacion" class="form-label">Ubicación de la unidad: </label>
												<input type="text" class="form-control" name="solubicacion" id="solubicacion" disabled>
											</div>
											<div class="col-md-12 dtllssol">
												<label for="solobservaciones" class="form-label">Observaciones: </label>
												<textarea class="form-control" name="solobservaciones" id="solobservaciones" disabled></textarea>
											</div>
										</div>
										<h3 class="mt-25">Datos de la actividad <span class="ocultar_dv" id="dactividad">Ver detalles</span></h3>
										<div class="col-md-4 actdlls">
											<label for="fecha_solicitud" class="form-label">Fecha Solicitud</label>
											<input type="date" class="form-control" name="fecha_solicitud" id="fecha_solicitud" disabled>
										</div>
										<div class="col-md-4 actdlls">
											<label for="fecha_agendada" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_agendada" id="fecha_agendada">
										</div>
										<div class="col-md-4 actdlls">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada">
										</div>
										<div class="col-md-3 actdlls">
											<label for="semana" class="form-label">Semana</label>
											<input type="number" class="form-control" name="semana" id="semana">
										</div>
										<div class="col-md-9 rl actdlls">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" placeholder="Ingresa el nombre del inspector">
											<input type="hidden" name="idinspector" id="idinspector">
											<ul class="lista hide" id="lista_inspectores"></ul>
											<div class="ipselected" id="ipseleccionados"></div>	
											
										</div>
										<div class="col-md-6 actdlls">
											<label for="solicitado" class="form-label">Solicitado por: </label>
											<input type="text" class="form-control" name="solicitado" id="solicitado">
										</div>
										<div class="col-md-6 actdlls">
											<label for="aprobado_por" class="form-label">Aprobado por: </label>
											<input type="text" class="form-control" name="aprobado_por" id="aprobado_por">
										</div>
										<div class="col-12 mt-25 mb-25">
																						
											<button id="upd__asignacion" class="btn btn-primary hide">Actualizar</button>
											<button id="sv__asignacion" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__asignacion">Regresar</button>
										</div>
									</div>	
								</form>	
							</div>	
						</div>	
					</div>	
					<!--fin de asignacion de inspectores -->

					<!--comienzo de carga de actividades -->
					<div id="addreporte" class="hide">
						<div class="row mt-25">
							<div class="col-10 col-md-10">
								
									<div class="row g-3">
									<h3>Datos de la unidades <span class="ocultar_dv" id="dtllssolc">Ver detalles</span></h3>
										<div class="col-md-4 rl dtllssol">
											<label for="rppcnombre" class="form-label">Empresa</label>
											
											<input type="text" autocomplete="off" class="form-control" id="rppcnombre" disabled>   
										</div>	
										<div class="col-md-4 dtllssol">
											<label class="form-label">PPU</label>
											<input type="text" class="form-control" id="rpppu_semi" disabled>
										</div>
										<div class="col-md-4 dtllssol">
												<label for="soltipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" id="rptipo" disabled>
											</div>
										<div id="detalles_unidad" class="row g-3">
											<div class="col-md-3 dtllssol">
												<label for="solkm_actual" class="form-label">KM actual</label>
												<input type="text" class="form-control" id="rpkm_actual" disabled>
											</div>
											<div class="col-md-3 dtllssol">
												<label for="solkm_ultima" class="form-label">KM última man.</label>
												<input type="text" class="form-control" id="rpkm_ultima" disabled>
											</div>
											<div class="col-md-3 dtllssol">
												<label for="solfecha_ultima" class="form-label">Fecha últ. man.</label>
												<input type="date" class="form-control" id="rpfecha_ultima" disabled>
											</div>
											<div class="col-md-3 dtllssol">
												<label for="solservicio" class="form-label">Servicio</label>
												<input type="text" class="form-control" id="rpservicio" disabled>
											</div>
											<div class="col-md-6 dtllssol">
											<label  class="form-label">Taller</label>
											<input type="text" class="form-control" id="rptaller" disabled>
											</div>
											<div class="col-md-6 dtllssol">
												<label class="form-label">Ubicación de la unidad: </label>
												<input type="text" class="form-control" id="rpubicacion" disabled>
											</div>
											<div class="col-md-12 dtllssol">
												<label class="form-label">Observaciones: </label>
												
												<textarea class="form-control" id="rpobservaciones" disabled></textarea>
											</div>
										</div>
										<h3 class="mt-25">Datos de la actividad <span class="ocultar_dv" id="dactividad">Ver detalles</span></h3>
										<div class="col-md-4 actdlls">
											<label class="form-label">Fecha Solicitud</label>
											<input type="date" class="form-control" id="rpfecha_solicitud" disabled>
										</div>
										<div class="col-md-4 actdlls">
											<label class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" id="rpfecha_agendada">
										</div>
										<div class="col-md-4 actdlls">
											<label  class="form-label">Hora</label>
											<input type="time" class="form-control"  id="rphora_agendada">
										</div>
										<div class="col-md-3 actdlls">
											<label class="form-label">Semana</label>
											<input type="number" class="form-control" id="rpsemana">
										</div>
										<div class="col-md-9 rl actdlls">
											<label class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" id="rpinspector">
											
										</div>
										<div class="col-md-6 actdlls">
											<label class="form-label">Solicitado por: </label>
											<input type="text" class="form-control" id="rpsolicitado">
										</div>
										<div class="col-md-6 actdlls">
											<label class="form-label">Aprobado por: </label>
											<input type="text" class="form-control" id="rpaprobado_por">
										</div>
									</div>	
									
									<form id="frmcloseip" class="hide row g-3">
									<input type="hidden" name="cl_idsol" id="cl_idsol">
									<h3 class="mt-50">Cierre de la actividad</h3>
										<div class="col-md-6">
											<label for="cl_edo_unidad" class="form-label">Actualizar Estado Unidad: </label>
											<select class="form-control" name="cl_edo_unidad" id="cl_edo_unidad">
												<option value="" selected>Seleccione</option>
												<option value="CONDICIONADA">CONDICIONADA</option>
												<option value="DESMOVILIZADA">DESMOVILIZADA</option>
												<option value="MOVILIZADA">MOVILIZADA</option>
												<option value="LIBERADA">LIBERADA</option>
												
											</select>
										</div>
										<div class="col-md-6" id="cl_motivo">
											<label for="cl_motivo" class="form-label">Motivo:</label>
											<input type="text" class="form-control" name="cl_motivo" id="cl_motivo">
										</div>
										<div class="col-md-12">
											<label for="cl_observaciones" class="form-label">Observaciones:</label>
											<textarea class="form-control" name="cl_observaciones" id="cl_observaciones"></textarea>
										</div>
										<div class="col-12 mt-25 mb-25">
										<button id="sv__cerrarip" class="btn btn-success">Cerrar Actividad</button>	
											<a href="index.php?p=tallerip" class="btn btn-warning" id="back__asignacion">Regresar</a>
										</div>
									</form>	
									<div class="row g-3">
										<div class="mt-25 hide" id="resumen_actividades">
										<h3 class="mt-25">Historial de cambios</h3>
											<table class="table table-striped">
												<tbody id="tr-actividad">
												
												</tbody>
											</table>	
										</div>
									</div>
									<form id="frmreporte" class="hide row g-3">
									<input type="hidden" name="rpidsol" id="rpidsol">
									<input type="hidden" name="rpidpcnombre" id="rpidpcnombre">
									<h3 class="mt-50">Reporte de la actividad</h3>
										<div class="col-md-3">
											<label for="ip_fecha_inicio" class="form-label">Fecha inspección: </label>
											<input type="date" class="form-control" name="ip_fecha_inicio" id="ip_fecha_inicio">
										</div>
										<div class="col-md-3">
											<label for="ip_hora_inicio" class="form-label">Hora inspección: </label>
											<input type="time" class="form-control" name="ip_hora_inicio" id="ip_hora_inicio">
										</div>
										<div class="col-md-3">
											<label for="ip_superviso" class="form-label">Realizó supervisión: </label>
											<select class="form-control" name="ip_superviso" id="ip_superviso">
												<option value="" selected>Seleccione</option>
												<option value="Si">Si</option>
												<option value="No">No</option>
											</select>
										</div>
										<div class="col-md-3">
											<label for="ip_edo_unidad" class="form-label">Actualizar Estado Unidad: </label>
											<select class="form-control" name="ip_edo_unidad" id="ip_edo_unidad">
												<option value="" selected>Seleccione</option>
												<option value="Condicionado">Condicionado</option>
												<option value="Movilizada">Movilizada</option>
												<option value="Desmovilizada">Desmovilizada</option>
											</select>
										</div>
										<div class="col-md-12 hide" id="io_motivo">
											<label for="ip_motivo" class="form-label">Motivo:</label>
											<input type="text" class="form-control" name="ip_motivo" id="ip_motivo">
										</div>
										<div class="col-md-12">
											<div id="tallerip"></div>
											<input type="hidden" name="ip_texto" id="ip_texto">
										</div>
										<div class="col-md-12">
											<label for="ip_files" class="form-label">Archivos adjuntos:</label>
											<input type="file" class="form-control" name="ip_files[]" id="ip_files" multiple>
										</div>
										
										<div class="col-12 mt-25 mb-25">
										<button id="sv__actividad" class="btn btn-primary hide">Actualizar Actividad</button>	
											<a href="index.php?p=tallerip" class="btn btn-warning" id="back__asignacion">Regresar</a>
										</div>
									</form>	
							</div>	
						</div>	
					</div>	
					<!-- fin de carga de actividades-->

					


					
				</div>
			</div>
		</div>	
	</div>
</main>


<!-- Modal -->
<div class="modal fade" id="galleryMdl" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <img id="img01" class="galleryimg">
		<div id="link_full"></div>
      </div>
    </div>
  </div>
</div>