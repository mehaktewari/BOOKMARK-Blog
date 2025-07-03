<?php
include("admin/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Escape user input
    $full_name = mysqli_real_escape_string($conn, $_POST['name']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $subject   = mysqli_real_escape_string($conn, $_POST['subject']);
    $message   = mysqli_real_escape_string($conn, $_POST['message']);
    $send_on   = date('Y-m-d H:i:s');

    $check_sql="SELECT * From contacts Where email_id='$email'";
    $check_result=mysqli_query($conn,$check_sql);

    if(mysqli_num_rows($check_result)> 0) {
        header("Location:index.php?status=error");
        exit();
    }
    else{
        $query = "INSERT INTO contacts (full_name, email_id, subject, message, send_on) 
              VALUES ('$full_name', '$email', '$subject', '$message', '$send_on')";

        if (mysqli_query($conn, $query)) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: index.php?status=error");
            exit;
        }
    }
}
?>
