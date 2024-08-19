<?php require_once 'models/manager.php'; ?>
<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>Reportes</strong> disponibles</h1>
		<div class="row">
			<div class="col-xl-12 col-xxl-12 d-flex">
				<div class="w-100">
					<div class="row">
						<div class="col-sm-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Clientes</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="users"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3" id="idx_clientes">
										0
									</h1>
									<div class="mb-0">
										<!--span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
										<span class="text-muted">Since last week</span-->
									</div>
								</div>
							</div>
							</div>
							<div class="col-sm-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Vehículos</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="truck"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3" id="idx_unidades">0
									</h1>
									<div class="mb-0">
										<!--span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
										<span class="text-muted">Since last week</span-->
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Inspectores</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="users"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3">
										<?php
										/*
										$num_proyectos = new Manage();
										$num_proyectos = $num_proyectos->cuenta_proyectos();
										echo $num_proyectos; */
										?>0 </h1>
									<div class="mb-0">
										<!--span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
										<span class="text-muted">Since last week</span-->
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col mt-0">
											<h5 class="card-title">Programadas</h5>
										</div>

										<div class="col-auto">
											<div class="stat text-primary">
												<i class="align-middle" data-feather="calendar"></i>
											</div>
										</div>
									</div>
									<h1 class="mt-1 mb-3">
										<?php
										/*
										$num_proyectos = new Manage();
										$num_proyectos = $num_proyectos->cuenta_proyectos();
										echo $num_proyectos; */
										?>0</h1>
									<div class="mb-0">
										<!--span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
										<span class="text-muted">Since last week</span-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-lg-12 col-xxl-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header">

						<h5 class="card-title mb-0">Registro de usuarios</h5>
					</div>
					<table class="table table-hover my-0 mb-50">
						<thead>
							<tr>
								<th>Cliente</th>
								<th>Fecha solicitud</th>
								<th>Fecha revisión</th>
								<th>Placa</th>
								<th>Solicitado por</th>
								<th>Revisado por</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="tbl-usuarios">
						
						</tbody>
					</table>
					
				</div>
			</div>
		</div>

	</div>
</main>
		