<?php 
include("include/registeration_header.php");
include("admin/config.php");
?>

<?php
$errors = [];
$success = '';

$email = $first_name = $last_name = $password = $address = $status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $first_name = trim(mysqli_real_escape_string($conn, $_POST['first_name']));
    $last_name = trim(mysqli_real_escape_string($conn, $_POST['last_name']));
    $password = trim($_POST['password']);
    $address = trim(mysqli_real_escape_string($conn, $_POST['address']));
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if (empty($email)) $errors[] = "Email is required.";
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($password)) $errors[] = "Password is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if ($status !== "0" && $status !== "1") $errors[] = "Status is required.";

    if (empty($errors)) {

        $sql = "INSERT INTO users (email_address, first_name, last_name, password, address, status, created)
                VALUES ('$email', '$first_name', '$last_name', '$password', '$address', '$status', NOW())";

        if (mysqli_query($conn, $sql)) {
            session_start();
            header("Location: admin/users.php");
            exit;
        } else {
            $errors[] = "Database error: " . mysqli_error($conn);
        }
    }
}
?>



<body>
    <div class="container">
        <h2>Create Account</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form action="users.php" method="post">
            <div class="input-group">
                <div class="form-group">
                    <label for="Email">EMAIL ADDRESS</label>
                    <input type="email" class="form-control" name="email" id="Email" placeholder="john@gmail.com">
                </div>
            </div>
            <div class="input-group">
                <label for="first_name">FIRST NAME</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="john">
            </div>
            <div class="input-group">
                <label for="last_name">LAST NAME</label>
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="doe">
            </div>
            
            <div class="input-group">
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="">
                </div>
            </div>
            
            <div class="input-group">
                <div class="form-group">
                    <label for="status">STATUS</label>
                    <select name="status" class="form-control" id="status">
                        <option value="">-- Select Status --</option>
                        <option value="1" <?= $status === "1" ? "selected" : "" ?>>Active</option>
                        <option value="0" <?= $status === "0" ? "selected" : "" ?>>Inactive</option>
                    </select>
                </div>
            </div>


            <div class="input-group">
                <label for="address1">ADDRESS</label>
                <textarea class="form-control" name="address" id="address1" placeholder="1234 Main St"></textarea>
            </div>
            
            <button herf="index.php" type="submit" class="btn">Register</button>
        </form>
    </div>
</body>
</html>