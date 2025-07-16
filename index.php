<?php 
include("include/header.php");
include("admin/config.php");
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<body>

	<!-- Toast Message -->
	<?php if (isset($_GET['status']) && ($_GET['status'] === 'success' || $_GET['status'] === 'error')): ?>
		<div id="custom-toast" style="
			position: fixed;
			top: 20px;
			right: 20px;
			background-color: <?= $_GET['status'] === 'success' ? '#d4edda' : '#f8d7da' ?>;
			color: <?= $_GET['status'] === 'success' ? '#155724' : '#721c24' ?>;
			padding: 12px 24px;
			border: 1px solid <?= $_GET['status'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
			font-weight: 500;
			z-index: 9999;
			transition: opacity 0.5s ease-in-out;
		">
			<?= $_GET['status'] === 'success' ? '✅ Message sent successfully!' : '❌ Error sending message. Please try again with new email.' ?>
		</div>
	<?php endif; ?>


	<!-- Banner Area -->
	<section class="banner-area relative" id="home" data-parallax="scroll" data-image-src="assets/logo/picture1.jpg">
		<div class="overlay-bg overlay"></div>
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-center">
				<div class="col-lg-12 text-center">
					<h1 class="text-white fw-bold">
						The books that the world calls immoral <br>
						Are books that show the world its own shame.
					</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!-- About Area -->
	<section class="contact-area section-gap py-5" id="about" style="background-color:rgb(237, 237, 237);">
		<div class="container">
			<div class="row justify-content-center mb-4">
				<div class="col-lg-10 text-center">
					<h1 class="mb-3 fw-bold text-black display-5">ABOUT US</h1>
				</div>
			</div>

			<div class="card shadow rounded-3 border-0 p-5 mx-auto" style="max-width: 1100px; background-color: rgb(243, 243, 243); font-size: 1.15rem;">
				<div class="card-body">
					<p><strong>At <span class="text-primary">BookMark</span></strong>, we believe that every book holds a story beyond its pages — and we're here to share those stories with the world. Whether you're a casual reader or a passionate bibliophile, this space is for you.</p>
					<p>Founded by book lovers, for book lovers, our blog brings you honest reviews, thoughtful recommendations, author spotlights, literary news, and engaging discussions. From timeless classics to modern masterpieces, we explore a wide range of genres including fiction, non-fiction, fantasy, romance, mystery, historical reads, and more.</p>

					<p class="fw-semibold fs-5">✨ What We Offer:</p>

					<ul class="list-group list-group-flush mb-3">
						<li class="list-group-item border-0" style="background-color: rgb(243, 243, 243); font-size: 1.1rem;">📖 In-depth Book Reviews</li>
						<li class="list-group-item border-0" style="background-color: rgb(243, 243, 243); font-size: 1.1rem;">📚 TBR (To Be Read) Lists & Recommendations</li>
						<li class="list-group-item border-0" style="background-color: rgb(243, 243, 243); font-size: 1.1rem;">📝 Reading Challenges & Book Tags</li>
						<li class="list-group-item border-0" style="background-color: rgb(243, 243, 243); font-size: 1.1rem;">🖋️ Author Interviews & Features</li>
						<li class="list-group-item border-0" style="background-color: rgb(243, 243, 243); font-size: 1.1rem;">🔍 Behind-the-Scenes Publishing Insights</li>
					</ul>

					<p>Join us on this literary journey and let’s turn the page together — one book at a time. Let’s connect, discuss, and celebrate the written word! 📖</p>
				</div>
			</div>
		</div>
	</section>
	<!-- End About Area -->

	<!-- Blogs Area -->
	<section class="blogs-area section-gap py-5" id="blogs" style="font-size: 1.15rem;">
		<div class="container">
			<!-- Section Heading -->
			<div class="row justify-content-center mb-4">
				<div class="col-lg-8 text-center">
					<h1 class="mb-3 fw-bold text-black display-5">BLOGS</h1>
					<p class="text-muted fs-5">Explore our latest book reviews, reading tips, and literary stories curated for book lovers like you.</p>
				</div>
			</div>

			<!-- Blog Cards -->
			<div class="row g-4">
				<?php
				$query = "SELECT * FROM article WHERE status = 1 ORDER BY id DESC LIMIT 4";
				$result = mysqli_query($conn, $query);
				while ($row = mysqli_fetch_assoc($result)) {
					$imageFile = $row['image'];
					$imagePath = (!empty($imageFile) && file_exists("admin/assets/img/" . $imageFile)) 
						? "admin/assets/img/" . $imageFile 
						: "admin/assets/img/default.jpg"; 
				?>
				<div class="col-lg-6">
					<div class="d-flex flex-row shadow rounded p-4 align-items-start" style="gap: 2rem;">
						<!-- Blog Image -->
						<img src="<?php echo $imagePath; ?>" 
							alt="Blog Image" 
							class="img-fluid rounded"
							width="120" height="120" 
							style="object-fit: cover; flex-shrink: 0;">

						<!-- Blog Content -->
						<div class="flex-grow-1">
							<h4 class="fs-4 mb-3">
								<a href="blog_details.php?id=<?php echo $row['id']; ?>" class="text-primary fw-bold text-decoration-none">
									<?php echo htmlspecialchars($row['title']); ?>
								</a>
							</h4>
							<p class="fs-6 text-muted mb-0">
								<?php echo htmlspecialchars($row['short_description']); ?>
							</p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>

			<!-- View More Button -->
			<div class="text-center mt-5">
				<a href="blogs.php" class="btn btn-outline-primary px-4 fs-5">View More</a>
			</div>
		</div>
	</section>

	<!-- End Blogs Area -->

	<!-- Contact Area -->
	<section class="contact-area section-gap py-5" id="contact" style="background: url('assets/logo/picture 2.jpg') no-repeat center center / cover; font-size: 1.15rem;">
		<div class="container">
			<div class="row justify-content-center mb-4">
				<div class="col-lg-8 text-center">
					<h1 class="mb-3 fw-bold text-white display-5">CONTACT US</h1>
				</div>
			</div>

			<div class="row align-items-stretch shadow bg-white rounded p-4 fs-5">
				<div class="col-md-6 mb-4 mb-md-0">
					<form method="POST" id="contactForm" name="contactForm" action="process_contact.php">
						<div class="mb-3">
							<label class="form-label text-primary fs-6" for="name">Full Name</label>
							<input type="text" class="form-control fs-6" name="name" id="name" placeholder="Your Name" required>
						</div>
						<div class="mb-3">
							<label class="form-label text-primary fs-6" for="email">Email Address</label>
							<input type="email" class="form-control fs-6" name="email" id="email" placeholder="Your Email" required>
						</div>
						<div class="mb-3">
							<label class="form-label text-primary fs-6" for="subject">Subject</label>
							<input type="text" class="form-control fs-6" name="subject" id="subject" placeholder="Subject" required>
						</div>
						<div class="mb-3">
							<label class="form-label text-primary fs-6" for="message">Message</label>
							<textarea name="message" class="form-control fs-6" id="message" rows="5" placeholder="Your Message" required></textarea>
						</div>
						<div class="text-start">
							<input type="submit" value="Send Message" class="btn btn-primary px-4 fs-5">
							<div class="submitting mt-2"></div>
						</div>
					</form>
				</div>

				<!-- Google Map -->
				<div class="col-md-6">
					<div class="h-100 rounded overflow-hidden">
						<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.998574295539!2d90.39090471498098!3d23.793551684571297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c794f915f59f%3A0xf14f632aef1818c0!2sNational%20Library!5e0!3m2!1sen!2sin!4v1623950297193!5m2!1sen!2sin"
							width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
						</iframe>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Contact Area -->

<?php include("include/footer.php"); ?>

<!-- Toast Auto Show -->
<script>
	document.addEventListener("DOMContentLoaded", function () {
		const toast = document.getElementById("custom-toast");
		if (toast) {
			setTimeout(() => {
				toast.style.opacity = "0";
				setTimeout(() => toast.remove(), 500); // Remove from DOM after fade out
			}, 5000); // Display for 3 seconds
		}
	});
</script>

