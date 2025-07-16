<?php
session_start();
include("config.php");
include("check_permission.php");
include("include/adminHeader.php");

$errors = [];
$category_name = '';
$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim(mysqli_real_escape_string($conn, $_POST['category_name']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($category_name)) $errors[] = "Category is required.";
    if (!isset($_POST['status']) || $_POST['status'] === '') $errors[] = "Status is required.";

    if (empty($errors)) {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            $_SESSION['toast'] = ['type' => 'error', 'message' => '❌ You are not logged in.'];
            header("Location: login.php");
            exit;
        }

        $sql = "INSERT INTO category (category_name, status, created, updated, added_by) 
                VALUES ('$category_name', '$status', NOW(), NOW(), '$userId')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['toast'] = ['type' => 'success', 'message' => '✅ Category added successfully!'];
            header("Location: category.php");
            exit;
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}
?>

<body>
<?php include("include/navBar.php"); ?>
<?php if (isset($_SESSION['toast'])): ?>
    <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
    <div id="custom-toast" style="position:fixed;top:20px;left:50%;transform:translateX(-50%);
         background-color: <?= $toast['type'] === 'success' ? '#d4edda' : '#f8d7da' ?>;
         color: <?= $toast['type'] === 'success' ? '#155724' : '#721c24' ?>;
         padding:12px 24px;border:1px solid <?= $toast['type'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
         border-radius:8px;z-index:9999;">
        <?= htmlspecialchars($toast['message']) ?>
    </div>
<?php endif; ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header"><h5>Add New Category</h5></div>
        <div class="card mt-3">
            <div class="card-header"><h5>Category Details</h5></div>
            <div class="card-body">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul><?php foreach ($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?></ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label>CATEGORY</label>
                        <input type="text" class="form-control" name="category_name" value="<?= htmlspecialchars($category_name) ?>">
                    </div>
                    <div class="form-group">
                        <label>STATUS</label>
                        <select name="status" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="1" <?= ($status === '1') ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= ($status === '0') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="category.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        const toast = document.getElementById("custom-toast");
        if (toast) toast.remove();
    }, 3000);
</script>
<?php include("include/adminFooter.php"); ?>
</body>
