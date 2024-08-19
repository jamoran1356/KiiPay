<?php

$pr = new Manage();
$pr = $pr->muestra_persona($idpersona, $rol);

$token = new Manage();
$_SESSION['token'] = $token->generarCodigo(8);
?>

<main class="content">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-xl-10 col-xxl-10 d-flex ml-25">
				<div class="card flex-fill">
					<div class="card-header">
          <div class="text-center mt-4">
							<h1>Edición de <?= $pr['rol']; ?></h1>
						</div>
						<div class="row mt-25">
							<div class="col-12 col-md-12">
							<form id="frmpersonal" class="row g-3 mt-25 ml-10 mb-25">
                        <div class="col-md-3">
                          <label for="pnombre" class="form-label">Primer nombre:</label>
                          <input type="text" class="form-control" id="pnombre" name="pnombre" value="<?= $pr['p_nombre']?>">
                          <span class="error-span" id="pnombre-error"></span>
                        </div>
                        <div class="col-md-3">
                          <label for="snombre" class="form-label">Segundo nombre:</label>
                          <input type="text" class="form-control" id="snombre" name="snombre" value="<?= $pr['s_nombre']?>">
                        </div>
                        <div class="col-md-3">
                            <label for="papellido" class="form-label">Primer apellido:</label>
                            <input type="text" class="form-control" id="papellido" name="papellido" value="<?= $pr['p_apellido']?>">
                            <span class="error-span" id="papellido-error"></span>
                          </div>
                          <div class="col-md-3">
                            <label for="sapellido" class="form-label">Segundo apellido:</label>
                            <input type="text" class="form-control" id="sapellido" name="sapellido" value="<?= $pr['s_apellido']?>">
                          </div>
                        <div class="col-md-4">
                            <label for="identificacion" class="form-label">Identificación:</label>
                            <input type="number" class="form-control" id="identificacion" name="identificacion" value="<?= $pr['identificacion']?>">
                            <span class="error-span" id="identificacion-error"></span>
                          </div>
                          <div class="col-md-4">
                            <label for="email" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $pr['email']?>">
                            <span class="error-span" id="correo-error"></span>
                          </div>
                        <div class="col-md-4">
                          <label for="celular" class="form-label">Celular:</label>
                          <input type="number" class="form-control" id="celular" name="celular" value="<?= $pr['celular']?>">
        
                        </div>
                        
                        <div class="col-md-6">
                            <label for="pass" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="pass" name="pass">
                            <span class="error-span" id="clave-error"></span>
                          </div>
                        <div class="col-md-6">
                            <label for="pass2" class="form-label">Repita la Contraseña:</label>
                            <input type="password" class="form-control" id="pass2" name="pass2">
                        </div>
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary" id="btn-registro_">Grabar</button>
                          <input type="hidden" name="xtk" value="<?php echo $_SESSION['token'];?>">
                          <input type="hidden" name="rol" value="<?= $pr['rol'] ?>">
                          <?php if($pr['rol']=='Coordinador') { ?>
                          <a href="index.php?p=listacoordinador" class="btn btn-warning">Regresar</a> 
                          <?php } if($pr['rol']=='Tutor') { ?>
                          <a href="index.php?p=listatutor" class="btn btn-warning">Regresar</a> 
                          <?php } ?>
                        </div>
                      </form>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
		</main>
			
