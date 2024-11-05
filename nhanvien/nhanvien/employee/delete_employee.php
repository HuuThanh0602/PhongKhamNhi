<?php
require_once '../DBConnection.php';

if (isset($_GET['id'])) {
    $db = new DBConnection();
    $conn = $db->connect();

    // Xóa nhân viên
    $stmt = $conn->prepare("DELETE FROM NhanVien WHERE MaNhanVien = :id");
    $stmt->execute(['id' => $_GET['id']]);

    header("Location: employee_management.php");
    exit();
} else {
    header("Location: employee_management.php");
    exit();
}
?>
