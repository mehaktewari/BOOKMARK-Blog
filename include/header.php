<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="assets/img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title>Blogger</title>

		<link href="assets/css/links/i_css1.css" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="assets/css/linearicons.css">
			<link href="assets/css/links/i_css2.css" rel="stylesheet">
			<link rel="stylesheet" href="assets/css/font-awesome.min.css">
			<link rel="stylesheet" href="assets/css/bootstrap.css">
			<link rel="stylesheet" href="assets/css/owl.carousel.css">
			<link rel="stylesheet" href="assets/css/main.css">
		</head>
        <!-- Start Header Area -->
			<header class="default-header">
				<nav class="navbar navbar-expand-lg navbar-light">
					<div class="container">
						  <a class="navbar-brand" href="index.php">
						  	<img src="assets/logo/lo.png" alt="">
							<span><b>BOOKMARK</b></span>
						  </a>
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>

						  <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
						    <ul class="navbar-nav">
								<li><a href="#home">Home</a></li>
								<li><a href="#about">About</a></li>
								<li><a href="#blogs">Blogs</a></li>
								<li><a href="#contact">Contact</a></li>
								<li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
							      </div>
							    </li>								
						    </ul>
						  </div>						
					</div>
				</nav>
			</header>
			<!-- End Header Area -->

			<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" style="max-width: 1200px;"> <!-- Increased width -->
					<div class="modal-content border-0 shadow-lg" style="height: 600px;">
						<div class="row g-0 h-100">
							
							<!-- Left: Image -->
							<div class="col-md-6 h-100">
								<img src="assets/logo/filelogin.jpg" alt="Login Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
							</div>

							<!-- Right: Login Form -->
							<div class="col-md-6 d-flex flex-column justify-content-between p-5">

								<!-- Header -->
								<div class="d-flex justify-content-between align-items-start mb-3">
									<h3 class="fw-bold">Login</h3>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>

								<!-- Centered Logo (larger) -->
								<div class="d-flex justify-content-center align-items-center mb-6">
									<img src="assets/logo/lo.png" alt="Logo" class="img-fluid" style="max-width: 180px;height: 80px;">
								</div>

								<!-- Form -->
								<form method="POST" action="login.php" class="flex-grow-1 d-flex flex-column justify-content-center">
									<div class="mb-4">
										<label for="email" class="form-label fw-semibold" style="font-size: 16px;">Email Address</label>
										<input type="email" class="form-control" id="email" name="email"
											placeholder="Enter your email"
											style="height: 50px; font-size: 16px;">
									</div>

									<div class="mb-4">
										<label for="password" class="form-label fw-semibold" style="font-size: 16px;">Password</label>
										<input type="password" class="form-control" id="password" name="password"
											placeholder="Enter your password"
											style="height: 50px; font-size: 16px;">
									</div>

									<div class="d-flex justify-content-end gap-2">
										<button type="submit" class="btn btn-success px-4 py-2" style="font-size: 16px;">Login</button>
									</div>
								</form>
							</div>


						</div>
					</div>
				</div>
			</div>

