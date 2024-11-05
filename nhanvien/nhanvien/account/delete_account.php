<?php
require_once '../DBConnection.php';

// Kiểm tra nếu tham số ID được gửi đến
if (isset($_GET['id'])) {
    $soTaiKhoan = $_GET['id'];

    // Kết nối đến cơ sở dữ liệu
    $db = new DBConnection();
    $conn = $db->connect();

    // Thực hiện câu lệnh xóa tài khoản
    $stmt = $conn->prepare("DELETE FROM TaiKhoan WHERE SoTaiKhoan = :soTaiKhoan");
    $stmt->bindParam(':soTaiKhoan', $soTaiKhoan, PDO::PARAM_INT);

    // Kiểm tra nếu xóa thành công
    if ($stmt->execute()) {
        // Quay lại trang quản lý tài khoản với thông báo thành công
        header("Location: account_management.php?message=deleted");
        exit();
    } else {
        // Nếu xóa thất bại, quay lại trang quản lý tài khoản với thông báo lỗi
        header("Location: account_management.php?message=error");
        exit();
    }
} else {
    // Nếu không có ID, quay lại trang quản lý tài khoản
    header("Location: account_management.php");
    exit();
}
