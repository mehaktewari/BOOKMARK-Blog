<?php
$conn = mysqli_connect("localhost", "root", "", "new_blogs");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>