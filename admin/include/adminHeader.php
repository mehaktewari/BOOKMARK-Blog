<!DOCTYPE html>
<html lang="en">
</html>
<head>
	<title>Admin Panel</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
	<!-- vendor css -->
	<link rel="stylesheet" href="assets/css/style.css">
	<script src="assets/js/link/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/links/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/links/dataTables.bootstrap4.css">

	<link rel="stylesheet" href="assets/css/links/dataTables.jqueryui.css">
	<link href="assets/css/links/summernote.min.css" rel="stylesheet">


</head>
<!-- [ Header ] start -->
 <?php 
	session_start();
	if (empty($_SESSION["user_name"])) {
      header("Location: ../index.php");
	}
	if (isset($_GET['logout'])) {
    session_unset();    
    session_destroy();  
    header("Location: login.php");
    exit();
}
	?>
<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
	<div class="m-header">
		<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
		<a href="#!" class="b-brand">
			<!-- ========   change your logo hear   ============ -->
			<img src="assets/images/lo.png" alt="" class="logo">
			<span><b>BOOKMARK</b></span>
		</a>
		<a href="#!" class="mob-toggler">
			<i class="feather icon-more-vertical"></i>
		</a>
	</div>
	<div class="collapse navbar-collapse">
		<ul class="navbar-nav ml-auto">
			<li>
				<div class="dropdown drp-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="feather icon-user"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right profile-notification">
						<div class="pro-head">
							<img src="assets/images/male.avif" class="img-radius" alt="User-Profile-Image">
							<span><?php echo $_SESSION['user_name']; ?></span>
							<a href="../index.php" class="dud-logout" title="Logout">
								<i class="feather icon-log-out"></i>
							</a>

						</div>
						<ul class="pro-body">
							<li><a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i>
									Profile</a></li>
						
						</ul>
					</div>
				</div>
			</li>
		</ul>
	</div>
</header>
<!-- [ Header ] end -->