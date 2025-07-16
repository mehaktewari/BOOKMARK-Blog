<?php
session_start();
include("config.php");
include("check_permission.php");
include("include/adminHeader.php");

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
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => '❌ You are not logged in.'];
            header("Location: login.php");
            exit;
        }

        $sql = "INSERT INTO article (title, category_id, short_description, description, image, status, created, updated, added_by) 
                VALUES ('$title', '$category_id', '$short_description', '$description', '$image', '$status', NOW(), NOW(), '$userId')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['toast'] = ['type' => 'success', 'message' => '✅ Article added successfully!'];
            header("Location: article.php");
            exit;
        } else {
            $_SESSION['toast'] = ['type' => 'error', 'message' => '❌ DB Error: ' . mysqli_error($conn)];
        }
    }
}
?>

<body>
<?php include("include/navBar.php"); ?>
<?php if (isset($_SESSION['toast'])): ?>
    <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
    <div id="custom-toast" style="
        position:fixed;top:20px;right:20px;
        background-color: <?= $toast['type'] === 'success' ? '#d4edda' : '#f8d7da' ?>;
        color: <?= $toast['type'] === 'success' ? '#155724' : '#721c24' ?>;
        padding:12px 24px;border:1px solid <?= $toast['type'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
        border-radius:8px;z-index:9999;">
        <?= htmlspecialchars($toast['message']) ?>
    </div>
<?php endif; ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header"><h5>Add New Article</h5></div>
        <div class="card mt-3">
            <div class="card-header"><h5>Article Details</h5></div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>CATEGORY</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <option value="<?= $row['id'] ?>" <?= $category_id == $row['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['category_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>TITLE</label>
                        <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($title) ?>">
                    </div>
                    <div class="form-group">
                        <label>IMAGE</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="form-group">
                        <label>STATUS</label>
                        <select name="status" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>SHORT DESCRIPTION</label>
                        <textarea class="form-control" name="short_description"><?= htmlspecialchars($short_description) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>DESCRIPTION</label>
                        <textarea class="form-control summernote" name="description"><?= htmlspecialchars($description) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="article.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.summernote').summernote({ height: 250 });
    });

    setTimeout(() => {
        const toast = document.getElementById("custom-toast");
        if (toast) toast.remove();
    }, 3000);
</script>
<?php include("include/adminFooter.php"); ?>
</body>
