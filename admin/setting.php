<?php
include("include/adminHeader.php");
include("config.php");
include("check_permission.php");


$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$full_name = $user['first_name'] . ' ' . $user['last_name'];
$email = $user['email_address'];
?>

<!-- Optional Global Dark Mode CSS -->
<style>
.dark-mode {
    background-color: #121212;
    color: #ffffff;
}

.dark-mode .card {
    background-color: #1f1f1f;
    border-color: #333;
}

.dark-mode input,
.dark-mode textarea {
    background-color: #2c2c2c;
    color: #fff;
    border: 1px solid #444;
}

.dark-mode .form-check-label {
    color: #ccc;
}

.dark-mode .btn {
    background-color: #2c2c2c;
    color: #fff;
}
</style>
<!-- Apply dark mode if localStorage enabled (JS runs early) -->
<body>
<script>
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }
</script>

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
                        <div class="page-header-title">
                            <h5 class="m-b-10">SETTINGS</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center py-4">
                <img src="assets/images/male.avif" alt="User Image" class="rounded-circle mx-auto d-block" width="140" height="140" style="object-fit: cover; border: 4px solid #ddd;">

                <div class="card-body">
                    <h4 class="card-title mb-2"><?= htmlspecialchars($full_name) ?></h4>
                    <p class="text-muted mb-0"><?= htmlspecialchars($email) ?></p>
                </div>
            </div>
        </div>
    </div>

        <!-- Theme & Display Settings -->
        <div class="row">

            <!-- Theme Toggle -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Theme Mode</h5>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="darkModeToggle">
                            <label class="form-check-label" for="darkModeToggle">Enable Dark Mode</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display Preferences (Future Feature) 
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Display Preferences</h5>
                        <p class="text-muted mb-0">Feature coming soon: Customize font size, layout, and UI theme.</p>
                    </div>
                </div>
            </div>-->

            <!-- Social Media Links -->
            <div class="col-md-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">My Social Profiles</h5>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>LinkedIn:</strong>
                                <a href="https://www.linkedin.com/in/mehak-tewari-04934b247/" target="_blank" class="ms-2 text-primary">
                                    Visit Profile ➤
                                </a>
                            </li>
                            <li class="list-group-item">
                                <strong>Instagram:</strong>
                                <a href="https://www.instagram.com/_mehak_._tewari_?igsh=Z2d3YzBmZ2p4dDk5" target="_blank" class="ms-2 text-primary">
                                    Visit Profile ➤
                                </a>
                            </li>
                            <li class="list-group-item">
                                <strong>Telegram:</strong>
                                <a href="t.me/mehaktewari" target="_blank" class="ms-2 text-info">
                                    Visit Profile ➤
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php include("include/adminFooter.php"); ?>

<!-- Dark Mode Script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('darkModeToggle');
    const isDark = localStorage.getItem('darkMode') === 'enabled';

    if (isDark) {
        document.body.classList.add('dark-mode');
        if (toggle) toggle.checked = true;
    }

    if (toggle) {
        toggle.addEventListener('change', () => {
            if (toggle.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    }
});
</script>


</body>
