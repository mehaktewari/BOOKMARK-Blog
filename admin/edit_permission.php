<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php include("check_permission.php"); ?>

<?php
date_default_timezone_set('Asia/Kolkata');

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
$errors = [];

$query = "SELECT * FROM permissions WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page_name = trim($_POST['page_name'] ?? '');
    $status = trim($_POST['status'] ?? '');

    $page_name = mysqli_real_escape_string($conn, $page_name);
    $status = mysqli_real_escape_string($conn, $status);

    if (empty($page_name) || $status === '') {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Please fill all required fields.'
        ];
    } else {
        $update_sql = "UPDATE permissions SET page_name = '$page_name', status = '$status', updated = NOW() WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => '✅ Permission edited successfully!'
            ];
            header("Location: permission.php");
            exit;
        } else {
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => '❌ Failed to update permission.'
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
                <h5 class="m-b-10">Permission</h5>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Edit Permission</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Page Name</label>
                                    <input type="text" name="page_name" class="form-control" value="<?= htmlspecialchars($data["page_name"] ?? ''); ?>">
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="form-group">
                                        <label for="status">Status</label>
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
                                    <button type="submit" class="btn btn-primary">Update Role</button>
                                    <a href="permission.php" class="btn btn-secondary ml-2">Back</a>
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
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});
if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
</script>
</body>