<main class="content">
	<div id="prpvisualizar" class="dvpview hide">
		<div id="canvas-img" class="img-container">
			<img src="" id="prpvimg" class="pview">
		</div>
		<button type="button" class="btn btn-dark svtb hide" id="prsv__crop">Recortar</button>
	</div> 
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
						<div class="text-center mt-4">
							<h1>Usuarios</h1>
						</div>
						<div id="tblpersonal">
						<div class="row">
							<div class="col-12 text-right"><button class="btn btn-primary" id="addempleadoxbtn"><i class="align-middle" data-feather="user-plus"></i> Agregar</button></div>
						</div>
						<div class="row mt-25" >
					<div class="col-12 col-lg-12 col-xxl-12 d-flex">
					<table class="table table-hover my-0">
						<thead>
							<tr>
							<th>Nombre y Apellidos</th>
							<th class="d-none d-xl-table-cell">Email</th>
							<th class="d-none d-xl-table-cell">Telefono</th>
							<th class="d-none d-xl-table-cell">Departamento</th>
							<th>Cargo</th>
							<th class="d-none d-xl-table-cell">Acceso Web</th>
							<th style="width:30px"></th>
							</tr>
						</thead>
						<tbody id="tbl-Empleados">
						
						</tbody>
						</table>
					</div>
				</div>	
				<div class="row">
					<div class="col-12 col-lg-12 col-xxl-12 d-flex text-right mt-15">
					Total registros: <div id="total_empleados" class="mr-25 ml-10"></div>
					</div>
				
					<div class="paginacion">
						<ul class="pagination" id="Empleados-pagination">
						</ul>
						
					</div>	
					</div>	
						</div>
						<div id="addpersonal" class="hide">
						<!--agregar personal -->
						<div class="row mt-25">
							<div class="col-12 col-md-12">
							<form id="frmempleado" class="row">
								<div class="col-md-4 order-0">
									<img src="assest/images/no-profile.webp" alt="usuario" id="profilepic" class="profilepic">
									<input type="file" name="imgfile" id="imgfile" class="hide">
									<input type="hidden" name="pimg__base64" id="pimg__base64">
								</div>
								<div class="col-md-7">
									<div class="row g-3">
										<h3>Datos personales</h3>
										<div class="col-md-4">
											<label for="empnombre" class="form-label">Nombres</label>
											<input type="text" class="form-control" name="empnombre" id="empnombre">	
										</div>		
										<div class="col-md-4">
											<label for="empapellidos" class="form-label">Apellidos</label>
											<input type="text" class="form-control" name="empapellidos" id="empapellidos">
										</div>
										<div class="col-md-4">
											<label for="empnacimiento" class="form-label">Fecha de Nacimiento</label>
											<input type="date" class="form-control" name="empnacimiento" id="empnacimiento">
										</div>
										<div class="col-md-6">
											<label for="empsexo" class="form-label">Sexo</label>
											<select class="form-control" name="empsexo" id="empsexo">
												<option value="">Seleccione</option>
												<option value="M">Masculino</option>
												<option value="F">Femenino</option>
												<option value="N">Prefiero no decirlo</option>
											</select>				
										</div>
										<div class="col-md-6">
											<label for="empidentificacion" class="form-label">RUT</label>
											<input type="text" class="form-control" name="empidentificacion" id="empidentificacion">
										</div>
										<div class="col-md-6">
											<label for="empcorreo" class="form-label">Dirección de correo</label>
											<input type="email" class="form-control" name="empcorreo" id="empcorreo">
										</div>
										<div class="col-md-6">
											<label for="empmovil" class="form-label">Movil</label>
											<input type="text" class="form-control" name="empmovil" id="empmovil">
										</div>
										<div class="col-8">
											<label for="empdireccion" class="form-label">Dirección</label>
											<input type="text" class="form-control" name="empdireccion" id="empdireccion">
										</div>
										<div class="col-md-4">
											<label for="empciudad" class="form-label">Ciudad</label>
											<input type="text" class="form-control" name="empciudad" id="empciudad">
										</div>
										
										<h3 class="mt-25">Datos laborales</h3>
										<div class="col-md-6">
											<label for="empingreso" class="form-label">Fecha Ingreso</label>
											<input type="date" class="form-control" name="empingreso" id="empingreso">
										</div>
										<div class="col-md-6">
											<label for="empcargo" class="form-label">Cargo</label>
											<input type="text" class="form-control" name="empcargo" id="empcargo">
										</div>
										<div class="col-md-12">
											<label for="empdepartamento" class="form-label">Departamento</label>
											<select name="empdepartamento" id="empdepartamento" class="form-control">
												<option selected>Seleccione</option>
											</select>
										</div>
										<div class="col-md-12">
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" name="ismanager" id="ismanager">
											<label class="form-check-label" for="setmanager">Manager del departamento</label>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" name="hasaccess" id="hasaccess">
											<label class="form-check-label" for="accessLvl">Acceso web</label>
											</div>
										</div>
										<div class="col-md-12 cover_line mt-25 hide" id="dval">
											<label class="form-label">Tiene acceso a:</label>
											<div class="grid_disponibles">
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="departamentos" id="departamentos">
												<label class="form-check-label" for="departamentos">
													Departamentos
												</label>
											</div>
											<div class="form-check">	
												<input class="form-check-input" type="checkbox" name="personal" id="personal">
												<label class="form-check-label" for="personal">
													Personal
												</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="empresa" id="empresa">
												<label class="form-check-label" for="empresa">
													Empresa
												</label>
											</div>
											
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="unidades" id="unidades">
												<label class="form-check-label" for="unidades">
													Unidades
												</label>
											</div>

											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="tallerip" id="tallerip">
												<label class="form-check-label" for="tallerip">
													Taller IP
												</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" name="panne" id="panne">
												<label class="form-check-label" for="panne">
													Panne
												</label>
											</div>

											<!--div class="form-check hide">
												<input class="form-check-input" type="checkbox" name="tickets" id="tickets">
												<label class="form-check-label" for="tickets">
													Tickets
												</label>
											</div>
											<div class="form-check hide">
												<input class="form-check-input" type="checkbox" name="planes" id="planes">
												<label class="form-check-label" for="planes">
													Planes
												</label>
											</div>
											<div class="form-check hide">
												<input class="form-check-input" type="checkbox" name="clientes" id="clientes">
												<label class="form-check-label" for="clientes">
													Clientes
												</label>
											</div-->
											</div>
										</div>	

									</div>
									<!-- datos de la sede principal de la empresa -->
									<div class="col-12 mt-25 mb-25">
										<button id="updatempprofile" class="btn btn-primary hide">Actualizar</button>
										<input type="hidden" name="empid" id="empid">
										<button id="guardarprofile_emp" class="btn btn-primary">Guardar</button>
										<button class="btn btn-warning" id="backEmp">Regresar</button>
									</div>
								</div>
								</form>
							</div>
						</div>	
						<!-- fin de agregar personal -->
						</div>
					</div>
				</div>
			</div>
		</div>	
		</main>
