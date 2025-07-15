<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar  ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="assets/images/male.avif" alt="User-Profile-Image">
						<div class="user-details">
							<span><?php echo $_SESSION['user_name']; ?></span>
							<div id="more-details"><?php echo $_SESSION['email']; ?></div>
						</div>
					</div>
					
				</div>
				
				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<label>Navigation</label>
					</li>
					<li class="nav-item">
					    <a href="dashboad.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					<li class="nav-item">
					    <a href="category.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Category</span></a>
					</li>
					<li class="nav-item">
					    <a href="users.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">User</span></a>
					</li>
					<li class="nav-item">
					    <a href="article.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Article</span></a>
					</li>
					<li class="nav-item">
					    <a href="role.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Role</span></a>
					</li>
					<li class="nav-item">
					    <a href="permission.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Permission</span></a>
					</li>
					<li class="nav-item">
					    <a href="contacts.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Contacts</span></a>
					</li>
					<li class="nav-item">
					    <a href="setting.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Setting</span></a>
					</li>
					
					
				</ul>
				
				
				
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->