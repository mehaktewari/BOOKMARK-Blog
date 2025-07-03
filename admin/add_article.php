<?php
include("include/adminHeader.php");
include("config.php");
?>
<?php
$errors = [];

$category_id = '';
$title = '';
$short_description = '';
$description = '';
$status = '';
$image = '';

$result = mysqli_query($conn, 'SELECT * FROM category') or die(mysqli_error($conn));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = trim(mysqli_real_escape_string($conn, $_POST['category_id']));
    $title = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $short_description = trim(mysqli_real_escape_string($conn, $_POST['short_description']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $errors[] = "Image is required.";
    }

    if (empty($category_id)) $errors[] = "Category is required.";
    if (empty($title)) $errors[] = "Title is required.";
    if (!isset($_POST['status']) || $_POST['status'] === '') $errors[] = "Status is required.";
    if (empty($short_description)) $errors[] = "Short Description is required.";
    if (empty($description)) $errors[] = "Description is required.";

    if (empty($errors)) {
        $sql = "INSERT INTO article (category_id, title, short_description, description, image, status, created)
                VALUES ('$category_id','$title', '$short_description','$description','$image','$status', NOW())";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['toast'] = ['type' => 'success', 'message' => '✅ Article added successfully!'];
            header("Location: article.php");
            exit;
        } else {
            $_SESSION['toast'] = ['type' => 'error', 'message' => '❌ Failed to add article. Please try again.'];
            header("Location: add_article.php");
            exit;
        }
    }
}
?>

<body>
<?php if (isset($_SESSION['toast'])): ?>
    <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
    <div id="custom-toast" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: <?= $toast['type'] === 'success' ? '#d4edda' : '#f8d7da' ?>;
        color: <?= $toast['type'] === 'success' ? '#155724' : '#721c24' ?>;
        padding: 12px 24px;
        border: 1px solid <?= $toast['type'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-weight: 500;
        z-index: 9999;
        transition: opacity 0.5s ease-in-out;">
        <?= htmlspecialchars($toast['message']) ?>
    </div>
<?php endif; ?>

<?php include("include/navBar.php"); ?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add New Article</h5>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>Article Details</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($errors)): ?>
                                    <div class="alert alert-danger">
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                                <li><?= htmlspecialchars($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="category_id">CATEGORY</label>
                                                <select name="category_id" class="form-control" id="category_id">
                                                    <option value="">-- Select Category --</option>
                                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                        <option value="<?= $row['id'] ?>" <?= $category_id == $row['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($row['category_name']) ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">TITLE</label>
                                                <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($title) ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="image">IMAGE</label>
                                                <input type="file" class="form-control" name="image" id="image">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="status">STATUS</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Active</option>
                                                    <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="short_description">SHORT DESCRIPTION</label>
                                                <textarea class="form-control" name="short_description" id="short_description"><?= htmlspecialchars($short_description) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="description">DESCRIPTION</label>
                                                <textarea class="form-control summernote" name="description" id="description"><?= htmlspecialchars($description) ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <a href="article.php" class="btn btn-secondary">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<?php include("include/adminFooter.php"); ?>

<!-- Summernote init -->
<script>
$(document).ready(function() {
  $('.summernote').summernote({
    height: 250,
    codemirror: {
      theme: 'monokai'
    }
  });
});
</script>

<!-- Auto-hide toast -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const toast = document.getElementById("custom-toast");
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }
});
</script>
