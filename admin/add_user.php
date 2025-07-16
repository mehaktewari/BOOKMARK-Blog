<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php include("check_permission.php"); ?>

<?php
$errors = [];
$email = $first_name = $last_name = $password = $address = $status = $role_id = '';

date_default_timezone_set('Asia/Kolkata');

// ✅ Fetch all active roles for dropdown
$roles = [];
$role_result = mysqli_query($conn, "SELECT id, role_name FROM role WHERE status = '1'");
while ($row = mysqli_fetch_assoc($role_result)) {
    $roles[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $first_name = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $last_name = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $password = trim($_POST['password']);
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : null;

    // Validation
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if ($status !== "0" && $status !== "1") $errors[] = "Status is required.";
    if (empty($role_id)) $errors[] = "Role is required.";

    if (empty($errors)) {
        $sql = "INSERT INTO users (email_address, first_name, last_name, password, address, status, role_id, created)
                VALUES ('$email', '$first_name', '$last_name', '$password', '$address', '$status', '$role_id', NOW())";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => '✅ User added successfully!'
            ];
            header("Location: users.php");
            exit;
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Please fill all required fields.'
        ];
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
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add New User</h5>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h5>User Details</h5>
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

                                <form method="POST" action="">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="Email">EMAIL ADDRESS</label>
                                                <input type="email" class="form-control" name="email" id="Email" placeholder="john@gmail.com" value="<?= htmlspecialchars($email) ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="first_name">FIRST NAME</label>
                                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="john" value="<?= htmlspecialchars($first_name) ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="last_name">LAST NAME</label>
                                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="doe" value="<?= htmlspecialchars($last_name) ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="password">PASSWORD</label>
                                                <input type="password" class="form-control" name="password" id="password" value="<?= htmlspecialchars($password) ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="status">STATUS</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" <?= $status === "1" ? "selected" : "" ?>>Active</option>
                                                    <option value="0" <?= $status === "0" ? "selected" : "" ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="role_id">ROLE</label>
                                                <select name="role_id" id="role_id" class="form-control">
                                                    <option value="">-- Select Role --</option>
                                                    <?php foreach ($roles as $role): ?>
                                                        <option value="<?= $role['id']; ?>" <?= ($role_id == $role['id']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($role['role_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="address1">ADDRESS</label>
                                                <textarea class="form-control" name="address" id="address1" placeholder="1234 Main St"><?= htmlspecialchars($address) ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <a href="users.php" class="btn btn-secondary">Back</a>
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
