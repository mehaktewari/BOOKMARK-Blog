<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>

<?php

$errors = [];
$email = $first_name = $last_name = $password = $address ='';
$user_id = $_SESSION['user_id'];

$sql = "SELECT first_name, last_name, email_address, address FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-danger text-center mt-5'>User not found.</div>";
    exit();
}

$user = mysqli_fetch_assoc($result);
$full_name = $user['first_name'] . ' ' . $user['last_name'];
$email = $user['email_address'];
$address = $user['address'];
$profile_image = 'assets/images/male.avif'; 
?>

<body>
<?php include("include/navBar.php"); ?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <!-- Profile Image -->
                        <img src="assets/images/male.avif" alt="Profile Image"
                             class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">

                        <h4 class="mb-1"><?= htmlspecialchars($full_name) ?></h4>
                        <p class="text-muted"><?= htmlspecialchars($email) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Details Card -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Profile Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Full Name:</strong> <?= htmlspecialchars($full_name) ?></p>
                        <p><strong>Email Address:</strong> <?= htmlspecialchars($email) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("include/adminFooter.php"); ?>
<script>
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
</script>
</body>
