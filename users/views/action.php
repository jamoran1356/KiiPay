<?php 
require_once 'models/clientes.php';
require_once 'models/actividades.php';

$idunidad = isset($_GET['id']) ? $_GET['id'] : 0;
$idspot = isset($_GET['idspot']) ? $_GET['idspot'] : 0;

$pg = isset($_GET['at']) ? $_GET['at'] : "";

$cn = new Clientes();
$nm = $cn->obtener_datos_unidad($idunidad);

$act = new Actividad();

?>
<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
					<?php 
						switch ($pg) {
							case 'addspot':
					?>
					
						<div class="text-center mt-4">
							<h1>Spot</h1>
						</div>
						<!--agregar unidades -->
						<!--comienzo de asignacion de inspectores -->

					<div id="addspot">
						<div class="row">
							<div class="col-10 col-md-10">
								<form id="frmspot" class="row">
									<div class="row g-3">
										<div class="col-md-4 rl dtllssol">
											<label for="empresa" class="form-label">Empresa</label>
											<input type="hidden" name="idunidad" id="idunidad" value="<?= $idunidad; ?>">
											<input type="text" class="form-control" name="empresa" id="empresa" value="<?= $nm['nombre']; ?>" disabled>
										</div>	
										<div class="col-md-4 dtllssol">
											<label for="ppu" class="form-label">PPU</label>
											<input type="text" class="form-control" name="ppu" id="ppu" value="<?= $nm['ppu']; ?>" disabled>
										</div>
										<div class="col-md-4">
												<label for="tipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" name="tipo" id="tipo" value="<?= $nm['tipo']; ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="servicios" class="form-label">Servicio</label>
												<select class="form-control" name="servicios" id="servicios">
													<option value="" selected>Seleccione</option>
													<option value="CAL">CAL</option>
													<option value="CONCENTRADO">CONCENTRADO</option>
													<option value="ESCORIA">ESCORIA</option>
													<option value="CARGAS ESPECIALES">CARGAS ESPECIALES</option>
													<option value="CARGAS VARIAS">CARGAS VARIAS</option>
												</select>
											</div>
											<div class="col-md-6">
												<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
												<input type="text" class="form-control" name="ubicacion" id="ubicacion">
											</div>
										<div class="col-md-6">
											<label for="fecha_revision" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_revision" id="fecha_revision">
										</div>
										<div class="col-md-6">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada">
										</div>
										<div class="col-md-12 rl">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" placeholder="Ingresa el nombre del inspector">
											<input type="hidden" name="idinspector" id="idinspector">
											<ul class="lista hide" id="lista_inspectores"></ul>
											<div class="ipselected" id="ipseleccionados"></div>	
											
										</div>
										<div class="col-12 mt-25 mb-25">
																						
											<button id="upd__spot" class="btn btn-primary hide">Actualizar</button>
											<button id="sv__spot" class="btn btn-primary">Guardar</button>
											<button class="btn btn-warning" id="back__spot">Regresar</button>
										</div>
									</div>	
								</form>	
							</div>	
						</div>	
					<?php
						break;

						case 'updtspot':
						$sp = $act->obtener_solicitud_spot($idspot);	

					?>											
					<div class="text-center mt-4">
						<h1>Spot</h1>
					</div>
						<div class="row">
							<div class="col-10 col-md-10">
									<div class="row g-3">
										<div class="col-md-4 rl dtllssol">
											<label for="empresa" class="form-label">Empresa</label>
											<input type="hidden" name="idunidad" id="idunidad" value="<?= $idunidad; ?>">
											<input type="text" class="form-control" name="empresa" id="empresa" value="<?= $nm['nombre']; ?>" disabled>
										</div>	
										<div class="col-md-4 dtllssol">
											<label for="ppu" class="form-label">PPU</label>
											<input type="text" class="form-control" name="ppu" id="ppu" value="<?= $nm['ppu']; ?>" disabled>
										</div>
										<div class="col-md-4">
												<label for="tipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" name="tipo" id="tipo" value="<?= $nm['tipo']; ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="servicios" class="form-label">Servicio</label>
												<input type="text" class="form-control" id="servicios" value="<?= $sp[0]['servicios'] ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
												<input type="text" class="form-control" name="ubicacion" id="ubicacion" value="<?= $sp[0]['ubicacion'] ?>" disabled>
											</div>
										<div class="col-md-6">
											<label for="fecha_revision" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_revision" id="fecha_revision" value="<?= $sp[0]['fecha_programado'] ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada" value="<?= $sp[0]['hora_agendada'] ?>" disabled>
										</div>
										<div class="col-md-12 rl">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" value="<?= $sp[0]['insnombre'] ?> <?= $sp[0]['insapellido'] ?>" disabled>
										</div>
										<!-- mostrar actividades anteriores -->
										<?php
        $hc = $act->mostrar_actualizaciones_spot($idspot);
		if(!empty($hc)) { //inicio if
		?>
            <div class="col-md-12">
                <h3 class="mt-25">Historial de actividades</h3>
                    <table class="table table-striped mb-25">
                        <tbody id="tr-actividad">
                            <?php 
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

                                                if($extension === 'jpeg' ||$extension === 'jpg' || $extension === 'gif' || $extension === 'png') {
                                                echo "<a href='#' onclick='openModal(\"assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}\")'>";
                                                echo "<img src='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' />";
                                                echo "</a>";
                                                }

                                                if($extension === 'doc' || $extension === 'docx') {
                                                echo "<a href='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
                                                echo $element['archivo'];
                                                echo "</a>";
                                                }
                                                if($extension === 'pdf') {
                                                echo "<a href='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
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
                            <?php } //fin foreach ?>
                        </tbody>
                    </table>	
                </div>
            <?php } ?>    
										<!-- fin muestra actividades anteriores -->
										<!-- agregar actividades realizadas -->
										<form id="frmupdspot" class="row g-3">
										<h3 class="mt-50">Reporte de la actividad</h3>
										<div class="col-md-3">
											<label for="spot_fecha_inicio" class="form-label">Fecha inspección: </label>
											<input type="hidden" name="idsol" id="idsol" value="<?= $idspot ?>">
											<input type="date" class="form-control" name="spot_fecha_inicio" id="spot_fecha_inicio">
										</div>
										<div class="col-md-3">
											<label for="ip_hora_inicio" class="form-label">Hora inspección: </label>
											<input type="time" class="form-control" name="spot_hora_inicio" id="spot_hora_inicio">
										</div>
										<div class="col-md-3">
											<label for="ip_superviso" class="form-label">Realizó supervisión: </label>
											<select class="form-control" name="spot_superviso" id="spot_superviso">
												<option value="" selected>Seleccione</option>
												<option value="Si">Si</option>
												<option value="No">No</option>
											</select>
										</div>
										<div class="col-md-3">
											<label for="ip_edo_unidad" class="form-label">Actualizar Estado Unidad: </label>
											<select class="form-control" name="spot_edo_unidad" id="spot_edo_unidad">
												<option value="" selected>Seleccione</option>
												<option value="Condicionado">Condicionado</option>
												<option value="Movilizada">Movilizada</option>
												<option value="Desmovilizada">Desmovilizada</option>
											</select>
										</div>
										<div class="col-md-12 hide" id="io_motivo">
											<label for="spot_motivo" class="form-label">Motivo:</label>
											<input type="text" class="form-control" name="spot_motivo" id="spot_motivo">
										</div>
										<div class="col-md-12">
											<div id="spothtm"></div>
											<input type="hidden" name="spot_texto" id="spot_texto">
										</div>
										<div class="col-md-12">
											<label for="spot_files" class="form-label">Archivos adjuntos:</label>
											<input type="file" class="form-control" name="spot_files[]" id="spot_files" multiple>
										</div>
										<!-- fin de las actividades -->
										<div class="col-12 mt-25 mb-25">
											<button id="upd__spot" class="btn btn-primary">Guardar</button>
											<a href="index.php?p=spot" class="btn btn-warning">Regresar</a>
										</div>
										</form>
									</div>	
							</div>	
							<?php 
								break;

								case 'clspot':
									$sp = $act->obtener_solicitud_spot($idspot);
									

					?>											
					<div class="text-center mt-4">
						<h1>Spot</h1>
					</div>
						<div class="row">
							<div class="col-10 col-md-10">
									<div class="row g-3">
										<div class="col-md-4 rl dtllssol">
											<label for="empresa" class="form-label">Empresa</label>
											<input type="hidden" name="idunidad" id="idunidad" value="<?= $idunidad; ?>">
											<input type="text" class="form-control" name="empresa" id="empresa" value="<?= $nm['nombre']; ?>" disabled>
										</div>	
										<div class="col-md-4 dtllssol">
											<label for="ppu" class="form-label">PPU</label>
											<input type="text" class="form-control" name="ppu" id="ppu" value="<?= $nm['ppu']; ?>" disabled>
										</div>
										<div class="col-md-4">
												<label for="tipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" name="tipo" id="tipo" value="<?= $nm['tipo']; ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="servicios" class="form-label">Servicio</label>
												<input type="text" class="form-control" id="servicios" value="<?= $sp[0]['servicios'] ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
												<input type="text" class="form-control" name="ubicacion" id="ubicacion" value="<?= $sp[0]['ubicacion'] ?>" disabled>
											</div>
										<div class="col-md-6">
											<label for="fecha_revision" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_revision" id="fecha_revision" value="<?= $sp[0]['fecha_programado'] ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada" value="<?= $sp[0]['hora_agendada'] ?>" disabled>
										</div>
										<div class="col-md-12 rl">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" value="<?= $sp[0]['insnombre'] ?> <?= $sp[0]['insapellido'] ?>" disabled>
										</div>
										<!-- mostrar actividades anteriores -->
										<?php
        $hc = $act->mostrar_actualizaciones_spot($idspot);
		if(!empty($hc)) { //inicio if
		?>
            <div class="col-md-12">
                <h3 class="mt-25">Historial de actividades</h3>
                    <table class="table table-striped mb-25">
                        <tbody id="tr-actividad">
                            <?php 
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

                                                if($extension === 'jpeg' ||$extension === 'jpg' || $extension === 'gif' || $extension === 'png') {
                                                echo "<a href='#' onclick='openModal(\"assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}\")'>";
                                                echo "<img src='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' />";
                                                echo "</a>";
                                                }

                                                if($extension === 'doc' || $extension === 'docx') {
                                                echo "<a href='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
                                                echo $element['archivo'];
                                                echo "</a>";
                                                }
                                                if($extension === 'pdf') {
                                                echo "<a href='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
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
                            <?php } //fin foreach ?>
                        </tbody>
                    </table>	
                </div>
            <?php } ?>    
										<!-- fin muestra actividades anteriores -->
										<!-- agregar cierre spot -->
									<form id="frmclspot" class="row g-3">
									<input type="hidden" name="idsol" id="idsol" value="<?= $idspot ?>">
									<input type="hidden" name="idempresa" id="idempresa" value="<?= $nm['idempresa'] ?>">
									<input type="hidden" name="idunidad" id="idunidad" value="<?= $idunidad ?>">
									<h3 class="mt-50">Cierre de la actividad</h3>
										<div class="col-md-6">
											<label for="clsp_edo_unidad" class="form-label">Actualizar Estado Unidad: </label>
											<select class="form-control" name="clsp_edo_unidad" id="clsp_edo_unidad">
												<option value="" selected>Seleccione</option>
												<option value="CONDICIONADA">CONDICIONADA</option>
												<option value="DESMOVILIZADA">DESMOVILIZADA</option>
												<option value="MOVILIZADA">MOVILIZADA</option>
												<option value="LIBERADA">LIBERADA</option>
												
											</select>
										</div>
										<div class="col-md-6">
											<label for="clsp_motivo" class="form-label">Motivo:</label>
											<input type="text" class="form-control" name="clsp_motivo" id="clsp_motivo">
										</div>
										<div class="col-md-12">
											<label for="clsp_observaciones" class="form-label">Observaciones:</label>
											<textarea class="form-control" name="clsp_observaciones" id="clsp_observaciones"></textarea>
										</div>
										<div class="col-12 mt-25 mb-25">
										<button id="sv__cerrarspot" class="btn btn-success">Cerrar Actividad</button>	
											<a href="index.php?p=tallerip" class="btn btn-warning" id="back__asignacion">Regresar</a>
										</div>
									</form>	
									</div>	
							</div>	
							<?php 
								break;

								case 'detailspot':
								$sp = $act->obtener_solicitud_spot($idspot);
									

					?>											
					<div class="text-center mt-4">
						<h1>Spot</h1>
					</div>
						<div class="row">
							<div class="col-10 col-md-10">
									<div class="row g-3">
										<div class="col-md-4 rl dtllssol">
											<label for="empresa" class="form-label">Empresa</label>
											<input type="hidden" name="idunidad" id="idunidad" value="<?= $idunidad; ?>">
											<input type="text" class="form-control" name="empresa" id="empresa" value="<?= $nm['nombre']; ?>" disabled>
										</div>	
										<div class="col-md-4 dtllssol">
											<label for="ppu" class="form-label">PPU</label>
											<input type="text" class="form-control" name="ppu" id="ppu" value="<?= $nm['ppu']; ?>" disabled>
										</div>
										<div class="col-md-4">
												<label for="tipo" class="form-label">Tipo</label>
												<input type="text" class="form-control" name="tipo" id="tipo" value="<?= $nm['tipo']; ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="servicios" class="form-label">Servicio</label>
												<input type="text" class="form-control" id="servicios" value="<?= $sp[0]['servicios'] ?>" disabled>
											</div>
											<div class="col-md-6">
												<label for="ubicacion" class="form-label">Ubicación de la unidad: </label>
												<input type="text" class="form-control" name="ubicacion" id="ubicacion" value="<?= $sp[0]['ubicacion'] ?>" disabled>
											</div>
										<div class="col-md-6">
											<label for="fecha_revision" class="form-label">Fecha Revisión</label>
											<input type="date" class="form-control" name="fecha_revision" id="fecha_revision" value="<?= $sp[0]['fecha_programado'] ?>" disabled>
										</div>
										<div class="col-md-6">
											<label for="hora_agendada" class="form-label">Hora</label>
											<input type="time" class="form-control" name="hora_agendada" id="hora_agendada" value="<?= $sp[0]['hora_agendada'] ?>" disabled>
										</div>
										<div class="col-md-12 rl">
											<label for="inspector" class="form-label">Inspector(es) asignado: </label>
											<input type="text" class="form-control" name="inspector" 
											id="inspector" value="<?= $sp[0]['insnombre'] ?> <?= $sp[0]['insapellido'] ?>" disabled>
										</div>
										<!-- mostrar cierre de actividad -->
										<?php 
											//cierre de la actividad
											$cl = $act ->obtener_cierre_spot($idspot);
											if(!empty($cl)) { 
											?>
										<div class="col-md-12">
											<div class="anuncio">
												Esta actividad ha sido cerrada el día <strong><?= $cl[0]['fecha_cierre']; ?></strong> por <strong><?= $cl[0]['nombre']; ?>  <?= $cl[0]['apellido']; ?></strong> con el siguiente comentario:<br> 
												<p><?= $cl[0]['observaciones']; ?></p>
												<u>Estado de la Unidad:</u> <strong><?= $cl[0]['estado_unidad']; ?></strong>
											</div>
										</div>
										<?php } //fin cierre actividad ?>
										<!-- cierre de mostrar cierre de actividad -->

										<!-- mostrar actividades anteriores -->
										<?php
        $hc = $act->mostrar_actualizaciones_spot($idspot);
		if(!empty($hc)) { //inicio if
		?>
            <div class="col-md-12">
                <h3 class="mt-25">Historial de actividades</h3>
                    <table class="table table-striped mb-25">
                        <tbody id="tr-actividad">
                            <?php 
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

                                                if($extension === 'jpeg' ||$extension === 'jpg' || $extension === 'gif' || $extension === 'png') {
                                                echo "<a href='#' onclick='openModal(\"assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}\")'>";
                                                echo "<img src='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' />";
                                                echo "</a>";
                                                }

                                                if($extension === 'doc' || $extension === 'docx') {
                                                echo "<a href='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
                                                echo $element['archivo'];
                                                echo "</a>";
                                                }
                                                if($extension === 'pdf') {
                                                echo "<a href='assest/clientes/SPOT/{$h['idsolicitud']}/{$element['archivo']}' target='_blank'>";
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
                            <?php } //fin foreach ?>
                        </tbody>
                    </table>	
                </div>
            <?php } ?>    
										<!-- fin muestra actividades anteriores -->
									</div>	
							</div>	
							<?php 
								break;
							}
							?>

						

					</div>	
					<!--fin de asignacion de inspectores -->
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