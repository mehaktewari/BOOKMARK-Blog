<?php 
include("include/blog_header.php");
include("admin/config.php");

// Pagination Setup
$limit = 5; // Blogs per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of blog posts
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM article WHERE status = 1");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalBlogs = $totalRow['total'];
$totalPages = ceil($totalBlogs / $limit);

// Fetch paginated blogs
$query = "SELECT * FROM article WHERE status = 1 ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);
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

        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">« Prev</a></li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next »</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>					
</section>

<?php include("include/footer.php"); ?>
