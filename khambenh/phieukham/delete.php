<?php
session_start();
require_once '../../Database/DBConnection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kết nối cơ sở dữ liệu
    $db = new DBConnection();
    $conn = $db->connect();

    // Truy vấn xóa phiếu khám
    $query = "DELETE FROM PhieuKham WHERE MaPhieuKham = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Lưu thông báo thành công vào session
        $_SESSION['message'] = 'Xóa phiếu khám thành công!';
    } else {
        // Lưu thông báo lỗi vào session
        $_SESSION['message'] = 'Lỗi khi xóa phiếu khám!';
    }

    // Chuyển hướng trở lại trang danh sách
    header('Location: phieukham.php');
    exit();
} else {
    // Nếu không có id, chuyển hướng về trang danh sách
    header('Location: phieukham.php');
    exit();
}
?>
