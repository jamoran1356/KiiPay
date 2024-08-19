<?php 

require_once 'models/actividades.php';
$pg = isset($_GET['pg']) ? $_GET['pg'] : 1;
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$page = isset($_GET['cat']) ? $_GET['cat'] : '';


?>
<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
						<?php 
						switch ($page) {
							case 'ip':
								$ac = new Actividad();
								$rs = $ac ->obtener_solicitud_id($id);
						?>								
						<div class="text-center mt-4">
							<h1>Detalles de solicitud #<?= $id; ?> - <?= $rs[0]['tipo_servicio']; ?> </h1>
						</div>
						<!--Mostrar detalles -->
						<div id="addsolicitud">
						<div class="row">
							<div class="col-10 col-md-10">
							<div class="row">
									<div class="row g-3">
										<h3>Datos de la unidad</h3>
										<div class="col-md-6 rl">
											<label for="pcnombre" class="form-label">Empresa</label>
											<input type="hidden" name="idpcnombre" id="idpcnombre">
											<input type="text" autocomplete="off" class="form-control" name="pcnombre" id="pcnombre" value="<?= $rs[0]['empresa']; ?>" disabled>   
										</div>	
										<div class="col-md-6">
											<label for="ppu_semi" class="form-label">PPU</label>
											<input type="text" class="form-control" name="ppu_semi" id="ppu_semi" value="<?= $rs[0]['ppu']; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="tipo" class="form-label">Tipo de solicitud</label>
											<input type="text" class="form-control" name="tipo" id="tipo" value="<?= $rs[0]['tipo_servicio']; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="estatus" class="form-label">Estado unidad</label>
											<input type="text" class="form-control" name="estatus" id="estatus" value="<?= $rs[0]['estado_unidad']; ?>" disabled>
										</div>
										<div class="col-md-3">
											<label for="km_actual" class="form-label">KM actual</label>
											<input type="text" class="form-control" name="km_actual" id="km_actual" value="<?= $rs[0]['km_actual']; ?>" disabled>
										</div>
										<div class="col-md-3">
											<label for="km_ultima" class="form-label">KM última man.</label>
											<input type="text" class="form-control" name="km_ultima" id="km_ultima" value="<?= $rs[0]['km_ultima']; ?>" disabled>
										</div>
										<div class="col-md-3">
											<label for="fecha_ultima" class="form-label">Fecha últ. man.</label>
											<input type="date" class="form-control" name="fecha_ultima" id="fecha_ultima" value="<?= $rs[0]['fecha_ultima']; ?>" disabled>
										</div>
										<div class="col-md-3">
											<label for="servicio" class="form-label">Servicio</label>
											<input type="text" class="form-control" name="servicio" id="servicio" value="<?= $rs[0]['contrato']; ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="taller" class="form-label">Taller</label>
											<input type="text" class="form-control" name="taller" id="taller" value="<?= $rs[0]['taller']; ?>" disabled>
										</div>
										<div class="col-md-6 actdlls">
											<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
											<input type="text" class="form-control" name="ubicacion" id="ubicacion"  value="<?= $rs[0]['ubicacion']; ?>" disabled>
										</div>
										<div class="col-md-12">
											<label for="observaciones" class="form-label">Observaciones: </label>
											<textarea class="form-control" name="observaciones" id="observaciones" disabled><?= $rs[0]['observaciones']; ?></textarea>
										</div>
										<div class="col-md-12">
											<?php 
											//cierre de la actividad
											$cl = $ac ->obtener_cierre($id);
											if(!empty($cl)) { 
											?>
											<div class="anuncio">
												Esta actividad ha sido cerrada el día <strong><?= $cl[0]['fecha_cierre']; ?></strong> por <strong><?= $cl[0]['nombre']; ?>  <?= $cl[0]['apellido']; ?></strong> con el siguiente comentario:<br> 
												<p><?= $cl[0]['observaciones']; ?></p>
												<u>Estado de la Unidad:</u> <strong><?= $cl[0]['estado_unidad']; ?></strong>
											</div>
											<?php } //fin cierre actividad ?>
										</div>
										<div class="col-md-12 mt-50">
											<h2>Historial de actividades</h2>
										</div>
										<div class="col-md-12">
											<h3>Datos de la inspección:</h3>
										</div>
										<div class="col-md-4 actdlls">
											<label for="fecha_solicitud" class="form-label">Fecha Solicitud</label>
											<input type="date" class="form-control" name="fecha_solicitud" id="fecha_solicitud" value="<?= $rs[0]['fecha_solicitud']; ?>" disabled>
										</div>
										<div class="col-md-4 actdlls">
											<label for="fecha_agendada" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_agendada" id="fecha_agendada" value="<?= $rs[0]['fecha_revision']; ?>" disabled>
										</div>
										<div class="col-md-4 actdlls">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada" value="<?= $rs[0]['hora']; ?>" disabled>
										</div>
										<div class="col-md-3 actdlls">
											<label for="semana" class="form-label">Semana</label>
											<input type="number" class="form-control" name="semana" id="semana" value="<?= $rs[0]['semana']; ?>" disabled>
										</div>
										<div class="col-md-9 rl actdlls">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" value="<?= $rs[0]['semana']; ?>" disabled>
										</div>
										<div class="col-md-6 actdlls">
											<label for="solicitado" class="form-label">Solicitado por: </label>
											<input type="text" class="form-control" name="solicitado" id="solicitado" value="<?= $rs[0]['solicitado_por']; ?>" disabled>
										</div>
										<div class="col-md-6 actdlls">
											<label for="aprobado_por" class="form-label">Aprobado por: </label>
											<input type="text" class="form-control" name="aprobado_por" id="aprobado_por" value="<?= $rs[0]['autorizado_por']; ?>" disabled>
										</div>
										<div class="col-md-12">
										<h3 class="mt-25">Historial de actividades</h3>
											<table class="table table-striped mb-25">
												<tbody id="tr-actividad">
													<?php 
													$hc = $ac ->mostrar_actualizaciones($id);
													if(!empty($hc)) { //inicio if
														foreach($hc as $h) { //inicio foreach
															
													?>
													<tr>
														<td>
															<div class="row g-3 show-result">
																<div class="col-md-4">
																<label class="form-label">Fecha inspección: </label>
																<input type="date" class="form-control" value="<?= $h['fecha_inspeccion']; ?>" disabled>
																</div> 
																<div class="col-md-4">
																<label class="form-label">Realizó inspección: </label>
																<input type="text" class="form-control" value="<?= $h['realizo']; ?>" disabled>
																</div>
																<div class="col-md-4">
																<label class="form-label">Estado unidad: </label>
																<input type="text" class="form-control" value="<?= $h['estado_unidad_sugerido']; ?>" disabled>
																</div>
																<?php if(!empty($h['motivo'])){ //inicio if motivo ?>
																<div class="col-md-12">
																<label class="form-label">Motivo en caso de no haber realizado la inspección: </label>
																<input type="text" class="form-control" value="<?= $h['motivo']; ?>" disabled>
																</div>
																<?php } //fin if motivo?>
																<div class="col-md-12">
																<div class="htmtexto"><?= $h['observaciones']; ?></div>
																</div>
																<div class="col-md-12">
																<h4>Archivos adjuntos:</h4>
																<div id="archivosList" class="show-archivos">
																<?php
																	if(isset($h['archivo'])) { //inicio if adjuntos
																	foreach($h['archivo'][0] as $element) { //inicio foreach adjuntos
																		$extension = pathinfo($element['archivo'], PATHINFO_EXTENSION);

																		if($extension === 'jpg' || $extension === 'gif' || $extension === 'png') {
																		echo "<a href='#' onclick='openModal(\"assest/clientes/IP/{$h['idsolicitud']}/{$element['archivo']}\")'>";
																		echo "<img src='assest/clientes/IP/{$h['idsolicitud']}/{$element['archivo']}' />";
																		echo "</a>";
																		}

																		if($extension === 'doc' || $extension === 'docx') {
																		echo "<a href='assest/clientes/IP/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
																		echo $element['archivo'];
																		echo "</a>";
																		}
																		if($extension === 'pdf') {
																		echo "<a href='assest/clientes/IP/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
																		echo $element['archivo'];
																		echo "</a>";
																		}
																	} //fin foreach adjuntos
																	} // fin if adjuntos
																	else {
																	echo "No hay archivos adjuntos";
																	}
                													?>
																	</div>
																</div>
																<div class="col-md-12 d-flexj"><div id="fecha">Actualizado el día <?= $h['fecha_actualizado']; ?> por <strong><?= $h['nombre']. ' '.$h['apellido']; ?></strong></div></div>
															</div></td>
														</tr>
													<?php } //fin foreach
													} //fin if
													else {
														echo "<tr><td>No hay actividades registradas</td></tr>";
													} ?>		
												</tbody>
											</table>	
										</div>
										<div class="col-12 mt-25 mb-25">
											<a href="index.php?p=tallerip&od=close" class="btn btn-warning">Regresar</a>
										</div>
										</div>

									</div>
							</div>
						</div>		
						<?php
								break;

							case 'panne':
							$pn = new Actividad();
							$rs = $pn ->obtener_detalle_panne_id($id);	
						?>
						<div class="row g-3">
									<h3>Datos de la solicitud</h3>
									<div class="col-md-4">
											<label class="form-label">Empresa</label>
											<input type="text" autocomplete="off" class="form-control" id="empresa1" value="<?= $rs[0]['empresa'] ?>" disabled>   
										</div>	
										<div class="col-md-4">
											<label class="form-label">PPU</label>
											<input class="form-control" id="ppu1" value="<?= $rs[0]['ppu'] ?>" disabled>
										</div>
										<div class="col-md-4">
											<label class="form-label">PPU SEMI</label>
											<input type="text" class="form-control" id="ppus1"  value="<?= $rs[0]['ppu_semi'] ?>" disabled>
										</div>
										
										<div class="col-md-3">
											<label class="form-label">KM actual unidad</label>
											<input type="text" class="form-control" id="kma1" value="<?= $rs[0]['km_actual_tracto'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">KM actual semi</label>
											<input type="text" class="form-control" id="kms1" value="<?= $rs[0]['km_actual_semi'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Fecha</label>
											<input type="date" class="form-control" id="fecha1" value="<?= $rs[0]['fecha'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Hora</label>
											<input type="time" class="form-control" id="hora1" value="<?= $rs[0]['hora'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Servicio</label>
											<input class="form-control"  id="servicio1" value="<?= $rs[0]['servicio'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Tipo de falla</label>
											<input class="form-control" id="tipo_falla1" value="<?= $rs[0]['tipo_falla'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Transportista: </label>
											<input type="text" class="form-control" id="transp1" value="<?= $rs[0]['transportista'] ?>" disabled>
										</div>
										<div class="col-md-3">
											<label class="form-label">Supervisor: </label>
											<input type="text" class="form-control" id="sup1" value="<?= $rs[0]['supervisor'] ?>"  disabled>
										</div>
										<div class="col-md-12">
											<label class="form-label">Ubicación de la unidad: </label>
											<input type="text" class="form-control" id="ub1" value="<?= $rs[0]['ubicacion'] ?>" disabled>
										</div>
										<div class="col-md-12">
											<label class="form-label">Falla preliminar: </label>
											<div class="htmtexto disabled"><?= $rs[0]['falla_preliminar'] ?></div>
										</div>	
										<hr class="mt-25">
										<h3>Solicitud de liberación</h3>
										<div class="col-md-12">
											<label for="pn_falla" class="form-label">Falla:</label>
											<input type="text" class="form-control" name="pn_falla" id="pn_falla" value="<?= $rs[0]['falla'] ?>" disabled>
										</div>
										<div class="col-md-12">
											<label for="pn_causa" class="form-label">Causa:</label>
											<input type="text" class="form-control" name="pn_causa" id="pn_causa" value="<?= $rs[0]['causa'] ?>" disabled>
										</div>
										<div class="col-md-12">
											<label for="pn_accion" class="form-label">Acción:</label>
											<div class="htmtexto disabled"><?= $rs[0]['accion'] ?></div>
										</div>
										<div class="col-md-12">
											<label for="pn_observaciones" class="form-label">Observaciones:</label>
											<textarea class="form-control" name="pn_observaciones" id="pn_observaciones" disabled><?= $rs[0]['observaciones'] ?></textarea>
										</div>
										<div class="col-md-6">
											<label for="pn_fecha" class="form-label">Fecha solicitud:</label>
											<input type="date" class="form-control" name="pn_fecha" id="pn_fecha" value="<?= $rs[0]['fecha'] ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="pn_solicitado" class="form-label">Creado por:</label>
											<input type="text" class="form-control" name="pn_solicitado" id="pn_solicitado" value="<?= $rs[0]['nombre'] ?> <?= $rs[0]['apellido'] ?> " disabled>
										</div>
										<div class="col-md-12">
										<h4>Archivos adjuntos:</h4>
										<div id="archivosList" class="show-archivos">
										<?php
										$file = $pn -> obtener_adjuntos_panne($id);
										if(!empty($file)){
										foreach ($file as $element) {
											$extension = pathinfo($element['archivo'], PATHINFO_EXTENSION);
											if($extension === 'jpeg' || $extension === 'jpg' || $extension === 'gif' || $extension === 'png') {
											echo "<a href='#' onclick='openModal(\"assest/clientes/panne/{$element['idactividad']}/{$element['archivo']}\")'>";
											echo "<img src='assest/clientes/panne/{$element['idactividad']}/{$element['archivo']}' />";
											echo "</a>";
											}
											if($extension === 'doc' || $extension === 'docx') {
											echo "<a href='assest/clientes/panne/{$element['idactividad']}/{$element['archivo']}' target='_blank'>";
											echo $element['archivo'];
											echo "</a>";
											}
											if($extension === 'pdf') {
											echo "<a href='assest/clientes/panne/{$element['idactividad']}/{$element['archivo']}' target='_blank'>";
											echo $element['archivo'];
											echo "</a>";
											}
										}
										}	
										
										?>
											</div>
											
										</div>
										
										<hr class="mt-25">
										<h3>Categorización y liberación de la unidad</h3>
										
										<div class="col-md-12">
											<label for="cl_falla" class="form-label">Tipo de Falla:</label>
											<input type="text" class="form-control" name="cl_falla" value="<?= $rs[0]['falla_tecnica'] ?>" disabled>	
										</div>
										<div class="col-md-12">
											<label for="cl_accion" class="form-label">Acción tomada:</label>
											<div class="htmtexto disabled"><?= $rs[0]['accion_tecnica'] ?></div>
										</div>
										<div class="col-md-12">
											<label for="cl_observaciones" class="form-label">Observaciones:</label>
											<textarea class="form-control" name="cl_observaciones" id="cl_observaciones" disabled><?= $rs[0]['observaciones_cierre'] ?></textarea>
										</div>
										<div class="col-md-12">
											<label for="lb_files" class="form-label">Estado actual de la unidad:</label>
											<input type="text" class="form-control" name="cl_estado" value="<?= $rs[0]['unidad_cierre']?>" disabled>
										</div>
										
												<?php
												$adjunto = $pn -> mostrar_adjuntos_cierre($id);
												if(!empty($adjunto[0]['archivo'])){
													echo '<div class="col-md-12">
													<label for="lb_files" class="form-label">Adjuntos:</label>
													<div id="archivosList" class="show-archivos">';
												foreach ($adjunto as $element) {
														$extension = pathinfo($element['archivo'], PATHINFO_EXTENSION);
														if($extension === 'webp' || $extension === 'jpeg' || $extension === 'jpg' || $extension === 'gif' || $extension === 'png') {
														echo "<a href='#' onclick='openModal(\"assest/clientes/panne/{$id}/{$element['archivo']}\")'>";
														echo "<img src='assest/clientes/panne/{$id}/{$element['archivo']}' />";
														echo "</a>";
														}
														if($extension === 'doc' || $extension === 'docx') {
														echo "<a href='assest/clientes/panne/{$id}/{$element['archivo']}' target='_blank'>";
														echo $element['archivo'];
														echo "</a>";
														}
														if($extension === 'pdf') {
														echo "<a href='assest/clientes/panne/{$id}/{$element['archivo']}' target='_blank'>";
														echo $element['archivo'];
														echo "</a>";
														}
												}
												echo '</div></div>';
												}
												else {
													echo '<div class="col-md-12">
													<label for="lb_files" class="form-label">Adjuntos:</label>
													<p>No hay archivos adjuntos</p>
													</div>';
												}
												?>
										</div>
										<div class="col-12 mt-25 mb-25">
										<a href="index.php?p=panne&od=close" class="btn btn-warning" >Regresar</a>
										</div>
						<?php
							break;
						?>	
						<?php } ?>
					</div>
					<!-- fin de detalles -->
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