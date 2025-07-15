<?php 
include("include/header.php");
include("admin/config.php");
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<body>

	<!-- ✅ Toast Message -->
	<?php if ($status === 'success' || $status === 'error'): ?>
		<div id="custom-toast" style="
			position: fixed;
			top: 20px;
			right: 20px;
			background-color: <?= $status === 'success' ? '#d4edda' : '#f8d7da' ?>;
			color: <?= $status === 'success' ? '#155724' : '#721c24' ?>;
			padding: 12px 24px;
			border: 1px solid <?= $status === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
			font-weight: 500;
			z-index: 9999;
			transition: opacity 0.5s ease-in-out;
		">
			<?= $status === 'success' 
				? '✅ Message sent successfully!' 
				: '❌ Error sending message. Please try again with new email.' ?>
		</div>
	<?php endif; ?>


	<!-- 🟦 Banner Area -->
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

	<!-- 🟦 About Area -->
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
					<p>Founded by book lovers, for book lovers, our blog brings you honest reviews, thoughtful recommendations, author spotlights, literary news, and engaging discussions...</p>

					<p class="fw-semibold fs-5">✨ What We Offer:</p>

					<ul class="list-group list-group-flush mb-3">
						<li class="list-group-item border-0 bg-transparent fs-5">📖 In-depth Book Reviews</li>
						<li class="list-group-item border-0 bg-transparent fs-5">📚 TBR (To Be Read) Lists & Recommendations</li>
						<li class="list-group-item border-0 bg-transparent fs-5">📝 Reading Challenges & Book Tags</li>
						<li class="list-group-item border-0 bg-transparent fs-5">🖋️ Author Interviews & Features</li>
						<li class="list-group-item border-0 bg-transparent fs-5">🔍 Behind-the-Scenes Publishing Insights</li>
					</ul>

					<p>Join us on this literary journey and let’s turn the page together — one book at a time. Let’s connect, discuss, and celebrate the written word! 📖</p>
				</div>
			</div>
		</div>
	</section>

	<!-- 🟦 Blogs Area -->
	<section class="blogs-area section-gap py-5" id="blogs" style="font-size: 1.15rem;">
		<div class="container">
			<div class="row justify-content-center mb-4">
				<div class="col-lg-8 text-center">
					<h1 class="mb-3 fw-bold text-black display-5">BLOGS</h1>
					<p class="text-muted fs-5">Explore our latest book reviews, reading tips, and literary stories curated for book lovers like you.</p>
				</div>
			</div>
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
					<div class="single-about media shadow p-4 rounded d-flex align-items-start">
						<img class="img-fluid rounded" src="<?= $imagePath ?>" alt="Blog Image" width="120" height="120" style="object-fit: cover;">
						
						<!-- Add margin-start to this div -->
						<div class="media-body ms-4" style="margin-left: 2rem;">
							<h4 class="mt-0 fs-4 mb-2">
								<a href="blog_details.php?id=<?= $row['id'] ?>" class="text-primary fw-bold">
									<?= htmlspecialchars($row['title']) ?>
								</a>
							</h4>
							<p class="mb-0 fs-6"><?= htmlspecialchars($row['short_description']) ?></p>
						</div>
					</div>

				</div>
				<?php } ?>
			</div>

			<div class="text-center mt-5">
				<a href="blogs.php" class="btn btn-outline-primary px-4 fs-5">View More</a>
			</div>
		</div>
	</section>

	<!-- 🟦 Contact Area -->
	<section class="contact-area section-gap py-5" id="contact" style="background: url('assets/logo/picture 2.jpg') no-repeat center center / cover; font-size: 1.15rem;">
		<div class="container">
			<div class="row justify-content-center mb-4">
				<div class="col-lg-8 text-center">
					<h1 class="mb-3 fw-bold text-white display-5">CONTACT US</h1>
				</div>
			</div>

			<div class="row align-items-stretch shadow bg-white rounded p-4 fs-5">
				<div class="col-md-6 mb-4 mb-md-0">
					<form method="POST" id="contactForm" action="process_contact.php">
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
						</div>
					</form>
				</div>

				<!-- Google Map -->
				<div class="col-md-6">
					<div class="h-100 rounded overflow-hidden">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18..." width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include("include/footer.php"); ?>

	<!-- ✅ Toast Auto Hide Script -->
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const toast = document.getElementById("custom-toast");
			if (toast) {
				setTimeout(() => {
					toast.style.opacity = "0";
					setTimeout(() => toast.remove(), 500);
				}, 5000);
			}
		});
	</script>
</body>
