<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php include("check_permission.php"); ?>

<?php
date_default_timezone_set('Asia/Kolkata');

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
$errors = [];

$query = "SELECT * FROM category WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = trim($_POST['category_name'] ?? '');
    $status = trim($_POST['status'] ?? '');

    $category_name = mysqli_real_escape_string($conn, $category_name);
    $status = mysqli_real_escape_string($conn, $status);

    if (empty($category_name) || $status === '') {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Please fill all required fields.'
        ];
    } else {
        $update_sql = "UPDATE category SET category_name = '$category_name', status = '$status', updated = NOW() WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => '✅ Category edited successfully!'
            ];
            header("Location: category.php");
            exit;
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => '❌ Failed to update category.'
            ];
        }
    }
}
?>

<body>
<?php include("include/navBar.php"); ?>

<!-- Toast -->
<?php if (isset($_SESSION['toast'])): ?>
    <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
    <div id="custom-toast" style="position: fixed;top: 20px;left: 50%;transform: translateX(-50%);
        background-color: <?= $toast['type'] === 'success' ? '#d4edda' : '#f8d7da' ?>;
        color: <?= $toast['type'] === 'success' ? '#155724' : '#721c24' ?>;
        padding: 12px 24px;border: 1px solid <?= $toast['type'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
        border-radius: 8px;box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-weight: 500;z-index: 9999;transition: opacity 0.5s ease-in-out;">
        <?= htmlspecialchars($toast['message']) ?>
    </div>
<?php endif; ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <h5 class="m-b-10">Edit Category</h5>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Edit Category</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>CATEGORY</label>
                                    <input type="text" name="category_name" class="form-control" value="<?= htmlspecialchars($data["category_name"] ?? ''); ?>">
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="form-group">
                                        <label for="status">STATUS</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">-- Select Status --</option>
                                            <option value="1" <?= ($data["status"] == '1') ? 'selected':''; ?> >Active</option>
                                            <option value="0" <?= ($data["status"] == '0') ? 'selected':''; ?> >Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                    <a href="category.php" class="btn btn-secondary ml-2">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include("include/adminFooter.php"); ?>

<!-- Toast Auto Hide -->
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
if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
</script>
</body>