<?php 
include("include/blog_header.php");
include("admin/config.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM article WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $blogData = mysqli_fetch_assoc($result); 
        $articleID = $blogData['id'];
    } else {
        echo "Article not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if (isset($_POST['submit_comment'])) {
    $name = trim(mysqli_real_escape_string($conn, $_POST['name']));
    $comment = trim(mysqli_real_escape_string($conn, $_POST['comment']));
    $rating = intval($_POST['rating']);
    $status = 1;
    $created = date("Y-m-d H:i:s");

    if (!empty($name) && !empty($comment) && $rating > 0 && $rating <= 5) {
        $insertSQL = "INSERT INTO comments (name, article_id, comments, rating, status, created) 
                      VALUES ('$name','$articleID', '$comment', $rating, '$status', '$created')";

        if (mysqli_query($conn, $insertSQL)) {
            header("Location: blog_details.php?id=$id&comment=success");
            exit;
        } else {
            header("Location: blog_details.php?id=$id&comment=error");
            exit;
        }
    } else {
        header("Location: blog_details.php?id=$id&comment=error");
        exit;
    }
}
?>

<body>
<?php if (isset($_GET['comment']) && ($_GET['comment'] === 'success' || $_GET['comment'] === 'error')): ?>
    <div id="toast" style="position: fixed;top: 20px;left: 50%;transform: translateX(-50%);background-color: <?= $_GET['comment'] === 'success' ? '#d4edda' : '#f8d7da' ?>;color: <?= $_GET['comment'] === 'success' ? '#155724' : '#721c24' ?>;padding: 12px 24px;
        border: 1px solid <?= $_GET['comment'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-weight: 500;
        z-index: 9999;">
        <?= $_GET['comment'] === 'success' ? '✅ Comment submitted successfully!' : '❌ Error submitting comment. Please fill all fields properly.' ?>
    </div>
<?php endif; ?>

<section class="blogs-area py-5 bg-light" id="blogs">
    <div class="container">
        <!-- Blog Heading -->
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h1 class="fw-bold text-dark">ALL BLOGS</h1>
                <p class="text-muted fs-5">Dive deeper into our complete collection of blog posts.</p>
            </div>
        </div>

        <!-- Blog + Related Sidebar -->
        <div class="row g-5">
            <!-- Main Blog -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <img class="rounded" 
                                src="admin/assets/img/<?php echo !empty($blogData['image']) && file_exists('admin/assets/img/' . $blogData['image']) ? $blogData['image'] : 'default.jpg'; ?>" 
                                alt="Blog Image" width="140" height="140" style="object-fit: cover;">

                            <div class="ps-4">
                                <h2 class="fw-bold text-dark"><?php echo $blogData['title']; ?></h2>
                                <p class="text-muted mb-2"><?php echo htmlspecialchars($blogData['short_description']); ?></p>
                            </div>
                        </div>
                        <p class="fs-5 text-body"><?php echo $blogData['description']; ?></p>
                    </div>
                </div>

                <!-- Comment Form -->
                <div class="card border-0 shadow-sm mt-5">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Leave a Comment</h4>
                        <form method="POST" action="">
                            <!-- Rating -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                                <div id="rating-tooltip" class="bg-dark text-white px-2 py-1 rounded position-absolute d-none"></div>
                                <ul id="rating-stars" class="list-inline mb-0">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <li class="list-inline-item">
                                        <span id="star-<?php echo $i; ?>"
                                            onmouseover="showRatingTooltip(<?php echo $i; ?>)"
                                            onmouseout="hideRatingTooltip()"
                                            onclick="selectStars(<?php echo $i; ?>)"
                                            style="font-size: 24px; color: #ccc; cursor: pointer;">★</span>
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                                <input type="hidden" name="rating" id="rating-input" required>
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <input type="text" name="name" placeholder="Your name" required class="form-control">
                            </div>

                            <!-- Comment -->
                            <div class="mb-4">
                                <textarea name="comment" rows="4" placeholder="Write your comment..." required class="form-control"></textarea>
                            </div>

                            <button type="submit" name="submit_comment" class="btn btn-success px-4">Post Comment ➤</button>
                        </form>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="mt-5">
                    <h4 class="fw-bold mb-4">Comments</h4>
                    <?php 
                        $sql = "SELECT * FROM comments WHERE status = '1' AND article_id = $articleID ORDER BY created DESC";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-1"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="text-muted small mb-2"><?php echo date("F j, Y, g:i a", strtotime($row['created'])); ?></p>
                                <p class="mb-1"><?php echo nl2br(htmlspecialchars($row['comments'])); ?></p>
                                <p class="text-warning small mb-0">
                                    <?php echo str_repeat("⭐", $row['rating']); ?>
                                </p>
                            </div>
                        </div>
                    <?php
                            }
                        } else {
                            echo "<p class='text-muted'>No comments yet.</p>";
                        }
                    ?>
                </div>
            </div>

            <div class="col-lg-4">
                <h4 class="fw-bold mb-3">Related Blogs</h4>
                <?php 
                    $cateID = $blogData['category_id'];
                    $currentArticleId = $blogData['id'];

                    $sql1 = "SELECT * FROM article WHERE category_id = $cateID AND id != $currentArticleId ORDER BY id DESC LIMIT 2";
                    $result1 = mysqli_query($conn, $sql1);

                    if (mysqli_num_rows($result1) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result1)) {
                            $id = $row2["id"];
                            $title = $row2['title'];
                            $shortdescription = $row2['short_description'];
                            $image = (!empty($row2['image']) && file_exists("admin/assets/img/" . $row2['image']))
                                    ? "admin/assets/img/" . $row2['image']
                                    : "admin/assets/img/default.jpg";
                ?>

                <a href="blog_details.php?id=<?php echo $id; ?>" class="text-decoration-none text-dark related-blog-wrapper">
                    <div class="single-about media shadow p-3 rounded d-flex align-items-start mb-3 related-blog">
                        <img class="img-fluid rounded me-3" src="<?php echo $image; ?>" alt="Blog Image" width="70" height="70" style="object-fit: cover;">
                        <div class="media-body ps-2">
                            <h5 class="mt-0 mb-1 fw-bold" style="font-size: 18px;"><?php echo $title; ?></h5>
                            <p class="mb-0" style="font-size: 14px;"><?php echo htmlspecialchars($shortdescription); ?></p>
                        </div>
                    </div>
                </a>

                <?php
                        }
                    } else {
                        echo "<p>No related articles found.</p>";
                    }
                ?>

                <div class="text-end mt-3">
                    <a href="blogs.php" class="btn btn-success btn-sm px-3">View More ➤</a>
                </div>
            </div>
        </div>
    </div>					
