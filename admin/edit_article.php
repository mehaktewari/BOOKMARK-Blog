<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php
date_default_timezone_set('Asia/Kolkata');

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
$errors = [];
$message = '';

$category_id = $title = $short_description = $description = $image = $status = '';

$query = "SELECT * FROM article WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = trim(mysqli_real_escape_string($conn, $_POST['category_id']));
    $title = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $short_description = trim(mysqli_real_escape_string($conn, $_POST['short_description']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($category_id)) $errors[] = "Category is required.";
    if (empty($title)) $errors[] = "Title is required.";
    if (!isset($_POST['status']) || $_POST['status'] === '') $errors[] = "Status is required.";
    if (empty($short_description)) $errors[] = "Short Description is required.";
    if (empty($description)) $errors[] = "Description is required.";

    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . basename($_FILES['image']['name']);
        $target_dir = "assets/img/";
        $target_file = $target_dir . $image;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $errors[] = "Failed to upload image.";
        }
    } else {
        $image = $data['image'];
    }

    if (empty($errors)) {
        $update_sql = "UPDATE article SET 
            category_id = '$category_id', 
            title = '$title', 
            short_description = '$short_description', 
            description = '$description', 
            image = '$image', 
            status = '$status', 
            updated = NOW() 
            WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => '✅ Article edited successfully!'
            ];
            header("Location: article.php");
            exit;
        } else {
            $errors[] = "Failed to update Article.";
        }
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Please fill all required fields.'
        ];
    }
}
?>
?>

<body>
<?php include("include/navBar.php"); ?>

<!-- Toast Message -->
<?php if (isset($_SESSION['toast']) && $_SESSION['toast'] === 'edit_error'): ?>
    <div id="custom-toast" style="position: fixed;top: 20px;left: 50%;
        transform: translateX(-50%);background-color: #f8d7da;
        color: #721c24;padding: 12px 24px;border: 1px solid #f5c6cb;
        border-radius: 8px;box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-weight: 500;z-index: 9999;transition: opacity 0.5s ease-in-out;">
        ❌ Please fill all fields before submitting.
    </div>
    <?php unset($_SESSION['toast']); ?>
<?php endif; ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Article</h5>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>Edit Article</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" class="form-control" id="category_id">
                                                <option value="">-- Select Category --</option>
                                                <?php
                                                $cat_result = mysqli_query($conn, "SELECT id, category_name FROM category");
                                                while ($cat = mysqli_fetch_assoc($cat_result)) {
                                                    $selected = ($data['category_id'] == $cat['id']) ? 'selected' : '';
                                                    echo "<option value=\"{$cat['id']}\" $selected>{$cat['category_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                value="<?= htmlspecialchars($data['title'] ?? '') ?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Current Image</label>
                                            <?php if (!empty($data['image'])): ?>
                                                <div class="mt-2">
                                                    <img src="assets/img/<?= htmlspecialchars($data['image']); ?>" alt="Current Image" width="100">
                                                    <p class="text-muted mb-0">Current Image</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="">-- Select Status --</option>
                                                <option value="1" <?= ($data['status'] == '1') ? 'selected' : ''; ?>>Active</option>
                                                <option value="0" <?= ($data['status'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="short_description">Short Description</label>
                                            <textarea class="form-control" name="short_description" id="short_description" rows="4"><?= htmlspecialchars($data['short_description'] ?? '') ?></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="description">Description</label>
                                            <textarea class="form-control summernote" name="description" id="description" rows="4"><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group text-left">
                                        <button type="submit" class="btn btn-success">Update Article</button>
                                        <a href="article.php" class="btn btn-secondary">Back</a>
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

<?php include("include/adminFooter.php"); ?>

<!-- Summernote -->
<script>
    $(document).ready(function() {
    $('.summernote').summernote({
        height: 250,
        codemirror: {
            theme: 'monokai'
        }
    });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const toast = document.getElementById("custom-toast");
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }
    });
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
</script>

</body>
