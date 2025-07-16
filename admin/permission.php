<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php include("check_permission.php"); ?>

<?php 
date_default_timezone_set('Asia/Kolkata');
// Handle deletion
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $delete_id = (int) $_GET['id'];
    $delete_sql = "DELETE FROM permissions WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => '✅ Permission deleted successfully!'
        ];
        header("Location: permission.php");
        exit;
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Error deleting permission.'
        ];
        header("Location: permission.php");
        exit;
    }
}
$permissions = [];
$result = mysqli_query($conn, "SELECT id, page_name, status, created FROM permissions ORDER BY created ASC");
while ($row = mysqli_fetch_assoc($result)) {
    $permission[] = $row;
}
?>


 <style>
    #permissionTable thead th {
        background-color: #343a40 !important;
        color: white !important;
    }
</style>
<body class="">
    <!-- Toast -->
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

    <?php include("include/navBar.php"); ?>

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="m-b-10">PERMISSION</h5>
                                <a href="add_permission.php" class="btn btn-primary">Add Permission</a>
                            </div>

                            <div class="card">
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="permissionTable">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Page NAME</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($permission)): ?>
                                                    <?php foreach ($permission as $index => $permissions): ?>
                                                        <tr>
                                                            <td><?= $index + 1; ?></td>
                                                            <td><?= htmlspecialchars($permissions['page_name']); ?></td>
                                                            <td><?= ($permissions['status'] == '1') ? "Active" : "Inactive"; ?></td>
                                                            <td><?= $permissions['created']; ?></td>
                                                            <td>
                                                                <a href="edit_permission.php?action=edit&id=<?= $permissions['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                                <a href="permission.php?id=<?= $permissions['id']; ?>" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this permission?')">Delete</a>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">No Permission found.</td>
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
            $('#permissionTable').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: false,
                ordering: false,
                info: true,
                searching: true,
            });
        });

        // Toast Auto Hide
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

