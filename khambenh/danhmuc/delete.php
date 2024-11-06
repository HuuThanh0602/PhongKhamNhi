<?php
session_start();
require_once '../Database/DBConnection.php';

// Kiểm tra nếu có tham số 'maXetNghiem' trong URL
if (isset($_GET['id'])) {
    $maXetNghiem = $_GET['id'];

    // Kết nối cơ sở dữ liệu
    $db = new DBConnection();
    $conn = $db->connect();

    try {
        // Kiểm tra nếu MaXetNghiem có tồn tại trong bảng
        $stmt = $conn->prepare("SELECT COUNT(*) FROM DanhMucXetNghiem WHERE MaXetNghiem = :maXetNghiem");
        $stmt->execute(['maXetNghiem' => $maXetNghiem]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            // Xóa bản ghi khỏi cơ sở dữ liệu
            $stmt = $conn->prepare("DELETE FROM DanhMucXetNghiem WHERE MaXetNghiem = :maXetNghiem");
            $stmt->execute(['maXetNghiem' => $maXetNghiem]);

            // Lưu thông báo vào session
            $_SESSION['message'] = 'Xóa thành công!';
            header('Location: DanhMucKham.php');
            exit();
        } else {
            $_SESSION['message'] = 'Mã Xét Nghiệm không tồn tại!';
            header('Location: DanhMucKham.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Lỗi: ' . $e->getMessage();
        header('Location: DanhMucKham.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Không tìm thấy mã xét nghiệm!';
    header('Location: DanhMucKham.php');
    exit();
}
?>
