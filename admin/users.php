<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php
date_default_timezone_set('Asia/Kolkata');

// Handle delete
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $delete_id = (int) $_GET['id'];
    $delete_sql = "DELETE FROM users WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => '✅ User deleted successfully!'
        ];
        header("Location: users.php");
        exit;
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Failed to delete user.'
        ];
        header("Location: users.php");
        exit;
    }
}

// Fetch userss
$users = [];
$result = mysqli_query($conn, "SELECT id, first_name, last_name, email_address, status, created FROM users ORDER BY created ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>
<style>
    #usersTable thead th {
        background-color: #343a40 !important;
        color: white !important;
    }
</style>
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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="m-b-10">USERS</h5>
                            <a href="add_user.php" class="btn btn-primary">Add User</a>
                        </div>
                        <div class="card">
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="usersTable">
                                        <thead>
                                            <tr>
                                                <th>S.NO</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($users)): ?>
                                                <?php foreach ($users as $index => $user): ?>
                                                    <tr>
                                                        <td><?= $index + 1; ?></td>
                                                        <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                                        <td><?= htmlspecialchars($user['email_address']); ?></td>
                                                        <td><?= ($user['status'] == '1') ? "Active" : "Inactive"; ?></td>
                                                        <td><?= $user['created']; ?></td>
                                                        <td>
                                                            <a href="edit_user.php?action=edit&id=<?= $user['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                            <a href="users.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-danger"
                                                               onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No users found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
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
    $(document).ready(function() {
        $('#usersTable').DataTable({
            paging: true,
            pageLength: 10,
            lengthChange: false,
            ordering: false,
            info: true,
            searching: true,
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
