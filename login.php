<?php
session_start();
include("admin/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href='index.php';</script>";
        exit;
    }

    $email = mysqli_real_escape_string($conn, $email);
    $query = "SELECT * FROM users WHERE email_address = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name']; 
            $_SESSION['email']     = $user['email_address'];
            $_SESSION['role_id']   = $user['role_id']; 

            
            if ($user['role_id'] == 1) {
              header("Location: admin/dashboad.php");
           } else {
                
             header("Location: admin/dashboad.php");
            }
            exit;
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('No user found with that email.'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit;
}
?>

	<section class="banner-area relative" id="home" style="background-image: url('assets/logo/picture1.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 80vh;">
			<div class="container" style="position: relative; z-index: 2;">
				<div class="row fullscreen align-items-center justify-content-center">
					<div class="col-lg-12 text-center">
						<h1 class="text-white fw-bold">
							The books that the world calls immoral <br>
							Are books that show the world its own shame.
						</h1>
					</div>												
				</div>
			</div>
		</div>
	</section>