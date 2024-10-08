<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="PYDTI, Programación y Desarrollo de Tecnologia de Informacion">
	<title>KiiPay - Simple Blockchain Integration for Your Website</title>
    <meta name="description" content="KiiPay offers a simple and efficient solution for integrating blockchain payments into your website. No coding required! Start accepting cryptocurrencies today.">
    <meta name="keywords" content="blockchain payments, cryptocurrency, SDK, integration, website, easy, simple">
	<link rel="icon" type="image/webp" sizes="48x48" href="assest/images/favicon.webp">
	<link href="assest/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<!--Hojas para el rich text -->
	<link href="assest/css/styles.css" rel="stylesheet">
</head>
<body>
<div id="loader" class="loader">
  <div class="loader-content"></div>
</div>
<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table">
					<div class="d-table-cell align-middle">
						<div class="card mt-150">
							<div class="card-body">
								<figure>
									<img class="logoportada" src="assest/images/logo.webp" alt="Logotipo pydti">
								</figure>	
								<h1 class="text-center mt25">Bienvenido de vuelta</h1>
								<div class="m-sm-4">
									<form id="frmlogin">
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control" type="text" id="logemail" name="logemail" placeholder="Ingresa tu correo" />
										</div>
										<div class="input-group mb-3">
											<label class="form-label">Contraseña</label>
											<input class="form-control" type="password" name="logpassword" id="logpassword" placeholder="Ingresa tu clave" />
											<span class="input-group-text" id="showpass"><img id="showme" src="assest/images/eye.svg" alt="Show Password"></span>
											<!--small class="recuperar mt-25"><a href="#">Recuperar clave</a> </small-->
										</div>
										<div>
										
											<!--label class="form-check">
            <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
            <span class="form-check-label">
              Remember me next time
            </span>
          </label-->
										</div>
										<div class="text-center mt-3">
											<button type="submit" class="btn btn-lg btn-primary" id="btnlogin">Iniciar sesión</button>
										</div>
									</form>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-12">
									<h1 class="text-center mt-25">Ingresa con</h1>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 dflex">
										<ul>
											<li><button class="google-button">google</button></li>
											<li><button class="google-button">twitter</button></li>
											<li><button class="google-button">Facebook</button></li>
										</ul>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>
    <script src="assest/js/app.js"></script>
	<script src="assest/js/bootstrap.bundle.min.js"></script>
    <script src="assest/js/sweetalert2.all.min.js"></script>
    <script src="assest/js/jquery-3.6.3.min.js"></script>
    <script src="assest/js/functions.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>    