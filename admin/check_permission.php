<?php

include("config.php");

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    header("Location: ../index.php");
    exit;
}

$currentPage = basename($_SERVER['PHP_SELF']);  // example: 'dashboard.php'

$roleId = $_SESSION['role_id'];
$sql = "SELECT p.page_name FROM role_permission rp 
        JOIN permissions p ON rp.permission_id = p.id 
        WHERE rp.role_id = $roleId";

$result = mysqli_query($conn, $sql);
$allowedPages = [];

while ($row = mysqli_fetch_assoc($result)) {
    $allowedPages[] = $row['page_name'];
}

// If not allowed, redirect
if (!in_array($currentPage, $allowedPages)) {
    echo "<script>alert('Access Denied: You do not have permission to view this page.'); window.location.href='category.php';</script>";
    exit;
}
?>



