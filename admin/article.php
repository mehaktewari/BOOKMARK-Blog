<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php
date_default_timezone_set('Asia/Kolkata');

// DELETE logic
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $delete_id = (int) $_GET['id'];
    $delete_sql = "DELETE FROM article WHERE id = $delete_id";
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => '✅ Article deleted successfully!'
        ];
    } else {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => '❌ Error deleting article!'
        ];
    }
    header("Location: article.php");
    exit;
}

// FETCH ARTICLES
$users = [];
$result = mysqli_query($conn, "SELECT id, category_id, title, short_description , description, image , status, created FROM article ORDER BY created ASC ");
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>

<body class="">
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


    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <?php include("include/navBar.php"); ?>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="m-b-10">ARTICLE</h5>
                                <a href="add_article.php" class="btn btn-primary">Add Articles</a>
                            </div>
                            <div class="card">
                                <div class="card-body table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="articleTable" style=" background-color: #343a40 !important, color: white !important;">
                                            <thead >
                                                <tr>
                                                    <th>S.NO</th>
                                                    <th>CATEGORY</th>
                                                    <th>TITLE</th>
                                                    <th>SHORT DESCRIPTION</th>
                                                    <th>IMAGE</th>
                                                    <th>Status</th>
                                                    <th>CREATED</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($users)): ?>
                                                    <?php foreach ($users as $index => $user): ?>
                                                        <tr>
                                                            <td><?= $index + 1; ?></td>
                                                            <td>
                                                                <?php
                                                                $catId = $user["category_id"];
                                                                $res = mysqli_query($conn,"SELECT * FROM category WHERE id = $catId");
                                                                $data = mysqli_fetch_assoc($res);   
                                                                echo $catName = $data['category_name'];
                                                                ?>
                                                            </td>
                                                            <td><?= htmlspecialchars($user['title']); ?></td>
                                                            <td>
                                                                <?= htmlspecialchars(substr($user['short_description'], 0, 50)) . '...'; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($user['image'])): ?>
                                                                    <img src="assets/img/<?= htmlspecialchars($user['image']) ?>" alt="Article Image" width="80">
                                                                <?php else: ?>
                                                                    No Image
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= ($user['status'] == '1') ? "Active" : "Inactive"; ?></td>
                                                            <td><?= $user['created']; ?></td>
                                                            <td>
                                                                <a href="edit_article.php?action=edit&id=<?= $user['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                                <a href="article.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-danger"
                                                                   onclick="return confirm('Are you sure you want to delete this Article?')">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">No Article found.</td>
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
</body>

<style>
    #articleTable thead th {
        background-color: #343a40 !important;
        color: white !important;
    }
</style>

<script>
    $(document).ready(function() {
        $('#articleTable').DataTable({
            paging: true,
            pageLength: 10,
            lengthChange: false,
            ordering: false,
            info: true,
            searching: true,
        });
    });

    // Toast auto-dismiss
    document.addEventListener("DOMContentLoaded", function () {
        const toast = document.getElementById("custom-toast");
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = "0";
                setTimeout(() => toast.remove(), 500);
            }, 3000); // 3 seconds
        }
    });
</script>
