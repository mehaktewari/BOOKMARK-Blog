<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php
date_default_timezone_set('Asia/Kolkata');

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
$errors = [];

$email_address = $first_name = $last_name = $password = $address = $status = '';

$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_address = mysqli_real_escape_string($conn, trim($_POST['email_address'] ?? ''));
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name'] ?? ''));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name'] ?? ''));
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));
    $address = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    $status = mysqli_real_escape_string($conn, trim($_POST['status'] ?? ''));

    if (empty($email_address) || empty($first_name) || empty($last_name) || empty($password) || $status === '') {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Please fill all required fields.'
        ];
    } else {
        if ($action === 'edit' && $id > 0) {
            $update_sql = "UPDATE users SET 
                email_address = '$email_address', 
                first_name = '$first_name', 
                last_name = '$last_name', 
                password = '$password', 
                address = '$address', 
                status = '$status', 
                updated = NOW() 
                WHERE id = $id";

            if (mysqli_query($conn, $update_sql)) {
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => '✅ User updated successfully!'
                ];
                header("Location: users.php");
                exit;
            } else {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'message' => '❌ Failed to update user.'
                ];
            }
        }
    }
}
?>

<body>
<?php include("include/navBar.php"); ?>

<!-- ✅ Toast Message -->
<?php if (isset($_SESSION['toast'])): ?>
    <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
    <div id="custom-toast" style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
        background-color: <?= $toast['type'] === 'success' ? '#d4edda' : '#f8d7da' ?>;
        color: <?= $toast['type'] === 'success' ? '#155724' : '#721c24' ?>;
        padding: 12px 24px; border: 1px solid <?= $toast['type'] === 'success' ? '#c3e6cb' : '#f5c6cb' ?>;
        border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); font-weight: 500; z-index: 9999;
        transition: opacity 0.5s ease-in-out;">
        <?= htmlspecialchars($toast['message']) ?>
    </div>
<?php endif; ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <h5 class="m-b-10">Edit User</h5>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Edit User</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>EMAIL ADDRESS</label>
                                    <input type="email" name="email_address" class="form-control" value="<?= htmlspecialchars($data["email_address"] ?? ''); ?>" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>PASSWORD</label>
                                    <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($data["password"] ?? ''); ?>" required>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>FIRST NAME</label>
                                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($data["first_name"] ?? ''); ?>" required>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>LAST NAME</label>
                                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($data["last_name"] ?? ''); ?>" required>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label>ADDRESS</label>
                                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($data["address"] ?? ''); ?>">
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label for="status">STATUS</label>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="1" <?= ($data["status"] == '1') ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?= ($data["status"] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                    <a href="users.php" class="btn btn-secondary ml-2">Back</a>
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

<!-- ✅ Toast Auto Hide -->
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