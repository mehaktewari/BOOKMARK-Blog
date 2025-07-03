<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>

<?php
$errors = [];
$success = '';

$category_name = '';
$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim(mysqli_real_escape_string($conn, $_POST['category_name']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($category_name)) {
        $errors[] = "Category is required.";
    }

    if (!isset($_POST['status']) || $_POST['status'] === '') {
        $errors[] = "Status is required.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO category (category_name, status, created)
                VALUES ('$category_name','$status', NOW())";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => '✅ Category added successfully!'
            ];
            header("Location: category.php");
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

    <!-- Toast Message -->
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
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Add New Category</h5>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h5>Category Details</h5>
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
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="Category">CATEGORY</label>
                                                    <input type="text" class="form-control" name="category_name" id="Category" value="<?= htmlspecialchars($category_name) ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="status">STATUS</label>
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="">-- Select Status --</option>
                                                        <option value="1" <?= ($status === '1') ? 'selected' : '' ?>>Active</option>
                                                        <option value="0" <?= ($status === '0') ? 'selected' : '' ?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                                <a href="category.php" class="btn btn-secondary">Back</a>
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
    </script>
</body>