</section>


<script>
    function showRatingTooltip(star) {
        const tooltip = document.getElementById("rating-tooltip");
        tooltip.innerText = ["Very Bad", "Bad", "Okay", "Good", "Excellent"][star - 1];
        tooltip.classList.remove("d-none");
        document.getElementById(`star-${star}`).parentElement.appendChild(tooltip);
    }

    function hideRatingTooltip() {
        document.getElementById("rating-tooltip").classList.add("d-none");
    }

    function selectStars(star) {
        for (let i = 1; i <= 5; i++) {
            document.getElementById("star-" + i).style.color = i <= star ? "#ffc107" : "#ccc";
        }
        document.getElementById("rating-input").value = star;
    }
</script>


<?php include("include/footer.php"); ?>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toast');
        if (toast) toast.remove();
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('comment');
            window.history.replaceState({}, document.title, url);
        }
    }, 3000);

    let selectedRating = 0;
    const ratingText = {1:"Ok",2:"Good",3:"Better",4:"Best",5:"Excellent"};
    function showRatingTooltip(rating) {
        const tooltip = document.getElementById("rating-tooltip");
        tooltip.style.display = "block";
        tooltip.textContent = ratingText[rating] || "";
        highlightStars(rating);
    }
    function hideRatingTooltip() {
        document.getElementById("rating-tooltip").style.display = "none";
        resetStars();
    }
    function selectStars(rating) {
        selectedRating = rating;
        highlightStars(rating);
        document.getElementById('rating-input').value = rating;
    }
    function highlightStars(count) {
        for (let i = 1; i <= 5; i++) {
            document.getElementById("star-" + i).style.color = i <= count ? "#FFD700" : "#ccc";
        }
    }
    function resetStars() {
        for (let i = 1; i <= 5; i++) {
            document.getElementById("star-" + i).style.color = i <= selectedRating ? "#FFD700" : "#ccc";
        }
    }
</script>
