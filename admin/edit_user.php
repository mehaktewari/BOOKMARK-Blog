<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php include("check_permission.php"); ?>

<?php
date_default_timezone_set('Asia/Kolkata');

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
$errors = [];

$email_address = $first_name = $last_name = $password = $address = $status = $role_id = '';

// Fetch user data
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Fetch all active roles
$roles = [];
$role_result = mysqli_query($conn, "SELECT id, role_name FROM role WHERE status = '1'");
while ($row = mysqli_fetch_assoc($role_result)) {
    $roles[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_address = mysqli_real_escape_string($conn, trim($_POST['email_address'] ?? ''));
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name'] ?? ''));
    $last_name = mysqli_real_escape_string($conn, trim($_POST['last_name'] ?? ''));
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));
    $address = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));
    $status = mysqli_real_escape_string($conn, trim($_POST['status'] ?? ''));
    $role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : null;

    if (empty($email_address) || empty($first_name) || empty($last_name) || empty($password) || $status === '' || empty($role_id)) {
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
                role_id = '$role_id', 
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
                                    <label for="status">STATUS</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">-- Select Status --</option>
                                        <option value="1" <?= ($data["status"] == '1') ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?= ($data["status"] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <label for="role_id">ROLE</label>
                                    <select name="role_id" class="form-control" required>
                                        <option value="">-- Select Role --</option>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id']; ?>" <?= ($data['role_id'] == $role['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($role['role_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <label>ADDRESS</label>
                                    <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($data["address"] ?? ''); ?></textarea>
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
