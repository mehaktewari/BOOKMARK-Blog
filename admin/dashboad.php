<?php include("include/adminHeader.php"); ?>
<?php include("config.php"); ?>
<?php

$userCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$userCount = mysqli_fetch_assoc($userCountQuery)['total'];

$categoryCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM category");
$categoryCount = mysqli_fetch_assoc($categoryCountQuery)['total'];

$articleCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM article");
$articleCount = mysqli_fetch_assoc($articleCountQuery)['total'];

$contactCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM contacts");
$contactCount = mysqli_fetch_assoc($contactCountQuery)['total'];

$latestArticlesQuery = mysqli_query($conn, "SELECT title, category_id, created, status FROM article ORDER BY created DESC LIMIT 10");

$latestUsersQuery = mysqli_query($conn, "SELECT first_name, last_name, email_address, created FROM users ORDER BY created DESC LIMIT 10");
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
                            <div class="page-header-title">
                                <h5 class="m-b-10">Dashboard Analytics</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card flat-card">
                        <div class="row-table">
                            <div class="col-sm-6 card-body br">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-user text-c-green mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $userCount; ?></h5>
                                        <span><a href="users.php">Users</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-layers text-c-red mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $categoryCount; ?></h5>
                                        <span><a href="category.php">Categories</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-table">
                            <div class="col-sm-6 card-body br">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-file-text text-c-blue mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $articleCount; ?></h5>
                                        <span><a href="articles.php">Articles</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-mail text-c-yellow mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $contactCount; ?></h5>
                                        <span><a href="contacts.php">Contacts</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Articles Table -->
            <div class = "row" >
                <div class="col-md-12">
                    <div class="card table-card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>Latest Articles</h5>
                            <a href="article.php" class="btn btn-sm btn-primary">View More</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Title</th>
                                            <th>Category ID</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 0; ?>
                                        <?php while ($article = mysqli_fetch_assoc($latestArticlesQuery)) : ?>
                                            <tr>
                                                <td><?= ++$index; ?></td>
                                                <td><?php echo htmlspecialchars($article['title']); ?></td>
                                                <td>
                                                    <?php
                                                    $catId = $article["category_id"];                                                             
                                                    $res = mysqli_query($conn,"SELECT * FROM category where id = $catId");
                                                    $data = mysqli_fetch_assoc($res);   
                                                    echo $catName = $data['category_name'];
                                                    ?>
                                                </td>
                                                <td><?php echo date('d-m-Y h:i A', strtotime($article['created'])); ?></td>
                                                <td><?= ($article['status'] == '1') ? "Active" : "Inactive"; ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Preview -->
             <div class = "row" >
                <div class="col-md-12">
                    <div class="card table-card">
                        <div class="card-header d-flex justify-content-between">
                            <h5>Latest Users</h5>
                            <a href="users.php" class="btn btn-sm btn-primary">View More</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>S>NO</th>
                                            <th>NAME</th>
                                            <th>EMAIL ADDRESS</th>
                                            <th>CREATED</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $index = 0; ?>
                                        <?php while ($user = mysqli_fetch_assoc($latestUsersQuery)) : ?>
                                            <tr>
                                                <td><?= ++$index; ?></td>
                                                <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                                <td><?= htmlspecialchars($user['email_address']); ?></td>
                                                <td><?= date('d-m-Y h:i A', strtotime($user['created'])); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>

                                </table>
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

