
<?php 
	include("include/blog_header.php");
	include("admin/config.php");
?>
<body>
	<section class="blogs-area section-gap py-5" id="blogs">
		<div class="container">
			<div class="row justify-content-center mb-4">
				<div class="col-lg-8 text-center">
					<h1 class="mb-3 fw-bold text-black">ALL BLOGS</h1>
					<p class="text-muted" style="font-size: 1.1rem;">Dive deeper into our complete collection of blog posts.</p>
				</div>
			</div>						
			<div class="row g-4">
				<?php
				$query = "SELECT * FROM article WHERE status = 1 ORDER BY id DESC";
				$result = mysqli_query($conn, $query);

				while ($row = mysqli_fetch_assoc($result)) {
					$imageFile = $row['image'];
					$imagePath = (!empty($imageFile) && file_exists("admin/assets/img/" . $imageFile)) 
						? "admin/assets/img/" . $imageFile 
						: "admin/assets/img/default.jpg";
				?>
					<div class="col-lg-6">
						<div class="single-about media shadow p-3 rounded d-flex align-items-start">
							<img class="img-fluid rounded me-3" src="<?php echo $imagePath; ?>" alt="Blog Image" width="120" height="120" style="object-fit: cover;">
							<div class="media-body ps-3">
								<h4 class="mt-0">
									<a href="blog_details.php?id=<?php echo $row['id']; ?>" class="text-primary fw-bold">
										<?php echo htmlspecialchars($row['title']); ?>
									</a>
								</h4>
								<p class="mb-0"><?php echo htmlspecialchars($row['short_description']); ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>					
	</section>

<?php include("include/footer.php"); ?>
