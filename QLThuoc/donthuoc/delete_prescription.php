<?php
session_start(); // Khởi động phiên

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Chuyển hướng về trang đăng nhập
    exit();
}

require_once '../../Database/DBConnection.php';

if (isset($_GET['id'])) {
    $maDon = $_GET['id'];

    $db = new DBConnection();
    $conn = $db->connect();

    try {
        // Bắt đầu transaction
        $conn->beginTransaction();

        // Xóa các bản ghi liên quan trong bảng ChiTietDonThuoc
        $stmt = $conn->prepare("DELETE FROM ChiTietDonThuoc WHERE MaDon = :maDon");
        $stmt->execute(['maDon' => $maDon]);

        // Xóa bản ghi trong bảng donthuoc
        $stmt = $conn->prepare("DELETE FROM donthuoc WHERE MaDon = :maDon");
        $stmt->execute(['maDon' => $maDon]);

        // Commit transaction
        $conn->commit();

        header("Location: donthuoc.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollBack();
        echo "Failed: " . $e->getMessage();
    }
} else {
    header("Location: donthuoc.php");
    exit();
}
?>